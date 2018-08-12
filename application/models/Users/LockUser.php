<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| BLOQUEO DE USUARIO
|--------------------------------------------------------------------------
| 
|
*/

class LockUser extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	/*
	|--------------------------------------------------------------------------
	|	Bloquea usuario logueado luego de fallar en el desbloqueo de pantalla
	|--------------------------------------------------------------------------
	|	@access public
	|	@params void
	|	@return void
	|--------------------------------------------------------------------------
	*/
	public function lock()
	{
		$this->load->helper('string');
		$user = $this->init->activeUser;
		
		// Inserta datos del usuario en 'dtr_user_reset_pwd'
		$hash = random_string('alnum', 10);
		$data['user_hash'] = sha1($hash);
		$data['id_user'] = $user->id_user;
		$timestamp = now($user->user_timezone)+$this->config->item('dtr-max-validation-time');
		$data['date_expiration'] = mdate($this->config->item('dtr-datetime-db'), $timestamp);
		$str[] = $this->db->insert_string('dtr_user_reset_pwd', $data);

		//Bloquea el usuario
		$d['user_active'] = 0;
		$where = "id_user = {$user->id_user}";
		$str[] = $this->db->update_string('dtr_users', $d, $where);

		$this->db->trans_start();
		foreach ($str as $query)
		{
			$this->db->query($query);
		}
		$this->db->trans_complete();
		
		if($this->db->trans_status() === TRUE)
		{
			$this->_sendLockMail($data['user_hash']);
		}
	}

	/*
	|--------------------------------------------------------------------------
	|	Envia correo a usuario bloqueado para que valide su contrasenia
	|--------------------------------------------------------------------------
	|	@access private
	|	@params void
	|	@return void
	|--------------------------------------------------------------------------
	*/
	private function _sendLockMail($hash)
	{
		$this->load->model('mail');
		$this->lang->load('mail-tpl', $this->init->activeLang);
		$user = $this->init->activeUser;

		$tpl = $this->lang->line('tpl-unblock-user-form');
		$tpl['tplHeader'] = str_replace('%fullname%', $user->user_first_name.' '.$user->user_last_name, $tpl['tplHeader']);
		$tpl['tplContent'] = str_replace(
			['%baseurl%', '%userid%', '%userhash%'],
			[base_url(), $user->id_user, $hash], 
			$tpl['tplContent']
		);

		$this->mail->subject = $tpl['subject'];
		$this->mail->to = [$user->user_name];
		$this->mail->message = $this->load->view('mail-tpl', $tpl, TRUE);
		$this->mail->send();
	}

	/*
	|--------------------------------------------------------------------------
	|	Desbloquea la cuenta de usuario
	|--------------------------------------------------------------------------
	|	@access public
	|	@params void
	|	@return void
	|--------------------------------------------------------------------------
	*/
	public function unlock($user, $pwd)
	{
		$this->db->trans_start();
			$this->db->where('id_user', $user->id_user);
			$this->db->delete('dtr_user_reset_pwd');

			$data['user_active'] = 1;
			$data['user_pwd'] = $this->password->setPwd($pwd);
			$this->db->where('id_user', $user->id_user);
			$this->db->update('dtr_users', $data);
		$this->db->trans_complete();
	}
}