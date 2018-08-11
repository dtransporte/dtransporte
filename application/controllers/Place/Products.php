<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador pagina servicios asociados rol emaprsa
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Place
| 
|
*/
class Products extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']) OR $this->init->activeUser->user_role != 'assoc' OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		$this->lang->load('validation', $this->init->activeLang);
		$this->lang->load('countries', $this->init->activeLang);
		$this->load->model('countries');
		$this->load->model('Products/getproducts');
	}

	function index()
	{
		$this->_set();
		$this->load->view('index', $this->data);
	}

	function _set()
	{
		// Carga pagina activa y menu
		$this->data['activePage'] = $this->config->item('dtr-assoc-product-files');
		$this->data['menuItems'] = $this->lang->line('dtr-user-menu');

		// Carga paises y bloques economicos
		$this->data['countries'] = $this->countries->get();
		$this->data['countryOptions'] = $this->lang->line('dtr-country-options');
		$this->data['economicBlocks'] = $this->lang->line('dtr-economic-blocks');
		$this->data['myCountry'] = $this->countries->get($this->init->activeUser->country);

		// Listado de productos y categorias
		$this->data['categories'] = $this->getproducts->getCategories();
		$this->data['products'] = $this->getproducts->get();
		$this->data['productsByUser'] = $this->getproducts->byUser($this->init->activeUser->id_user);
		$this->data['productsByUserFormatted'] = $this->getproducts->byUserFormatted($this->init->activeUser->id_user);

		// Levanta los pagos de la empresa
		$payment = $this->getusers->getAssocPayments($this->init->activeUser->id_user);
		$payment = $payment[0];
		$this->data['paymentDay'] = mdate($this->init->activeUser->user_dformat, mysql_to_unix($payment->payment_expiration.' 00:00:00'));
		$this->data['paymentAmount'] = $payment->payment_price;

		$message = json_encode($this->lang->line('dtr-product-noselect'));
		$this->data['activePage']['fns'][] = "var NoServiceSelected = {$message};\n";
	}
}