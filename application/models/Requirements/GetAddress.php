<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE OBTENCION DE USUARIOS
|--------------------------------------------------------------------------
| Obtiene las direcciones de usuarios
| 
|
*/

class GetAddress extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene las direcciones asociadas a un usuario
	|--------------------------------------------------------------------------
	|	@access public
	|	@params int, string
	|	@return object
	|--------------------------------------------------------------------------
	*/
	public function get($id_user=NULL, $address_type=NULL)
	{
		$this->db->join('dtr_requirements', 'dtr_requirements_address.id_requirement = dtr_requirements.id_requirement', 'inner');
		$this->db->join('dtr_address', 'dtr_requirements_address.id_address = dtr_address.id_address', 'inner');
		if(isset($id_user))
		{
			$this->db->where('dtr_requirements.id_user', $id_user);
		}
		if(isset($address_type))
		{
			$this->db->where('dtr_requirements_address.address_type', $address_type);
		}
		$result = $this->db->get('dtr_requirements_address');

		return $result->num_rows() > 0 ? $result->result() : FALSE;
	}
}