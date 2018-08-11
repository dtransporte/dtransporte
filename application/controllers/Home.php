<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CONTROLADOR PRINCIPAL PAGINA PUBLICA
| -------------------------------------------------------------------
| 
|
*/
class Home extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(isset($_SESSION['DTRANSPORTE-USER']))
		{
			$this->init->redirectTo();
		}
		$this->load->helper('captcha');
		$this->lang->load('faq', $this->init->activeLang);
		$this->lang->load('validation', $this->init->activeLang);
		$this->load->model('countries');
		$this->load->model('visitors');
	}

	function index($idMessage=NULL)
	{
		$this->_set($idMessage);
		$this->load->view('index', $this->data);
	}

	private function _set($idMessage)
	{
		$this->visitors->set();
		// Carga los archivos globales y las vistas asociadas
		$this->data['activePage'] = $this->config->item('dtr-public-files');
		$this->data['menuItems'] = $this->lang->line('dtr-public-menu');

		// Carga las imagenes del slider
		$sliders = get_filenames(FCPATH.'imgs/slider/');
		$this->data['sliders'] = $sliders;

		// Carga las preguntas frecuentes
		$faq = $this->lang->line('dtr-faq');
		$faq['payment']['content'] = str_replace('%paymentdays%', $this->config->item('dtr-assoc-freedays'), $faq['payment']['content']); 
		$this->data['faq'] = $faq;

		// Carga listado de paises
		$this->data['countries'] = $this->countries->get();

		// Carga las imagenes captcha
		$this->data['captchaSettings'] = $this->config->item('dtr-captcha');
		$this->data['captcha'] = create_captcha($this->init->setCaptcha());

		// Carga el formulario de login
		$this->data['loginForm'] = $this->load->view("{$this->init->activeLang}/login", NULL, TRUE);

		if(!isset($_COOKIE['dtr-user-logged']))
		{
			$message = json_encode($this->lang->line('dtr-message-cookie-alert'));
			$this->data['activePage']['fns'][] = "var CookieAlertMessage = {$message};\n";
		}

		if(isset($idMessage))
		{
			$message = json_encode($this->lang->line($idMessage));
			$this->data['activeMessage']['fns'][] = "var ActiveMessage = {$message};\n";
		}

	}
}