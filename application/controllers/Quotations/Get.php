<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador obtiene cotizaciones via jajax
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Quotations
| 
|
*/
class Get extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']) OR $this->init->activeUser->user_role != 'assoc'  OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		$this->lang->load('tables', $this->init->activeLang);
		$this->lang->load('quotation', $this->init->activeLang);
		$this->load->model('Quotations/getQuotations');
		$this->load->model('Quotations/setTable');
		$this->load->model('Products/getproducts');
		$this->load->model('currencies');
	}

	function index()
	{
		if($this->input->is_ajax_request())
		{
			$data['quotations'] = $this->lang->line('dtr-tbl-user-quotations');
			$quotations = $this->getQuotations->get(NULL, NULL, $this->init->activeUser->id_user);
			$data['quotations']['data'] = $this->setTable->set($quotations, $data['quotations']['columns']);

			$data['requirementsPending'] = $this->lang->line('dtr-tbl-assoc-requirements-pending');
			$requirements = $this->getQuotations->getRequirementNoQuoted($this->init->activeUser->id_user);
			$data['requirementsPending']['data'] = $this->setTable->set($requirements, $data['requirementsPending']['columns']);
			
			echo json_encode($data);
		}
	}
}