<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE AGREGAR USUARIOS
|--------------------------------------------------------------------------
| 
|
*/

class Deleteusers extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Users/dirstruct');
	}

	/*
	|--------------------------------------------------------------------------
	|	Elimina un usuario de la bbdd
	|--------------------------------------------------------------------------
	|	@access public
	|	@params array
	|	@return bool
	|--------------------------------------------------------------------------
	*/
	public function delete($id_user)
	{
		if($this->dirstruct->delete($id_user))
		{
			$company = $this->db->get_where('dtr_users', ['id_user' => $id_user]);
			$this->db->trans_start();
				$this->db->where('id_user', $id_user);
				$this->db->delete('dtr_users');

				if($company->num_rows() == 1)
				{
					$this->db->where('id_company', $company->id_company);
					$this->db->delete('dtr_companies');
				}
			$this->db->trans_complete();
		}
	}
}