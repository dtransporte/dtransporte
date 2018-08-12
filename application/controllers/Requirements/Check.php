<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador chequeos de solicitudes
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Requirements
| 
|
*/
class Check extends CI_Controller
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
		$this->load->model('Requirements/sendRequirement');
	}

	function  checkExpiredRequirement()
	{
		if($this->input->is_ajax_request())
		{
			$now = mdate($this->config->item('dtr-datetime-db'), now($this->init->activeUser->user_timezone));
			$where = "(requirement_expiration < '{$now}') AND (requirement_status = 'active' OR requirement_status = 'nosent' OR requirement_status = 'prog')";
			$this->db->where($where);
			$data['requirement_status'] = 'expired';
			$this->db->update('dtr_requirements', $data);
		}
	}

	function  checkProgramRequirement()
	{
		if($this->input->is_ajax_request())
		{
			$now = mdate($this->config->item('dtr-datetime-db'), now($this->init->activeUser->user_timezone));
			$this->db->where('requirement_programation <', $now);
			$this->db->where('requirement_status', 'prog');
			$prog = $this->db->get('dtr_requirements');

			if($prog->num_rows() > 0)
			{
				$data['requirement_status'] = 'active';
				$data['requirement_programation'] = NULL;
				$this->db->where('requirement_programation <', $now);
				$this->db->where('requirement_status', 'prog');
				$this->db->update('dtr_requirements', $data);
				foreach ($prog->result() as $req)
				{
					$r = $this->getRequirement->get($req->id_requirement);
					$this->sendRequirement->send($r);
				}
			}
			// $this->db->call_function('CheckExpiredRequirement', $timestamp);
		}
	}

	function checkFinishedRequirements()
	{
		if($this->input->is_ajax_request())
		{
			$now = mdate($this->config->item('dtr-datetime-db'), now($this->init->activeUser->user_timezone));
			$where = "requirement_schedule < '{$now}' AND requirement_status = 'closed'";
			$this->db->where($where);
			$data['requirement_status'] = 'finish';
			$this->db->update('dtr_requirements', $data);
		}
	}

	function checkFaultsExpiration()
	{
		if($this->input->is_ajax_request())
		{
			$now = mdate($this->config->item('dtr-datetime-db'), now($this->init->activeUser->user_timezone));
			$this->db->where('cancel_expiration <', $now);
			$this->db->delete('dtr_faults');
		}
	}
}