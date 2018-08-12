<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador de pagina registro de usuarios
|--------------------------------------------------------------------------
| Ubicacion: application/controllers
| 
|
*/
class RegisterUser extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(isset($_SESSION['DTRANSPORTE-USER']))
		{
			$this->init->redirectTo();
		}

		$this->load->helper('string');
		$this->load->model('Users/addusers');
		$this->load->model('password');
	}

	public function index()
	{
		if($this->input->is_ajax_request())
		{
			$messageId = 'dtr-message-registration-user-exists';
			$data = $this->input->post(NULL, TRUE);
			$user_name = trim($data['user_name']);
			$userExists = $this->getusers->exists($user_name);
			if($userExists === FALSE)
			{
				$messageId = 'dtr-message-registration-error';

				/*
					Establece la contrasenia del usuario
				*/
				$pwd = random_string('alnum', 6);
				$data['user_pwd'] = $this->password->setPwd($pwd);

				/*
					Establece el hash que sera enviado por email para validacion del usuario
				*/
				$hash = random_string('alnum', 10);
				$data['user_hash'] = sha1($hash);

				/*
					Establece la fecha de expiracion del registro
				*/
				$timestamp = now($data['user_timezone'])+$this->config->item('dtr-max-validation-time');
				$data['date_expiration'] = mdate($this->config->item('dtr-datetime-db'), $timestamp);

				$data['user_entered'] = mdate($this->config->item('dtr-datetime-db'), now($data['user_timezone']));

				/*
					Registra al usuario y envia un correo con los datos de validacion
				*/
				if($this->addusers->add($data))
				{
					$user_id = $this->addusers->lastId;
					$this->load->model('mail');
					$this->lang->load('mail-tpl', $this->init->activeLang);
					$this->mail->from = [
						'email' => $this->config->item('dtr-default-email'), 
						'name' => 'dTransporte'
					];
					$this->mail->to = [$user_name];
					$this->mail->subject = $this->lang->line('text-welcome-to').' dTransporte';

					$body = $this->lang->line('tpl-registration-form');

					$search = [
						'%username%',
						'%userpwd%',
						'%baseurl%',
						'%userid%',
						'%userhash%'
					];
					$replace = [
						$user_name,
						$pwd,
						base_url(),
						$user_id,
						$data['user_hash']
					];
					$body['tplContent'] = str_replace($search, $replace, $body['tplContent']);
					$this->mail->message = $this->load->view('mail-tpl', $body, TRUE);
					if($this->mail->send())
					{
						$messageId = 'dtr-message-registration-ok';
					}
					else
					{
						$this->load->model('deleteusers');
						$this->deleteusers->delete($user_id);
					}
				}
			}
			echo json_encode($this->lang->line($messageId));
		}
	}
}