<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Recobra la direccion del usuario via ajax
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Users
| 
|
*/
class Get extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']))
		{
			//$this->init->redirectTo();
			die('NO ACCESS');
		}
	}

	function index()
	{
		if($this->input->is_ajax_request())
		{
			$user = $this->getusers->get($this->init->activeUser->id_user);
			echo json_encode($user);
		}
	}
}