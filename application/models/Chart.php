<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|---------------------------------------------------------------------------------------
| MODELO DE GESTION DE GRAFICOS
|---------------------------------------------------------------------------------------
| 
|
*/

class Chart extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Products/getproducts');
	}
	
	/*
	|----------------------------------------------------------------------------------
	|	Obtiene los servicios mas pedidos por los usuarios.
	|   	Se muestra en la pagina assoc-home
	|----------------------------------------------------------------------------------
	|	@access public
	|	@params void
	|	@return array
	|----------------------------------------------------------------------------------
	 */
	public function getUserRequiredServices()
	{
		$result = [];
		$products = $this->getproducts->get();
		$grandTotal = $this->db->count_all('dtr_requirements');
		foreach ($products as $key => $prod)
		{
			$where ="id_product = {$prod->id_product} AND requirement_status != 'prog' AND requirement_status != 'nosent'";
			$this->db->where($where);
			$total = $this->db->count_all_results('dtr_requirements');
			if($total > 0)
			{
				$result['data']['labels'][] = $this->_replaceTildes($this->lang->line('product')[$prod->product_description]);
				$data[] = round($total/$grandTotal * 100, 1);
			}
		}
		$result['data']['datasets'][] = [
			'data' => $data,
			'label' => $this->_replaceTildes($this->lang->line('text-product-more-required-by-users'))
		];
		return $result;
	}

	/*
	|----------------------------------------------------------------------------------
	|	Obtiene las solicitudes finalizadas por transportista.
	|   	Se muestra en la pagina user-home
	|----------------------------------------------------------------------------------
	|	@access public
	|	@params void
	|	@return array
	|----------------------------------------------------------------------------------
	 */
	public function requirementsFinishedByAssoc()
	{
		$result = [];

		$this->db->where('dtr_requirements.id_user', $this->init->activeUser->id_user);
		$this->db->where('dtr_requirements.requirement_status', 'finish');
		$query = $this->db->get('dtr_requirements');

		$grandTotal = $query->num_rows();
		if($grandTotal > 0)
		{
			foreach ($query->result() as $q)
			{
				$this->db->join('dtr_quotations_requirements', 'dtr_quotations_requirements.id_requirement = dtr_requirements.id_requirement', 'inner');
				$this->db->join('dtr_quotations', 'dtr_quotations_requirements.id_quotation = dtr_quotations.id_quotation', 'inner');
				$this->db->join('dtr_users', 'dtr_users.id_user = dtr_quotations.id_assoc', 'inner');
				$this->db->join('dtr_companies', 'dtr_users.id_company = dtr_companies.id_company', 'inner');
				$this->db->where('dtr_requirements.id_requirement', $q->id_requirement);
				$this->db->where('dtr_requirements.requirement_status', 'finish');
				$this->db->where('dtr_quotations.quotation_status', 'finish');
				$requirement = $this->db->get('dtr_requirements');
				$req = $requirement->row();
				$result['data']['labels'][] = $this->_replaceTildes($req->company_name);
				$data[] = $requirement->num_rows();
			}
			$result['data']['datasets'][] = [
				'data' => $data,
				'label' => ''//$this->_replaceTildes($this->lang->line('text-product-more-required-by-users'))
			];
		}

		return $result;
	}

	/*
	|----------------------------------------------------------------------------------
	|	Obtiene las solicitudes finalizadas por usuario.
	|   	Se muestra en la pagina assoc-home
	|----------------------------------------------------------------------------------
	|	@access public
	|	@params void
	|	@return array
	|----------------------------------------------------------------------------------
	 */
	public function requirementsFinishedByUser()
	{
		$result = [];

		$this->db->where('dtr_quotations.id_assoc', $this->init->activeUser->id_user);
		$this->db->where('dtr_quotations.quotation_status', 'finish');
		$query = $this->db->get('dtr_quotations');

		$grandTotal = $query->num_rows();
		if($grandTotal > 0)
		{
			foreach ($query->result() as $q)
			{
				$this->db->join('dtr_quotations_requirements', 'dtr_quotations_requirements.id_requirement = dtr_requirements.id_requirement', 'inner');
				$this->db->join('dtr_quotations', 'dtr_quotations_requirements.id_quotation = dtr_quotations.id_quotation', 'inner');
				$this->db->join('dtr_users', 'dtr_users.id_user = dtr_requirements.id_user', 'inner');
				$this->db->join('dtr_companies', 'dtr_users.id_company = dtr_companies.id_company', 'inner');
				$this->db->where('dtr_quotations.id_quotation', $q->id_quotation);
				$this->db->where('dtr_requirements.requirement_status', 'finish');
				$this->db->where('dtr_quotations.quotation_status', 'finish');
				$requirement = $this->db->get('dtr_requirements');
				$req = $requirement->row();
				$company_name = empty($req->company_name) ? $req->user_first_name.' '.$req->user_last_name : $req->company_name;
				$result['data']['labels'][] = $this->_replaceTildes($company_name);
				$data[] = $requirement->num_rows();
			}
			$result['data']['datasets'][] = [
				'data' => $data,
				'label' => ''//$this->_replaceTildes($this->lang->line('text-product-more-required-by-users'))
			];
		}

		return $result;
	}

	/*
	|----------------------------------------------------------------------------------
	|	Obtiene las solicitudes por estado
	|   Se muestra en la pagina user-home
	|----------------------------------------------------------------------------------
	|	@access public
	|	@params void
	|	@return array
	|----------------------------------------------------------------------------------
	 */
	public function getUserRequirementsByStatus($id_user=NULL)
	{
		$this->lang->load('quotation', $this->init->activeLang);
		$result = [];
		$status = $this->lang->line('dtr-quotation-status');

		if(isset($id_user))
		{
			$this->db->where('id_user', $id_user);
			$grandTotal = $this->db->count_all_results('dtr_requirements');
		}
		else
		{
			$grandTotal = $this->db->count_all('dtr_requirements');
		}
		if($grandTotal > 0)
		{
			foreach($status as $key => $s)
			{
			   if(isset($id_user))
			   {
					$this->db->where('id_user', $id_user);
			   }
			   $this->db->where('requirement_status', $key);
			   $total = $this->db->count_all_results('dtr_requirements');
			   if($total > 0)
			   {
			  		$result['data']['labels'][] = $s;
			  		$data[] = $total;
			   }
			}
			$result['data']['datasets'][] = [
				'data' => $data,
				'label' => $this->lang->line('text-requirement-by-status')
			];
		}
		return $result;
	}

	private function _replaceTildes($txt)
	{
		$search = [
			'&aacute;',
			'&eacute;',
			'&iacute;',
			'&oacute;',
			'&uacute;'
		];
		$replace = [
			'a',
			'e',
			'i',
			'o',
			'u'
		];
		return str_replace($search, $replace, $txt);
	}
}