<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador muestra cierre de solicitud
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Requirements
| 
|
*/
class Close extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER'])  OR $this->init->activeUser->user_role != 'user' OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		// $this->config->load('config.requirements');
		//$this->lang->load('quotation', $this->init->activeLang);
		$this->load->model('Requirements/closeRequirement');
		$this->load->model('Products/getproducts');
		$this->load->model('currencies');
	}

	function index()
	{
		if($this->input->is_ajax_request())
		{
			$idMessage = 'dtr-message-requirement-close-error';
			$data = $this->input->get(NULL, TRUE);
			if($this->closeRequirement->close($data))
			{
				$idMessage = 'dtr-message-requirement-close-ok';
			}
			echo json_encode($this->lang->line($idMessage));
		}
	}
}