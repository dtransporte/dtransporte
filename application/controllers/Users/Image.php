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
class Image extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']) OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
	}

	public function index()
	{
		if($this->input->is_ajax_request())
		{
			// Carga la configuracion de archivos para ser subidos al servidor
			// Elimino los filtros para archivos que no son imagenes
			$imgCfg = $this->config->item('dtr-upload-files');
			unset($imgCfg['filters']['mime_types'][1]);
			$imgCfg['multi_selection'] = 0;
			$imgCfg['multipart_params']['isUserImage'] = 1;
			$imgCfg['multipart_params']['upload_path'] = '%user_path%/me';
			//$imgCfg['multipart_params'][$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
			$data['imgCfg'] = $imgCfg;

			$modal['modalSize'] = 'modal-lg';
			$modal['modalId'] = 'modal-show-change-image';
			$modal['modalAttribs'] = 'modal-dialog-centered modal-notify modal-primary';
			$modal['modalTitle'] = $this->lang->line('text-upload-image');
			$modal['modalFooter'] = $this->_setButtons();
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/users/modal-user-image", $data, TRUE);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	private function _setButtons()
	{
		return "<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\"><span class=\"fas fa-times\"></span> {$this->lang->line('text-cancel')}</button>";
	}
}