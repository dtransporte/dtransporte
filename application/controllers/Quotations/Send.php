<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador envio de solicitud
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Quotations
| 
|
*/
class Send extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER'])  OR $this->init->activeUser->user_role != 'assoc' OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		$this->load->model('Quotations/sendQuotation');
		$this->load->model('Quotations/getQuotations');
	}

	function index()
	{
		if($this->input->is_ajax_request())
		{
			$id_quotation = $this->input->get('id_quotation', TRUE);
			$msg = $this->lang->line('dtr-message-email-send-error');
			if($this->sendQuotation->send($id_quotation))
			{
				$data['quotation_status'] = 'active';
				$data['quotation_sent'] = mdate($this->config->item('dtr-datetime-db'), now($this->init->activeUser->user_timezone));
				$this->db->where('id_quotation', $id_quotation);
				$this->db->update('dtr_quotations', $data);

				$msg = $this->lang->line('dtr-message-email-send-ok');
				$msg['href'] = '';
				$msg['duration'] = 3000;
			}
			echo json_encode($msg);
		}
	}

	function confirm()
	{
		if($this->input->is_ajax_request())
		{
			$id_quotation = $this->input->get('id_quotation', TRUE);
			$quotation = $this->getQuotations->get($id_quotation);
			$data['quotation_code'] = $quotation[0]->quotation_code;
			$modal['modalSize'] = 'modal-lg';
			$modal['modalId'] = 'modal-quotation-send-confirm';
			$modal['modalAttribs'] = 'modal-side modal-top-right modal-notify modal-primary';
			$modal['modalTitle'] = $this->lang->line('text-quotation-send');
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