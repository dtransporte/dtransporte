<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador agregar nueva solicitud
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Requirements
| 
|
*/
class Add extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER'])  OR $this->init->activeUser->user_role != 'assoc' OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		$this->load->helper('string');
		$this->config->load('config.requirements');
		$this->lang->load('requirement', $this->init->activeLang);
		$this->lang->load('quotation', $this->init->activeLang);
		$this->load->model('Products/getproducts');
		$this->load->model('Requirements/getRequirement');
		$this->load->model('Quotations/getQuotations');
		$this->load->model('codeqr');
		$this->load->model('currencies');
	}

	function index($id_requirement)
	{
		$this->_set($id_requirement);
		$this->load->view('index', $this->data);
	}

	function _set($id_requirement)
	{
		// Carga pagina activa y menu
		$this->data['activePage'] = $this->config->item('dtr-quotations-add-files');
		$this->data['menuItems'] = $this->lang->line('dtr-user-menu');

		// Carga la solicitud a cotizar
		$requirement = $this->getRequirement->get($id_requirement);
		$this->data['requirement'] = $requirement;

		// Carga el producto activo
		$this->data['product'] = $this->getproducts->get($requirement[0]->id_product);

		// Establece la imagen y el texto del codigo qr
		$qrCode = $this->codeqr->get();
		$this->data['qrText'] = $this->codeqr->qrText;
		$this->data['qrImageSrc'] = $this->init->activeUser->userDir.'/qrcode.png';

		// Carga la moneda en la que debe ser cotizada la solicitud
		$currencies = $this->currencies->get();
		$this->data['currency'] = $currencies[$requirement[0]->requirement_currency];

		// Id de productos que solo tienen direccion de presentacion
		$this->data['prodNoRoute'] = [5, 9, 10, 11, 12, 13, 14, 15];

		// Codigo de cotizacion
		$this->data['quotation_code'] = random_string('numeric', 4);

		$errorQuotMessage =  json_encode($this->lang->line('dtr-message-quotation-validate-error'));
		$this->data['activePage']['fns'][] = "var ErrorMessages = {$errorQuotMessage};\n";

		$userDtf = str_replace(['%d', '%m', '%Y', '%H', '%i', '%s', '%a'], ['DD', 'MM', 'YYYY', 'HH', 'mm', '', ''], $this->init->activeUser->dtf);
		$userDtf = trim($userDtf);
		$this->data['activePage']['fns'][] = "var UserDtf = '{$userDtf}';\n";
	}
}