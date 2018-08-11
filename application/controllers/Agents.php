<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador de pagina mostrar tipos de navegador (agentes)
|--------------------------------------------------------------------------
| Ubicacion: application/controllers
| 
|
*/
class Agents extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		if($this->input->is_ajax_request())
		{
			if ($this->agent->is_browser())
			{
				$data['agent'] = $this->agent->browser();
				$data['version'] = $this->agent->version();
				$data['platform'] = $this->agent->platform();
				$data['http'] = $this->config->item('dtr-browsers')[$data['agent']];
			}
			$modal['modalSize'] = 'modal-lg';
			$modal['modalAttribs'] = 'modal-side modal-top-right modal-notify modal-info';
			$modal['modalId'] = 'modal-agents';
			$modal['modalTitle'] = $this->lang->line('text-enable-cookies');
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/agents", $data, TRUE);

			echo $this->load->view("modal", $modal, TRUE);
		}
	}
}