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
class Cancel extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER'])  OR $this->init->activeUser->user_role != 'user' OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		$this->load->model('Requirements/getRequirement');
		$this->load->model('faults');
	}

	function index()
	{
		if($this->input->is_ajax_request())
		{
			$idMessage = 'dtr-message-requirement-cancel-error';
			$id_requirement = $this->input->get('id_requirement', TRUE);
			
			if($this->faults->insert($id_requirement))
			{
				$data['requirement_status'] = 'cancel';
				$data['requirement_cancelation'] = mdate($this->config->item('dtr-datetime-db'), now($this->init->activeUser->user_timezone));
				$this->db->where('id_requirement', $id_requirement);
				$this->db->update('dtr_requirements', $data);
				$idMessage = 'dtr-message-requirement-cancel-ok';
			}
			echo json_encode($this->lang->line($idMessage));
		}
	}

	function confirm()
	{
		if($this->input->is_ajax_request())
		{
			$id_requirement = $this->input->get('id_requirement', TRUE);
			$req = $this->getRequirement->get($id_requirement);
			$data['requirement_name'] = $req[0]->requirement_name;
			$data['fault'] = $this->faults->set($id_requirement);

			$modal['modalSize'] = 'modal-lg';
			$modal['modalId'] = 'modal-requirement-cancel-confirm';
			$modal['modalAttribs'] = 'modal-side modal-top-right modal-notify modal-warning';
			$modal['modalTitle'] = $this->lang->line('text-cancel-requirement');
			$modal['modalFooter'] = $this->_setButtons();
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/requirements/modal-cancel-confirm", $data, TRUE);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	private function _setButtons()
	{
		return "<button type=\"button\" class=\"btn btn-warning btn-lg btn-block\" id=\"btn-cancel\"><i class=\"fas fa-ban\"></i> {$this->lang->line('text-cancel-requirement')}</button>";
	}
}