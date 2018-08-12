<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE OBTENCION DE COTIZACIONES DE EMPRESAS
|--------------------------------------------------------------------------
| 
|
*/

class GetQuotations extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene las solicitudes asociadas a una empresa, id solicitud  o id cotizacion
	|--------------------------------------------------------------------------
	|	@access public
	|	@params int, int, int
	|	@return object
	|--------------------------------------------------------------------------
	*/
	public function get($id_quotation=NULL, $id_requirement=NULL, $id_assoc=NULL, $isVisit=FALSE)
	{
		$this->db->join('dtr_quotations_requirements', 'dtr_quotations_requirements.id_quotation = dtr_quotations.id_quotation', 'inner');
		$this->db->join('dtr_requirements', 'dtr_quotations_requirements.id_requirement = dtr_requirements.id_requirement', 'inner');
		if(isset($id_quotation))
		{
			if($isVisit === FALSE)
			{
				$this->db->join('dtr_quotation_concepts', 'dtr_quotation_concepts.id_quotation = dtr_quotations.id_quotation', 'inner');
			}
			$this->db->where('dtr_quotations.id_quotation', $id_quotation);
		}

		if(isset($id_assoc))
		{
			$this->db->where('dtr_quotations.id_assoc', $id_assoc);
		}
		if(isset($id_requirement))
		{
			$this->db->where('dtr_quotations_requirements.id_requirement', $id_requirement);
		}
		$this->db->order_by('dtr_quotations.quotation_entered', 'DESC');

		$result = $this->db->get('dtr_quotations');
		
		return $result->result();
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene las solicitudes asociadas a un usuario
	|--------------------------------------------------------------------------
	|	@access public
	|	@params int
	|	@return object
	|--------------------------------------------------------------------------
	*/
	public function getByUser($id_user)
	{
		$this->db->join('dtr_quotations_requirements', 'dtr_quotations_requirements.id_requirement = dtr_requirements.id_requirement', 'inner');
		$this->db->join('dtr_quotations', 'dtr_quotations_requirements.id_quotation = dtr_quotations.id_quotation', 'inner');
		$this->db->join('dtr_quotation_concepts', 'dtr_quotation_concepts.id_quotation = dtr_quotations.id_quotation', 'inner');

		$this->db->where('dtr_requirements.id_user', $id_user);

		$result = $this->db->get('dtr_requirements');
		return $result->result();

	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene el numero de cotizaciones asociadas a una solicitud
	|--------------------------------------------------------------------------
	|	@access public
	|	@params int, int, int
	|	@return object
	|--------------------------------------------------------------------------
	*/
	public function numByRequirement($id_requirement)
	{
		$this->db->where('id_requirement', $id_requirement);
		$result = $this->db->get('dtr_quotations_requirements');
		return $result->num_rows();
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene las solicitudes pendientes de cotizar
	|--------------------------------------------------------------------------
	|	@access public
	|	@params void
	|	@return object
	|--------------------------------------------------------------------------
	*/
	public function getRequirementNoQuoted($id_user)
	{
		$myReqQuots = [];
		$this->db->where('dtr_quotations_requirements.id_assoc', $id_user);
		$myQuotations = $this->db->get('dtr_quotations_requirements');
		if($myQuotations->num_rows() > 0)
		{
			foreach ($myQuotations->result() as $quot)
			{
				$myReqQuots[] = $quot->id_requirement;
			}
		}
		$this->db->join('dtr_products_user', 'dtr_requirements.id_product = dtr_products_user.id_product', 'inner');
		$this->db->where('dtr_requirements.requirement_status', 'active');
		$this->db->where('dtr_products_user.id_user', $id_user);
		if(count($myReqQuots) > 0)
		{
			$this->db->where_not_in('dtr_requirements.id_requirement', $myReqQuots);
		}

		$result = $this->db->get('dtr_requirements');

		return $result->result();
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene el total de solicitudes pendientes de rankear
	|--------------------------------------------------------------------------
	|	@access public
	|	@params void
	|	@return int
	|--------------------------------------------------------------------------
	*/
	public function countRequirementsNoRanked()
	{
		$this->db->join('dtr_quotations', 'dtr_quotations_requirements.id_quotation = dtr_quotations.id_quotation', 'inner');
		$this->db->join('dtr_requirements', 'dtr_quotations_requirements.id_requirement = dtr_requirements.id_requirement', 'inner');
		$this->db->where('dtr_requirements.requirement_status', 'finish');
		$this->db->where('dtr_quotations.quotation_status', 'finish');
		if($this->init->activeUser->user_role === 'user')
		{
			$this->db->where('dtr_requirements.id_user', $this->init->activeUser->id_user);
			$this->db->where('dtr_requirements.requirement_rank_by_user', 0);
		}
		else
		{
			$this->db->where('dtr_quotations.id_assoc', $this->init->activeUser->id_user);
			$this->db->where('dtr_requirements.requirement_rank_by_assoc', 0);
		}
		return $this->db->count_all_results('dtr_quotations_requirements');
	}
}