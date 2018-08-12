<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador inicia sesion como usuario luego de finalizado el wizard
|  first time
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/First
| 
|
*/
class Start extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']) OR $this->init->activeUser->user_first_time == 0)
		{
			$this->init->redirectTo();
		}
		$this->lang->load('validation', $this->init->activeLang);
	}

	function index()
	{
		if($this->input->is_ajax_request())
		{
			$msgId = 'dtr-message-starting-session';
			$error = FALSE;
			$tabId = -1;
			$user = $this->getusers->get($this->init->activeUser->id_user);
			if(empty($user->user_first_name) OR empty($user->user_last_name))
			{
				$error = TRUE;
				$msgId = 'dtr-message-no-user-fullname';
				$tabId = 1;
			}
			if(empty($user->phone_number))
			{
				$error = TRUE;
				$msgId = 'dtr-message-no-user-phone';
				$tabId = 1;
			}
			if($user->user_role === 'assoc')
			{
				$this->load->model('Products/getproducts');
				$prods = $this->getproducts->byUser($user->id_user);
				if(!$prods)
				{
					$error = TRUE;
					$msgId = 'dtr-product-noselect';
					$tabId = 5;
				}
			}
			if($error == FALSE)
			{
				$this->db->where('id_user', $this->init->activeUser->id_user);
				$data['user_first_time'] = 0;
				$this->db->update('dtr_users', $data);
			}
			echo json_encode(['msg'=>$this->lang->line($msgId), 'tabId'=>$tabId]);
		}
	}
}