<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador de pagina politica de privacidad
|--------------------------------------------------------------------------
| Ubicacion: application/controllers
| 
|
*/
class Policy extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if($this->input->is_ajax_request())
		{
			$modal['modalId'] = 'modal-show-policy';
			$modal['modalAttribs'] = 'modal-frame modal-notify modal-info';
			$modal['modalTitle'] = $this->lang->line('text-privacy-policy');
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/privacity-policy", NULL, TRUE);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	// Aceptacion politica de cookies
	public function accept()
	{
		if($this->input->is_ajax_request())
		{
			set_cookie($this->config->item('dtr-cookie-accept'));
		}
	}
}