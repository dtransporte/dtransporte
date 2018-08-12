<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador cancelacion de solicitud
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Requirements
| 
|
*/
class Visit extends CI_Controller
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
		$this->load->helper('string');
	}

	function index()
	{
		if($this->input->is_ajax_request())
		{
			$data = $this->input->post(NULL, TRUE);
			$requirement = $this->getRequirement->get($data['id_requirement']);
			$data['quotation_status']  =  'visit-accepted';
			$idMessage = 'dtr-message-quotation-sent-error' ;
			if($this->insertQuotation->insert($requirement[0], $data))
			{
				$idMessage = 'dtr-message-quotation-sent-ok';
			}
			echo json_encode($this->lang->line($idMessage));
		}
	}

	function confirm()
	{
		if($this->input->is_ajax_request())
		{
			// Establece la imagen y el texto del codigo qr
			$qrCode = $this->codeqr->get();
			$data['qrText'] = $this->codeqr->qrText;
			$data['qrImageSrc'] = $this->init->activeUser->userDir.'/qrcode.png';
			$data['quotation_code'] = random_string('numeric', 4);
			$modal['modalSize'] = 'modal-lg';
			$modal['modalId'] = 'modal-quotation-visit-confirm';
			$modal['modalAttribs'] = 'modal-side modal-top-right modal-notify modal-primary';
			$modal['modalTitle'] = $this->lang->line('text-send');
			$modal['modalFooter'] = $this->_setButtons();
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/quotations/modal-visit-confirm", $data, TRUE);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	private function _setButtons()
	{
		return "<button type=\"button\" class=\"btn btn-primary btn-lg btn-send btn-block\" id=\"btn-send\"><i class=\"fas fa-envelope\"></i> {$this->lang->line('text-send')}</button>";
	}
}