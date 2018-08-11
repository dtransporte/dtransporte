<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador envio de solicitud
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Requirements
| 
|
*/
class Send extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER'])  OR $this->init->activeUser->user_role != 'user' OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		$this->config->load('config.requirements');
		$this->lang->load('requirement', $this->init->activeLang);
		$this->load->model('Requirements/getRequirement');
		$this->load->model('Requirements/sendRequirement');
		// $this->load->model('Requirements/setViews');
		// $this->load->model('currencies');
	}

	function index()
	{
		if($this->input->is_ajax_request())
		{
			$msg = $this->lang->line('dtr-message-email-send-error');
			$id_requirement = $this->input->get('id_requirement', TRUE);
			$req = $this->getRequirement->get($id_requirement);
			if($this->sendRequirement->send($req))
			{
				$data['requirement_status'] = 'active';
				$this->db->where('id_requirement', $id_requirement);
				$this->db->update('dtr_requirements', $data);

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
			$id_requirement = $this->input->get('id_requirement', TRUE);
			$req = $this->getRequirement->get($id_requirement);
			$data['requirement_name'] = $req[0]->requirement_name;
			$modal['modalSize'] = 'modal-lg';
			$modal['modalId'] = 'modal-requirement-send-confirm';
			$modal['modalAttribs'] = 'modal-side modal-top-right modal-notify modal-primary';
			$modal['modalTitle'] = $this->lang->line('text-send-requirement');
			$modal['modalFooter'] = $this->_setButtons();
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/requirements/modal-send-confirm", $data, TRUE);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	private function _setButtons()
	{
		return "<button type=\"button\" class=\"btn btn-primary btn-lg btn-send btn-block\" id=\"btn-send\"><i class=\"fas fa-envelope\"></i> {$this->lang->line('text-send')}</button>";
	}
}