<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Modelo de gestion de paises
|--------------------------------------------------------------------------
| Ubicacion: application/models
| 
|
*/
class Countries extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene el listado de paises
	|--------------------------------------------------------------------------
	|	@access public
	|	@params string
	|	@return array
	|--------------------------------------------------------------------------
	*/
	function get($id_country=NULL)
	{
		if(isset($id_country))
		{
			$this->db->where('iso', $id_country);
		}
		$this->db->order_by('country', 'ASC');
		$query = $this->db->get('dtr_countryinfo');
		return isset($id_country) ? $query->row() : $query->result();
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene los bloques economicos
	|--------------------------------------------------------------------------
	|	@access public
	|	@params string
	|	@return array
	|--------------------------------------------------------------------------
	*/
	public function getEconomicBlocks($id_block=NULL)
	{
		if(isset($id_block))
		{
			$this->db->where('id_economic_block', $id_block);
		}
		$blocks = $this->db->get('dtr_economic_blocks');

		return isset($id_block) ? $blocks->row() : $blocks->result();
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene los paises por bloque economico
	|--------------------------------------------------------------------------
	|	@access public
	|	@params string
	|	@return array
	|--------------------------------------------------------------------------
	*/
	public function getCountryByBlock($id_block=NULL)
	{
		$this->db->join('dtr_countries_block', 'dtr_economic_blocks.id_economic_block = dtr_countries_block.id_block', 'inner');
		$this->db->join('dtr_countryinfo', 'dtr_countryinfo.iso = dtr_countries_block.id_country', 'inner');
		if(isset($id_block))
		{
			$this->db->where('dtr_countries_block.id_block', $id_block);
		}
		$countries = $this->db->get('dtr_economic_blocks');
		return $countries->result();
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene los paises fronterizos
	|--------------------------------------------------------------------------
	|	@access public
	|	@params string
	|	@return array
	|--------------------------------------------------------------------------
	*/
	public function getNeighbours()
	{
		$country = $this->db->get_where('dtr_countryinfo', ['iso' => $this->init->activeUser->country]);
		$country = $country->row();
		if(!empty($country->neighbours))
		{
			$neighbours = explode(',', $country->neighbours);
			foreach ($neighbours as $n)
			{
				$r = $this->db->get_where('dtr_countryinfo', ['iso' => $n]);
				$result[] = $r->row();
			}
			return $result;
		}
	}
}