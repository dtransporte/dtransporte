<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador cancelacion cotizacion
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Requirements
| 
|
*/
class Resume extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']) OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		$this->lang->load('quotation', $this->init->activeLang);
		$this->load->model('Quotations/getQuotations');
		$this->load->model('currencies');
	}

	function index()
	{
		if($this->input->is_ajax_request())
		{
			$id_quotation = $this->input->get('id_quotation', TRUE);
			$quot = $this->getQuotations->get($id_quotation);
			$data['showConcepts'] = TRUE;
			if(count($quot) == 0)
			{
				// Se trata de una visita ya que no recoge los conceptos
				$quot = $this->getQuotations->get($id_quotation, NULL, NULL, TRUE);
				$data['showConcepts'] = FALSE;
			}

			$user = $this->getusers->get($quot[0]->id_assoc);
			$data['companyName'] = $user->company_name;

			$data['quotation'] = $quot;
			$data['currencies'] = $this->currencies->get();

			$modal['modalSize'] = 'modal-lg';
			$modal['modalId'] = 'modal-quotation-resume';
			$modal['modalAttribs'] = 'modal-side modal-top-right modal-notify modal-info';
			$modal['modalTitle'] = $this->lang->line('text-quotation'). ' '. $quot[0]->quotation_code;
			$modal['modalFooter'] = $this->_setButtons();
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/quotations/modal-resume", $data, TRUE);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	private function _setButtons()
	{
		return "<button type=\"button\" class=\"btn btn-primary btn-block no-print\" id=\"btn-print\"><i class=\"fas fa-print\"></i> {$this->lang->line('text-print')}</button>";
	}
}