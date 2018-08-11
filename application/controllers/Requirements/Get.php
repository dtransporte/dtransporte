<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador obtiene solicitudes via jajax
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Requirements
| 
|
*/
class Get extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']) OR $this->init->activeUser->user_role != 'user'  OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		$this->lang->load('tables', $this->init->activeLang);
		$this->lang->load('requirement', $this->init->activeLang);
		$this->load->model('Requirements/getRequirement');
		$this->load->model('Requirements/setTable');
		$this->load->model('Products/getproducts');
	}

	function index()
	{
		if($this->input->is_ajax_request())
		{
			$data = $this->lang->line('dtr-tbl-user-requirements');
			$requirements = $this->getRequirement->get(NULL, $this->init->activeUser->id_user);
			$data['data'] = $this->setTable->set($requirements, $data['columns']);
			echo json_encode($data);
		}
	}
}