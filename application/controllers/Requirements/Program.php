<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador programacion de solicitud
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Requirements
| 
|
*/
class Program extends CI_Controller
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
			$idMessage = 'dtr-message-requirement-prog-error';
			$id_requirement = $this->input->post('id_requirement', TRUE);
			$requirement_programation = $this->input->post('requirement_programation', TRUE);

			$data['requirement_programation'] = $requirement_programation;
			$data['requirement_status'] = 'prog';
			$this->db->where('id_requirement', $id_requirement);
			if($this->db->update('dtr_requirements', $data))
			{
				$idMessage = 'dtr-message-requirement-prog-ok';
			}
			echo json_encode(($this->lang->line($idMessage)));
		}
	}

	function confirm()
	{
		if($this->input->is_ajax_request())
		{
			$id_requirement = $this->input->get('id_requirement', TRUE);
			$req = $this->getRequirement->get($id_requirement);
			$data['id_requirement'] = $id_requirement;
			$data['requirement_name'] = $req[0]->requirement_name;
			$data['requirement_expiration'] = mysql_to_unix($req[0]->requirement_expiration);
			$modal['modalSize'] = 'modal-lg';
			$modal['modalId'] = 'modal-requirement-prog-confirm';
			$modal['modalAttribs'] = 'modal-side modal-top-right modal-notify modal-info';
			$modal['modalTitle'] = $this->lang->line('text-prog-requirement');
			$modal['modalFooter'] = $this->_setButtons();
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/requirements/modal-prog-confirm", $data, TRUE);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	function delete()
	{
		if($this->input->is_ajax_request())
		{
			$id_requirement = $this->input->get('id_requirement', TRUE);

			$data['requirement_programation'] = NULL;
			$data['requirement_status'] = 'nosent';
			$this->db->where('id_requirement', $id_requirement);
			$this->db->update('dtr_requirements', $data);
		}
	}

	private function _setButtons()
	{
		return "<button type=\"button\" class=\"btn btn-info btn-lg btn-block\" id=\"btn-prog\"><i class=\"far fa-clock\"></i> {$this->lang->line('text-prog')}</button>";
	}
}