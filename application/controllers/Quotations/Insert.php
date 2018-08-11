<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador agregar nueva cotizacion
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Quotations
| 
|
*/
class Insert extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER'])  OR $this->init->activeUser->user_role != 'assoc' OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		$this->config->load('config.requirements');
		$this->lang->load('requirement', $this->init->activeLang);
		$this->lang->load('quotation', $this->init->activeLang);
		$this->load->model('Products/getproducts');
		$this->load->model('Requirements/getRequirement');
		$this->load->model('Quotations/getQuotations');
		$this->load->model('Quotations/insertQuotation');
		$this->load->model('codeqr');
		$this->load->model('currencies');
	}

	function index()
	{
		if($this->input->is_ajax_request())
		{
			$data = $this->input->post(NULL, TRUE);
			$requirement = $this->getRequirement->get($data['id_requirement']);
			$idMessage = $data['quotation_status'] === 'nosent' ? 'dtr-message-quotation-error' : 'dtr-message-quotation-sent-error';
			if($this->insertQuotation->insert($requirement[0], $data))
			{
				$idMessage = $data['quotation_status'] === 'nosent' ? 'dtr-message-quotation-ok' : 'dtr-message-quotation-sent-ok';
			}
			echo json_encode($this->lang->line($idMessage));
		}
	}

	function confirm()
	{
		if($this->input->is_ajax_request())
		{
			$data['quotation_code'] = $this->input->get('quotation_code', TRUE);
			$modal['modalSize'] = 'modal-lg';
			$modal['modalId'] = 'modal-quotation-send-confirm';
			$modal['modalAttribs'] = 'modal-side modal-top-right modal-notify modal-primary';
			$modal['modalTitle'] = $this->lang->line('text-send-requirement');
			$modal['modalFooter'] = $this->_setButtons();
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/quotations/modal-send-confirm", $data, TRUE);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	private function _setButtons()
	{
		return "<button type=\"button\" class=\"btn btn-primary btn-lg btn-send btn-block\" id=\"btn-send\"><i class=\"fas fa-envelope\"></i> {$this->lang->line('text-send')}</button>";
	}
}