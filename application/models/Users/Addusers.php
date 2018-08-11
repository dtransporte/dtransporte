<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE AGREGAR USUARIOS
|--------------------------------------------------------------------------
| 
|
*/

class Addusers extends CI_Model
{
	private $tables = [
		'dtr_address',
		'dtr_phones',
		'dtr_user_settings',
		'dtr_companies',
		'dtr_users',
		'dtr_user_validation'
	];

	public $lastId = NULL;

	function __construct()
	{
		parent::__construct();
	}

	/*
	|--------------------------------------------------------------------------
	|	Agregar un usuario a la bbdd
	|--------------------------------------------------------------------------
	|	@access public
	|	@params array
	|	@return bool
	|--------------------------------------------------------------------------
	*/
	public function add($data)
	{
		$data = $this->_set($data);
		$lastIds = [];
		$sql = [];

		foreach($data as $key => $value)
		{
			if($key != 'dtr_users' AND $key != 'dtr_user_validation')
			{
				$sql[$key] = $this->db->insert_string($key, $data[$key]);
			}
		}
		
		$this->db->trans_start();
			foreach ($sql as $key=>$query) {
				if($key != 'dtr_users' AND $key != 'dtr_user_validation')
				{
					$this->db->query($query);
					$lastIds[$key] = $this->db->insert_id();
				}
			}

			$data['dtr_users']['id_phone'] = $lastIds['dtr_phones'];
			$data['dtr_users']['id_address'] = $lastIds['dtr_address'];
			$data['dtr_users']['id_settings'] = $lastIds['dtr_user_settings'];
			$data['dtr_users']['id_company'] = $lastIds['dtr_companies'];

			$this->db->insert('dtr_users', $data['dtr_users']);

			$this->lastId = $this->db->insert_id();

			$data['dtr_user_validation']['id_user'] = $this->db->insert_id();
			$this->db->insert('dtr_user_validation', $data['dtr_user_validation']);

		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	/*
	|--------------------------------------------------------------------------
	|	Establece los datos a ser insertados
	|--------------------------------------------------------------------------
	|	@access privat
	|	@params array
	|	@return array
	|--------------------------------------------------------------------------
	*/
	private function _set($data)
	{
		$result = [];
		foreach ($this->tables as $t)
		{
			foreach ($data as $key => $value)
			{
				if($this->db->field_exists($key, $t))
				{
					$result[$t][$key] = trim($value);
				}
			}
		}
		return $result;
	}
}