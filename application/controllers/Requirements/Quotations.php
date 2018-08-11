<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador muestra cotizaciones asociadas a una solicitud
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Requirements
| 
|
*/
class Quotations extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER'])  OR $this->init->activeUser->user_role != 'user' OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		$this->lang->load('incoterm', $this->init->activeLang);
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
			$id_requirement = $this->input->get('id_requirement', TRUE);
			$quotations = $this->getQuotations->get(NULL, $id_requirement);
			if(count($quotations) == 0)
			{
				echo 0;
			}
			else
			{
				$quotations = $this->getQuotations->get(NULL, $id_requirement, NULL);
				$optype = $this->db->get_where('dtr_requirements_optype', ['id_requirement' => $id_requirement]);
				$quot['operationType'] = $optype->row();
				$cargoDetails = $this->db->get_where('dtr_requirements_detail', ['id_requirement' => $id_requirement]);
				$quot['cargoDetails'] = $cargoDetails->row();
				$quot['currencies'] = $this->currencies->get();
				$quot['quotation_code'] = $quotations[0]->quotation_code;

				$modal['modalSize'] = 'modal-lg';
				$modal['modalId'] = 'modal-user-quotation-show';
				$modal['modalAttribs'] = 'modal-full-height modal-top modal-notify modal-info';
				$modal['modalTitle'] = $this->lang->line('text-quotations').' '.$quotations[0]->requirement_name;
				$modal['modalFooter'] = $this->_setButtons();
				$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/requirements/modal-user-quotations", $quot, TRUE);
				echo $this->load->view('modal', $modal, TRUE);
			}
		}
	}

	function get()
	{
		if($this->input->is_ajax_request())
		{
			$id_requirement = $this->input->get('id_requirement', TRUE);
			$data = $this->lang->line('dtr-tbl-user-requirements-quotations');
			$quotations = $this->getQuotations->get(NULL, $id_requirement);
			$data['data'] = $this->setTable->set($quotations, $data['columns']);
			if($quotations[0]->requirement_status === 'active')
			{
				$data['detailView'] = TRUE;
			}
			
			echo json_encode($data);
		}
	}

	private function _setButtons()
	{
		$btns[] = "<button type=\"button\" class=\"btn btn-primary btn-lg no-print\" id=\"btn-print\"><i class=\"fas fa-print\"></i> {$this->lang->line('text-print')}</button>";
		$btns[] = "<button type=\"button\" class=\"btn btn-default btn-lg no-print\" data-dismiss=\"modal\"><i class=\"fas fa-times\"></i> {$this->lang->line('text-cancel')}</button>";
		return implode('', $btns);
	}
}