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
		if(!isset($_SESSION['DTRANSPORTE-USER']) OR $this->init->activeUser->user_role != 'user')
		{
			$this->init->redirectTo();
		}
		//$this->load->model('Users/validateusers');
	}

	function index()
	{
		echo 'LOGUEADO COMO USUARIO';
	}
}