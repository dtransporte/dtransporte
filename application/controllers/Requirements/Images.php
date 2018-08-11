<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador imagenes de solicitud
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Requirements
| 
|
*/
class Images extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER'])  OR $this->init->activeUser->user_role != 'user' OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
	}

	function delete()
	{
		if($this->input->is_ajax_request())
		{
			$file_name = $this->input->get('file_name', TRUE);
			$image = $this->init->activeUser->userPath.'/temp/'.$file_name;
			$response = 'error';
			if(unlink($image))
			{
				$response = 'ok';
			}
			echo $response;
		}
	}
}