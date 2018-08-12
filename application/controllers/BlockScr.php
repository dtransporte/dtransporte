<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador de pagina bloqueo de pantalla
|--------------------------------------------------------------------------
| Ubicacion: application/controllers
| 
|
*/
class BlockScr extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		$this->lang->load('validation', $this->init->activeLang);
		$this->load->model('password');
	}

	function index()
	{
		if(isset($this->init->activeUser) AND $this->init->activeUser->user_first_time == 0)
		{
			if($this->input->is_ajax_request())
			{
				if(!isset($_SESSION['DTR-BLOCK-SCREEN']))
				{
					$_SESSION['DTR-BLOCK-SCREEN'] = $this->config->item('dtr-scr-unblock-attempts');
				}
				
				$modal['modalId'] = 'modal-block-scr';
				$modal['modalShowCloseBtn'] = FALSE;
				$modal['modalAttribs'] = 'modal-fluid modal-notify modal-danger';
				$modal['modalTitle'] = $this->lang->line('text-screen-blocked');
				$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/block-scr", NULL, TRUE);
				$modal['modalFooter'] = $this->_setButtons();

				echo $this->load->view("modal", $modal, TRUE);
			}
		}
	}

	private function _setButtons()
	{
		$btn = "<button type=\"button\" class=\"btn btn-danger\" id=\"btn-unlock\"><span class=\"fa fa-unlock\"></span> {$this->lang->line('text-unblock-screen')}</button>";
		return $btn;
	}

	function unlock()
	{
		if(isset($this->init->activeUser) AND $this->init->activeUser->user_first_time == 0)
		{
			if($this->input->is_ajax_request())
			{
				$userPwd = $this->input->get('user_pwd', TRUE);
				$iduser = $this->init->activeUser->id_user;
				if($this->password->pwdVerify($userPwd, $this->init->activeUser->user_pwd, $iduser))
				{
					unset($_SESSION['DTR-BLOCK-SCREEN']);
					echo 'ok';
				}
				else
				{
					--$_SESSION['DTR-BLOCK-SCREEN'];
					if($_SESSION['DTR-BLOCK-SCREEN'] == 0)
					{
						$this->load->model('Users/lockUser');
						$this->lockUser->lock();
					}
					echo $_SESSION['DTR-BLOCK-SCREEN'];
				}
			}
		}
	}

	function loadPage($id_user, $hash)
	{
		if(isset($this->init->activeUser) AND $this->init->activeUser->user_first_time == 0)
		{
			$this->init->redirectTo();
		}
		$query = $this->db->get_where('dtr_user_reset_pwd', ['id_user'=> $id_user, 'user_hash'=> $hash]);
		if($query->num_rows() > 0)
		{
			$data['minMaxPwd'] = $this->password->setLength();
			$data['hash'] = $hash;
			$data['user'] = $query->row();
			$data['action'] = base_url().'index.php/blockScr/unlockUser';
			$data['message'] = $this->lang->line('text-user-cant-use-same-pwd');
			$this->load->view("{$this->init->activeLang}/users/new-pwd", $data, 'refresh');
		}
		else
		{
			$this->load->view("{$this->init->activeLang}/validation/error");
		}
	}

	function unlockUser()
	{
		if(isset($_SESSION['DTRANSPORTE-USER']))
		{
			$this->init->redirectTo();
		}
		$this->load->model('Users/lockUser');
		$data = $this->input->post(NULL, TRUE);
		$query = $this->db->get_where('dtr_user_reset_pwd', ['id_user'=> $data['id_user'], 'user_hash'=> $data['hash']]);
		if($query->num_rows() > 0)
		{
			$data['user'] = $query->row();
			$pwd = $this->password->get($data['id_user']);
			$userPwd = $data['rnew-pwd'];
			//Chequea que el usuario no use la misma contrasenia
			if($this->password->pwdVerify($userPwd, $pwd, $data['id_user']) === TRUE)
			{
				$this->loadPage($data['id_user'], $data['hash']);
			}
			else
			{
				if($data['hash'] === $data['user']->user_hash)
				{
					$this->lockUser->unlock($data['user'], $userPwd);
					redirect(base_url().'index.php/BlockScr/success');
				}
			}
		}
		else
		{
			$this->load->view("{$this->init->activeLang}/validation/error");
		}
	}

	function success()
	{
		if(isset($_SESSION['DTRANSPORTE-USER']))
		{
			$this->init->redirectTo();
		}
		$this->load->view("{$this->init->activeLang}/validation/success");
	}
}
/*7FuNAI*/