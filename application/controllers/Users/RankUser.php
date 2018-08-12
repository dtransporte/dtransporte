<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador pagina ranking usuarios
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Users
| 
|
*/
class RankUser extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']) OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		// $this->lang->load('requirement', $this->init->activeLang);
		// $this->lang->load('tables', $this->init->activeLang);
		$this->load->model('Requirements/getRequirement');
		$this->load->model('Quotations/getQuotations');
		$this->load->model('ranking');
	}

	function index()
	{
		if($this->input->is_ajax_request())
		{
			$id_requirement = $this->input->get('id_requirement', TRUE);
			$id_quotation = $this->input->get('id_quotation', TRUE);
			$requirement = $this->getRequirement->get($id_requirement);
			if($this->init->activeUser->user_role === 'user')
			{
				$quotation = $this->getQuotations->get($id_quotation);
				$user = $this->getusers->get($quotation[0]->id_assoc);
				$companyName = $user->company_name;
			}
			else
			{
				$user = $this->getusers->get($requirement[0]->id_user);
				$companyName = empty($user->company_name) ? $user->user_first_name.' '.$user->user_last_name : $user->company_name;
			}

			$data['company'] = $companyName;
			$data['requirement_name'] = $requirement[0]->requirement_name;
			$data['id_requirement'] = $requirement[0]->id_requirement;
			$data['ranking_concepts'] = $this->ranking->getConcepts();
			$data['ranking_values'] = $this->config->item('dtr-ranking');

			$modal['modalSize'] = '';
			$modal['modalId'] = 'modal-show-ranking';
			$modal['modalAttribs'] = 'modal-side modal-top-right modal-notify modal-primary';
			$modal['modalTitle'] = $this->lang->line('text-ranking');
			$modal['modalFooter'] = $this->_setButtons();
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/requirements/modal-ranking", $data, TRUE);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	private function _setButtons()
	{
		$btn[] = "<button type=\"button\" class=\"btn btn-primary btn-lg\" id=\"btn-rank\"><span class=\"fas fa-check\"></span> {$this->lang->line('text-add')}</button>";
		$btn[] = "<button type=\"button\" class=\"btn btn-default btn-lg\" data-dismiss=\"modal\"><span class=\"fas fa-times\"></span> {$this->lang->line('text-cancel')}</button>";
		return implode('', $btn);
	}

	function insert()
	{
		if($this->input->is_ajax_request())
		{
			$idMessage = 'dtr-message-ranking-error';
			$data = $this->input->post(NULL, TRUE);
			if($this->ranking->insert($data))
			{
				$idMessage = 'dtr-message-ranking-ok';
			}
			echo json_encode($this->lang->line($idMessage));
		}
	}

	function show()
	{
		if($this->input->is_ajax_request())
		{
			$this->lang->load('tables', $this->init->activeLang);
			$ranking = $this->ranking->get($this->init->activeUser->id_user);

			$data['ranking'] = $this->lang->line('dtr-tbl-users-ranking');
			$data['ranking']['data'] = $this->ranking->setTable($ranking, $data['ranking']['columns']);

			$modal['modalSize'] = 'modal-lg';
			$modal['modalId'] = 'modal-user-ranking';
			$modal['modalAttribs'] = 'modal-top modal-notify modal-primary';
			$modal['modalTitle'] = $this->lang->line('text-ranking');
			//$modal['modalFooter'] = $this->_setButtons();
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/requirements/modal-user-ranking", $data, TRUE);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	function getSubTable()
	{
		if($this->input->is_ajax_request())
		{
			$this->lang->load('tables', $this->init->activeLang);

			$id_ranking = $this->input->get('id_ranking', TRUE);
			$ranked_by = $this->input->get('ranked_by', TRUE);

			$ranking = $this->ranking->getDetail($id_ranking, $ranked_by);
			$data = $this->lang->line('dtr-subtbl-users-ranking');
			$data['data'] = $this->ranking->setTable($ranking, $data['columns']);

			echo json_encode($data);
		}
	}
}