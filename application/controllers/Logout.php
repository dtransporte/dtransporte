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
class Logout extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
	}

	function index($idMessage=NULL)
	{
		session_destroy();
		if(isset($idMessage))
		{
			//$this->dmonolog->setAppInfo('monolog-user-blocked-unlock-scr', NULL, $this->init->activeUser);
			$this->init->redirectTo($idMessage);
		}
		//$this->dmonolog->setAppInfo('monolog-session-finish', NULL, $this->init->activeUser);
		//$_SESSION['DTR-INCREMENT-VISIT'] = FALSE;
		$cookieConfig = $this->config->item('dtr-cookie-user');
		$cookieConfig['value'] = 0;
		redirect(base_url(), 'refresh');
	}
}