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
class Cancel extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER'])  OR $this->init->activeUser->user_role != 'assoc' OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		$this->load->model('Quotations/cancelQuotation');
		$this->load->model('Quotations/getQuotations');
		$this->load->model('Requirements/getRequirement');
		$this->load->model('faults');
	}

	function index()
	{
		if($this->input->is_ajax_request())
		{
			$idMessage = 'dtr-message-quotation-cancel-error';
			$id_quotation = $this->input->get('id_quotation', TRUE);
			if($this->cancelQuotation->cancel($id_quotation) == TRUE)
			{
				$idMessage = 'dtr-message-quotation-cancel-ok';
			}
			echo json_encode($this->lang->line($idMessage));
		}
	}

	function confirm()
	{
		if($this->input->is_ajax_request())
		{
			$id_quotation = $this->input->get('id_quotation', TRUE);
			$quot = $this->getQuotations->get($id_quotation);
			$data['quotation_code'] = $quot[0]->quotation_code;
			$data['fault'] = $this->faults->set(NULL, $id_quotation);

			$modal['modalSize'] = 'modal-lg';
			$modal['modalId'] = 'modal-quotation-cancel-confirm';
			$modal['modalAttribs'] = 'modal-side modal-top-right modal-notify modal-warning';
			$modal['modalTitle'] = $this->lang->line('text-cancel-quotation');
			$modal['modalFooter'] = $this->_setButtons();
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/quotations/modal-cancel-confirm", $data, TRUE);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	private function _setButtons()
	{
		return "<button type=\"button\" class=\"btn btn-warning btn-lg btn-block\" id=\"btn-cancel\"><i class=\"fas fa-ban\"></i> {$this->lang->line('text-cancel-requirement')}</button>";
	}
}