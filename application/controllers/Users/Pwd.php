<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador paises
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Users
| 
|
*/
class Pwd extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']) OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		$this->lang->load('validation', $this->init->activeLang);
		$this->load->model('password');
	}

	public function index()
	{
		if($this->input->is_ajax_request())
		{
			// Longitud de contrasenias
			$data['minMaxPwd'] = $this->password->setLength();
			$data['showCurPwd'] = TRUE;
			$modal['modalSize'] = 'modal-lg';
			$modal['modalId'] = 'modal-show-change-pwd';
			$modal['modalAttribs'] = 'modal-dialog-centered modal-notify modal-primary';
			$modal['modalTitle'] = $this->lang->line('text-password');
			$modal['modalFooter'] = $this->_setButtons();
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/users/modal-change-pwd", $data, TRUE);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	public function update()
	{
		if($this->input->is_ajax_request())
		{
			$hash = $this->security->get_csrf_hash();
			$message = $this->lang->line('dtr-message-update-error');
			$this->load->model('Users/updateusers');
			$this->updateusers->tables = [
				'dtr_users'
			];
			$data = $this->input->post(NULL, TRUE);
			if($this->password->pwdVerify($data['cur-pwd'], $this->init->activeUser->user_pwd, $this->init->activeUser->id_user))
			{
				$data['user_pwd'] = $this->password->setPwd($data['new-pwd']);
				if($this->updateusers->update($data))
				{
					$message = $this->lang->line('dtr-message-update-ok');
					$message['duration'] = 2500;
					$message['href'] = '';
				}
			}
			else
			{
				$message = $this->lang->line('dtr-messager-curpwd-nomatch');
			}
			$result = [
				'hash' => $hash,
				'message' => $message
			];
			echo json_encode($result);
		}
	}

	private function _setButtons()
	{
		return "<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\"><span class=\"fas fa-times\"></span> {$this->lang->line('text-cancel')}</button>";
	}
}