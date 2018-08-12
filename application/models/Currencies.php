<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Modelo de gestion de monedas
|--------------------------------------------------------------------------
| Ubicacion: application/models
| 
|
*/
class Currencies extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	/*
	|--------------------------------------------------------------------------
	|	Establece la moneda nativa en funcion del pais y obtiene el array de monedas
	|--------------------------------------------------------------------------
	|	@access public
	|	@params void
	|	@return array
	|--------------------------------------------------------------------------
	*/
	function get()
	{
		$currencies = $this->config->item('dtr-currencies');
		$query = $this->db->get_where('dtr_countryinfo', ['iso'=>$this->init->activeUser->country]);
		$cur = $query->row();
		$currencies['native'] = ['currencycode'=> $cur->currencycode, 'currencyname'=> $cur->currencyname];
		return $currencies;
	}
}