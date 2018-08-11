<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Fpwd - Controlador muestra dialogo de olvido de contrasenia
| -------------------------------------------------------------------------
| 
|
| -------------------------------------------------------------------------
| Ubicacion
|	application/controllers
| -------------------------------------------------------------------------
*/
class Fpwd extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(isset($_SESSION['DTRANSPORTE-USER']) OR isset($_SESSION['DTRANSPORTE-EMPLOYEE']))
		{
			$this->init->redirectTo();
		}
		$this->load->model('Users/getusers');
		$this->load->model('password');
		$this->load->model('mail');
		$this->load->helper('string');
		$this->lang->load('mail-tpl', $this->init->activeLang);
		$this->lang->load('validation', $this->init->activeLang);
	}

	function index()
	{
		if($this->input->is_ajax_request())
		{
			$user_name = $this->input->post('user_fpwd', TRUE);

			$user = $this->getusers->get(NULL, trim($user_name));
			if(count($user) == 0)
			{
				$idMessage = 'dtr-message-user-no-exists';
			}
			elseif($user->user_active == 0)
			{
				$idMessage = 'dtr-message-user-no-active';
			}
			else
			{
				$query = $this->db->get_where('dtr_user_reset_pwd', ['id_user'=> $user->id_user]);
				if($query->num_rows() == 0)
				{
					/*
						Establece el hash que sera enviado por email para validacion del usuario
					*/
					$hash = random_string('alnum', 10);
					$data['user_hash'] = sha1($hash);

					$data['id_user'] = $user->id_user;
					$data['date_expiration'] = mdate($this->config->item('dtr-datetime-db'), now($user->user_timezone)+24*60*60);
					$this->db->insert('dtr_user_reset_pwd', $data);
					
					if($this->_sendPwd($user, $hash))
					{
						//$this->dmonolog->setAppInfo('monolog-reset-password', NULL, $user);
						$idMessage = 'dtr-message-email-send-ok';
					}
					else
					{
						$idMessage = 'dtr-message-email-send-error';
						$this->db->where('id_user', $user->user_id);
						$this->db->delete('dtr_user_reset_pwd');
						//$this->dmonolog->setDebugInfo('monolog-email-send-error', $this->mail->errors, $user);
					}
				}
				else
				{
					$idMessage = 'dtr-message-user-no-validated';
				}
			}
			//redirect(base_url().'index.php/home/index/'.$idMessage, 'refresh');
			echo json_encode($this->lang->line($idMessage));
		}
	}

	function showForm()
	{
		if($this->input->is_ajax_request())
		{
			$modal['modalId'] = 'modal-fpwd';
			$modal['modalAttribs'] = 'modal-lg modal-side modal-top-right modal-notify modal-danger';
			$modal['modalTitle'] = $this->lang->line('text-send-new-password');
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/users/fpwd", NULL, TRUE);
			$view = $this->load->view("modal", $modal, TRUE);
			echo $view;
		}
	}

	function _sendPwd($user, $hash)
	{
		$this->mail->to = [$user->user_name];

		$tpl = $this->lang->line('tpl-fpwd-form');
		$this->mail->subject = $tpl['subject'];
		$search = ['%baseurl%', '%userhash%', '%userid%'];
		$replace = [base_url(), sha1($hash), $user->id_user];
		$tpl['tplContent'] = str_replace($search, $replace, $tpl['tplContent']);

		$tpl['tplHeader'] = str_replace('%fullname%', $user->user_first_name.' '.$user->user_last_name, $tpl['tplHeader']);

		$tpl['tplAltBody'] = $this->lang->line('tpl-altBody');

		$body = $this->load->view('mail-tpl', $tpl, TRUE);
		$this->mail->message = $body;
		return $this->mail->send();
	}

	function validatePwd($id_user, $hash)
	{
		$query = $this->db->get_where('dtr_user_reset_pwd', ['id_user'=> $id_user, 'user_hash'=> $hash]);
		if($query->num_rows() > 0)
		{
			$data['minMaxPwd'] = $this->password->setLength();
			$data['hash'] = $hash;
			$data['user'] = $query->row();
			$data['action'] = base_url().'index.php/blockScr/unlockUser';
			$data['message'] = $this->lang->line('text-user-cant-use-same-pwd');
			$this->load->view("{$this->init->activeLang}/users/new-pwd", $data, 'refresh');
		}
		else
		{
			$this->load->view("{$this->init->activeLang}/validation/error");
		}
	}
}