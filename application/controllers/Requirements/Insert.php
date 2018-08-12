<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador insertar nueva solicitud
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Requirements
| 
|
*/
class Insert extends CI_Controller
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
		$this->lang->load('tables', $this->init->activeLang);
		$this->load->model('Products/getproducts');
		$this->load->model('Requirements/setViews');
		$this->load->model('Requirements/insertRequirement');
		$this->load->model('codeqr');
		$this->load->model('countries');
		$this->load->model('currencies');
	}

	function index()
	{
		if($this->input->is_ajax_request())
		{
			$messageId = 'dtr-message-requirement-error';
			$data = $this->input->post(NULL, TRUE);
			$csrf[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
			if($this->insertRequirement->insert($data))
			{
				$csrf = '';
				$messageId = 'dtr-message-requirement-ok';
			}
			$result = [
				'csrf' => $csrf,
				'msg' => $this->lang->line($messageId)
			];
			echo json_encode($result);
		}
	}
}