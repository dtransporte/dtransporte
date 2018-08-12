<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador eliminacion de cotizacion
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Quotations
| 
|
*/
class Delete extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER'])  OR $this->init->activeUser->user_role != 'assoc' OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		$this->load->model('Quotations/getQuotations');
	}

	function index()
	{
		if($this->input->is_ajax_request())
		{
			$id_quotation = $this->input->get('id_quotation', TRUE);
			$msg = $this->lang->line('dtr-message-quotation-delete-error');

			$this->db->where('id_quotation', $id_quotation);
			if($this->db->delete('dtr_quotations'))
			{
				$msg = $this->lang->line('dtr-message-quotation-delete-ok');
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
			$modal['modalId'] = 'modal-quotation-delete-confirm';
			$modal['modalAttribs'] = 'modal-side modal-top-right modal-notify modal-danger';
			$modal['modalTitle'] = $this->lang->line('text-delete-quotation');
			$modal['modalFooter'] = $this->_setButtons();
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/quotations/modal-delete-confirm", $data, TRUE);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	private function _setButtons()
	{
		return "<button type=\"button\" class=\"btn btn-danger btn-lg btn-delete btn-block\" id=\"btn-send\"><i class=\"fas fa-trash\"></i> {$this->lang->line('text-delete')}</button>";
	}
}