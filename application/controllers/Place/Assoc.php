<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador pagina inicio rol emaprsa
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Home
| 
|
*/
class Assoc extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']) OR $this->init->activeUser->user_role != 'assoc' OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		$this->lang->load('requirement', $this->init->activeLang);
		$this->lang->load('tables', $this->init->activeLang);
		$this->load->model('Requirements/getRequirement');
		$this->load->model('Quotations/getQuotations');
		$this->load->model('alerts');
		$this->load->model('ranking');
	}

	function index()
	{
		$this->_set();
		$this->load->view('index', $this->data);
	}

	function _set()
	{
		$alerts = $this->alerts->set();
		if(count($alerts) > 0)
		{
			$this->data['alerts'] = $alerts;
		}
		// Carga pagina activa y menu
		$this->data['activePage'] = $this->config->item('dtr-assoc-files');
		$this->data['menuItems'] = $this->lang->line('dtr-user-menu');

		// Carga las cotizaciones del usuario activo
		$this->data['quotations'] = $this->getQuotations->get(NULL, NULL, $this->init->activeUser->id_user);

		$rejectedQuotations = $this->db->get_where('dtr_quotations', ['quotation_status' => 'rejected', 'id_assoc' => $this->init->activeUser->id_user]);
		$this->data['rejectedQuotations'] = $rejectedQuotations->num_rows();

		$finishedQuotations = $this->db->get_where('dtr_quotations', ['quotation_status' => 'finish', 'id_assoc' => $this->init->activeUser->id_user]);
		$this->data['finishedQuotations'] = $finishedQuotations->num_rows();

		// Carga las solicitudes pendientes de cotizacion del usuario activo
		$this->data['requirementsPending'] = $this->getQuotations->getRequirementNoQuoted($this->init->activeUser->id_user);

		// Carga las penalizaciones del usuario activo
		$this->data['faults'] = $this->faults->getTotal($this->init->activeUser->id_user);

		// Carga el ranking del usuario activo
		$this->data['rankingValues'] = $this->config->item('dtr-ranking');
		$this->data['ranking'] = $this->ranking->getTotal($this->init->activeUser->id_user);
		$this->data['rankingDetail'] = $this->ranking->get($this->init->activeUser->id_user);
	}
}