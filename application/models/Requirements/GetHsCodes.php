<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE OBTENCION DE CODIGOS HS
|--------------------------------------------------------------------------
| 
|
*/

class GetHsCodes extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene los codigos arancelarios
	|--------------------------------------------------------------------------
	|	@access public
	|	@params string
	|	@return object
	|--------------------------------------------------------------------------
	*/
	public function get($code=NULL)
	{
		if(isset($code) AND !empty($code))
		{
			$this->db->like('code', $code, 'both');
		}
		$result = $this->db->get('dtr_ncm_codes');

		return $result->result();
	}
}