<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Actualiza los datos de usuario logueado
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Users
| 
|
*/
class Update extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']))
		{
			//$this->init->redirectTo();
			die('NO ACCESS');
		}
		$this->load->model('Users/updateusers');
	}

	function address()
	{
		if($this->input->is_ajax_request())
		{
			$data = $this->input->post(NULL, TRUE);
			$this->updateusers->tables = ['dtr_address'];
			echo $this->_update($data);
		}
	}

	function personal()
	{
		if($this->input->is_ajax_request())
		{
			$data = $this->input->post(NULL, TRUE);
			$this->updateusers->tables = ['dtr_users', 'dtr_phones', 'dtr_companies'];
			echo $this->_update($data);
		}
	}

	function settings()
	{
		if($this->input->is_ajax_request())
		{
			$data = $this->input->post(NULL, TRUE);
			$this->updateusers->tables = ['dtr_user_settings'];
			echo $this->_update($data);
		}
	}

	function password()
	{
		if($this->input->is_ajax_request())
		{
			$this->load->model('password');
			$data = $this->input->post(NULL, TRUE);
			$this->updateusers->tables = ['dtr_users'];
			if(isset($data['cur-pwd']))
			{
				$user_pwd = $this->password->get($this->init->activeUser->id_user);
				if($user_pwd !== $data['cur-pwd'])
				{
					echo json_encode(
						[
							'hash' => $this->security->get_csrf_hash(),
							'message' => $this->lang->line('dtr-messager-curpwd-nomatch')
						]
					);
					exit;
				}
			}
			$data['user_pwd'] = $this->password->setPwd($data['new-pwd']);
			echo $this->_update($data);
		}
	}

	private function _update($data)
	{
		$idMessage = 'dtr-message-update-error';
		if($this->updateusers->update($data))
		{
			$idMessage = 'dtr-message-update-ok';
		}
		return json_encode(
			[
				'hash' => $this->security->get_csrf_hash(),
				'message' => $this->lang->line($idMessage)
			]
		);
	}
}