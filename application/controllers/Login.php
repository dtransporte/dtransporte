<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador de validacion de usuarios
|--------------------------------------------------------------------------
| Ubicacion: application/controllers
| 
|
*/
class Login extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(isset($_SESSION['DTRANSPORTE-USER']) OR isset($_SESSION['DTRANSPORTE-EMPLOYEE']))
		{
			$this->init->redirectTo();
		}
		$this->load->model('Users/validateusers');
	}

	public function index()
	{
		if($this->input->is_ajax_request())
		{
			$idMessage = 'dtr-message-login-error';

			$data = $this->input->post(NULL, TRUE);
			if($this->validateusers->validate($data))
			{
				$idMessage = 'dtr-message-access-granted';
			}
			echo json_encode($this->lang->line($idMessage));
		}
	}
}