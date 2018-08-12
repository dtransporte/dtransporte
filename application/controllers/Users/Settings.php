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
class Settings extends CI_Controller
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
		$this->load->model('currencies');
	}

	public function index()
	{
		if($this->input->is_ajax_request())
		{
			// Listado de monedas
			$data['currencies'] = $this->currencies->get();

			// Listado de idiomas
			$data['languages'] = $this->config->item('dtr-languages');

			// Listado de formatos de fecha
			$data['dateFormat'] = $this->config->item('dtr-date-format');

			// Listado de formatos de hora
			$data['timeFormat'] = $this->config->item('dtr-time-format');

			// Listado de fuentes disponibles
			$data['fontFamily'] = $this->config->item('dtr-font-family');

			// Listado de tamanios fuentes disponibles
			$data['fontSize'] = $this->config->item('dtr-font-size');

			// Listado de estilos de menu
			$data['menuStyle'] = $this->lang->line('dtr-menu-style');

			// Duracion de bloqueo de pantalla
			$data['blockScrDuration'] = $this->config->item('dtr-block-screen-duration');

			$modal['modalSize'] = 'modal-lg';
			$modal['modalId'] = 'modal-show-settings';
			$modal['modalAttribs'] = 'modal-dialog-centered modal-notify modal-primary';
			$modal['modalTitle'] = $this->lang->line('text-settings');
			$modal['modalFooter'] = $this->_setButtons();
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/users/modal-settings-data", $data, TRUE);
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
				'dtr_user_settings'
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