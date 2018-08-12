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

class Getusers extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene usuarios
	|--------------------------------------------------------------------------
	|	@access public
	|	@params int | string | mixed (1, 0, all)
	|	@return object
	|--------------------------------------------------------------------------
	*/
	public function get($id_user=NULL, $user_name=NULL, $active=1)
	{
		$this->db->join('dtr_address', 'dtr_users.id_address = dtr_address.id_address', 'inner');
		$this->db->join('dtr_phones', 'dtr_users.id_phone = dtr_phones.id_phone', 'inner');
		$this->db->join('dtr_user_settings', 'dtr_users.id_settings = dtr_user_settings.id_user_settings', 'inner');
		$this->db->join('dtr_companies', 'dtr_users.id_company = dtr_companies.id_company', 'inner');

		if(isset($id_user))
		{
			$this->db->where('dtr_users.id_user', $id_user);
		}
		if(isset($user_name))
		{
			$this->db->where('dtr_users.user_name', $user_name);
		}
		if($active != 'all')
		{
			$this->db->where('dtr_users.user_active', $active);
		}

		$user = $this->db->get('dtr_users');

		return (isset($id_user) OR isset($user_name)) ? $user->row() : $user->result();
	}

	/*
	|--------------------------------------------------------------------------
	|	Chequea si un usuario existe
	|--------------------------------------------------------------------------
	|	@access public
	|	@params string
	|	@return bool
	|--------------------------------------------------------------------------
	*/
	public function exists($user_name)
	{
		$user = $this->db->get_where('dtr_users', ['user_name' => $user_name]);
		return $user->num_rows() == 0 ? FALSE : TRUE;
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene la imagen de usuario
	|--------------------------------------------------------------------------
	|	@access public
	|	@params int
	|	@return string
	|--------------------------------------------------------------------------
	*/
	public function getImage($id_user)
	{
		if(isset($_SESSION['DTRANSPORTE-USER']))
		{
			$dir = 'dtr-users/'.$id_user.'/me/';
		}
		else
		{
			$dir = 'dtr-employees/'.$id_user.'/me/';
		}
		$img = get_filenames(FCPATH.$dir);
		if(count($img) > 0 AND is_readable($dir.$img[0]) AND is_file($dir.$img[0])){
			return $dir.$img[0];
		}
		return 'imgs/user-anonymus.png';
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene los datos de pago de un usuario
	|--------------------------------------------------------------------------
	|	@access public
	|	@params int
	|	@return object
	|--------------------------------------------------------------------------
	*/
	public function getAssocPayments($id_user=NULL, $payment_done=TRUE)
	{
		if(isset($id_user))
		{
			$this->db->where('id_user', $id_user);
		}
		if($payment_done == TRUE)
		{
			$this->db->where('payment_done', 0);
		}
		$user = $this->db->get('dtr_payments');
		return $user->result();
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene los datos de pago pendiente de un usuario
	|--------------------------------------------------------------------------
	|	@access public
	|	@params int
	|	@return object
	|--------------------------------------------------------------------------
	*/
	public function getPendingPayments()
	{
		$this->db->where('payment_reminder_sent', 0);

		return $this->db->get('dtr_payments');
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene los datos de pago vencido de un usuario
	|--------------------------------------------------------------------------
	|	@access public
	|	@params int
	|	@return object
	|--------------------------------------------------------------------------
	*/
	public function getDuePayments()
	{
		$now = mdate($this->config->item('dtr-date-db'), now());
		$this->db->where('payment_expiration <', $now);

		return $this->db->get('dtr_payments');
	}
}