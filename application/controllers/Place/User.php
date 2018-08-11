<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador pagina inicio rol usuario
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Home
| 
|
*/
class User extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']) OR $this->init->activeUser->user_role != 'user'  OR $this->init->activeUser->user_first_time == 1)
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
		$this->data['activePage'] = $this->config->item('dtr-user-files');
		$this->data['menuItems'] = $this->lang->line('dtr-user-menu');

		// Carga las solicitudes del usuario activo
		$this->data['requirements'] = $this->getRequirement->get(NULL, $this->init->activeUser->id_user);

		// Carga las cotizaciones del usuario activo
		$this->data['quotations'] = $this->getQuotations->getByUser($this->init->activeUser->id_user);

		// Carga las penalizaciones del usuario activo
		$this->data['faults'] = $this->faults->getTotal($this->init->activeUser->id_user);

		// Carga el ranking del usuario activo
		$this->data['rankingValues'] = $this->config->item('dtr-ranking');
		$this->data['ranking'] = $this->ranking->getTotal($this->init->activeUser->id_user);

		$message = json_encode($this->lang->line('dtr-message-requirement-no-quotations'));
		$this->data['activePage']['fns'][] = "var NoRelatedQutos = {$message};\n";

		$userDtf = str_replace(['%d', '%m', '%Y', '%H', '%i', '%s', '%a'], ['DD', 'MM', 'YYYY', 'HH', 'mm', '', ''], $this->init->activeUser->dtf);
		$userDtf = trim($userDtf);
		$this->data['activePage']['fns'][] = "var UserDtf = '{$userDtf}';\n";

	}
}