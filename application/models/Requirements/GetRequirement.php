<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE OBTENCION DE SOLICITUDES DE USUARION
|--------------------------------------------------------------------------
| 
|
*/

class GetRequirement extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene las solicitudes asociadas a un usuario o a un id
	|--------------------------------------------------------------------------
	|	@access public
	|	@params int, int
	|	@return object
	|--------------------------------------------------------------------------
	*/
	public function get($id_requirement=NULL, $id_user=NULL, $as_array=FALSE)
	{
		if(isset($id_requirement))
		{
			$this->db->join('dtr_requirements_detail', 'dtr_requirements_detail.id_requirement = dtr_requirements.id_requirement', 'inner');
			$this->db->join('dtr_requirements_optype', 'dtr_requirements_optype.id_requirement = dtr_requirements.id_requirement', 'left');
			$this->db->join('dtr_requirements_address', 'dtr_requirements_address.id_requirement = dtr_requirements.id_requirement', 'left');
			$this->db->join('dtr_address', 'dtr_requirements_address.id_address = dtr_address.id_address', 'left');
			$this->db->where('dtr_requirements.id_requirement', $id_requirement);
		}
		if(isset($id_user))
		{
			$this->db->where('dtr_requirements.id_user', $id_user);
		}
		$this->db->order_by('dtr_requirements.requirement_entered', 'DESC');
		$result = $this->db->get('dtr_requirements');

		return $as_array == FALSE ? $result->result() : $result->result_array();
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene la cantidad de solicitudes por estado
	|--------------------------------------------------------------------------
	|	@access public
	|	@params int, array
	|	@return array
	|--------------------------------------------------------------------------
	*/
	public function numByStatus($id_user, $status)
	{
		$result = [];
		foreach ($status as $s)
		{
			$this->db->where('id_user', $id_user);
			$this->db->where('requirement_status', $s);
			$total = $this->db->count_all_results('dtr_requirements');
			if($total > 0)
			{
				$result[$s] = $total;
			}
		}
		return $result;
	}
}