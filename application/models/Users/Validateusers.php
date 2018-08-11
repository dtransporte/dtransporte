<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE OBTENCION DE USUARIOS
|--------------------------------------------------------------------------
| Obtiene los usuarios en funcion de su id o nombre
| 
|
*/

class Validateusers extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('password');
	}

	/*
	|--------------------------------------------------------------------------
	|	Valida un usuario registrado
	|--------------------------------------------------------------------------
	|	@access public
	|	@params void
	|	@return boolean
	|--------------------------------------------------------------------------
	*/
	public function validate($data)
	{
		$user = $this->getusers->get(NULL, $data['user_name']);
		if(count($user) > 0)
		{
			if($this->password->pwdVerify($data['user_pwd'], $user->user_pwd, $user->id_user))
			{
				if($user->user_active == 1)
				{
					// Establece la sesion de usuario logueado
					$sets = $this->db->get_where('dtr_user_settings', ['id_user_settings' => $user->id_user]);
					$settings = $sets->row();
					$now = now($settings->user_timezone);
					$user->sess_start = $now;
					if($user->user_role === 'user' OR $user->user_role === 'assoc')
					{
						delete_cookie($this->config->item('dtr-cookie-user'));
						$cookieConfig = $this->config->item('dtr-cookie-user');
						$cookieConfig['value'] = 1;
						set_cookie($cookieConfig);
						$_SESSION['DTRANSPORTE-USER'] = $user;
						return TRUE;
					}
					$_SESSION['DTRANSPORTE-EMPLOYEE'] = $user;
					return TRUE;
				}
				return FALSE;
			}
			return FALSE;
		}
		return FALSE;
	}
}