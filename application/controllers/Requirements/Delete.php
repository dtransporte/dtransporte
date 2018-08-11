<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador eliminacion de solicitud
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Requirements
| 
|
*/
class Delete extends CI_Controller
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
	}

	function index()
	{
		if($this->input->is_ajax_request())
		{
			$idMessage = 'dtr-message-requirement-delete-error';
			$id_requirement = $this->input->get('id_requirement', TRUE);
			$path = FCPATH."dtr-requirements/{$id_requirement}";

			$this->db->trans_start();
				$this->db->where('id_requirement', $id_requirement);
				$this->db->delete('dtr_requirements');
			$this->db->trans_complete();

			if($this->db->trans_status() == TRUE AND delete_files($path, TRUE))
			{
				$idMessage = 'dtr-message-requirement-delete-ok';
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
			$modal['modalSize'] = 'modal-lg';
			$modal['modalId'] = 'modal-requirement-delete-confirm';
			$modal['modalAttribs'] = 'modal-side modal-top-right modal-notify modal-danger';
			$modal['modalTitle'] = $this->lang->line('text-delete-requirement');
			$modal['modalFooter'] = $this->_setButtons();
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/requirements/modal-delete-confirm", $data, TRUE);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	private function _setButtons()
	{
		return "<button type=\"button\" class=\"btn btn-danger btn-lg btn-block\" id=\"btn-delete\"><i class=\"fas fa-trash-alt\"></i> {$this->lang->line('text-delete')}</button>";
	}
}