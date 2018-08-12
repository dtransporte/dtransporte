<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Captcha - Controlador pagina captcha
| -------------------------------------------------------------------------
| 
|
| -------------------------------------------------------------------------
| Ubicacion
|	application/controllers
| -------------------------------------------------------------------------
*/
class Captcha extends CI_Controller
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
	}

	function index()
	{
		if($this->input->is_ajax_request())
		{
			$captcha = create_captcha($this->init->setCaptcha());
			echo json_encode($captcha);
		}
	}
}