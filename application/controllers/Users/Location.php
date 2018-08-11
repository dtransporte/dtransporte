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
class Location extends CI_Controller
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
		$this->load->model('countries');
	}

	public function index()
	{
		if($this->input->is_ajax_request())
		{
			$data['countries'] = $this->countries->get();
			$modal['modalSize'] = 'modal-lg';
			$modal['modalId'] = 'modal-show-location-data';
			$modal['modalAttribs'] = 'modal-dialog-centered modal-notify modal-primary';
			$modal['modalTitle'] = $this->lang->line('text-location');
			$modal['modalFooter'] = $this->_setButtons();
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/users/modal-location-data", $data, TRUE);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	public function update()
	{
		if($this->input->is_ajax_request())
		{
			$message = $this->lang->line('dtr-message-update-error');
			$this->load->model('Users/updateusers');
			$this->updateusers->tables = [
				'dtr_address'
			];
			$data = $this->input->post(NULL, TRUE);
			if($this->updateusers->update($data))
			{
				$message = $this->lang->line('dtr-message-update-ok');
				$message['duration'] = 2500;
				$message['href'] = '';
			}
			$result = [
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