<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE AGREGAR USUARIOS
|--------------------------------------------------------------------------
| 
|
*/

class Updateusers extends CI_Model
{
	public $tables = [];
	private $data = [];
	private $primaryKey = [];

	function __construct()
	{
		parent::__construct();
	}

	/*
	|--------------------------------------------------------------------------
	|	Actualiza datos de usuario
	|--------------------------------------------------------------------------
	|	@access public
	|	@params array
	|	@return bool
	|--------------------------------------------------------------------------
	*/
	public function update($data)
	{
		$id_user = $this->init->activeUser->id_user;
		$sql = [];
		$this->_setData($data);
		$this->_getPrimaryKey();
		foreach($this->data as $key => $value)
		{
			$where = "{$this->primaryKey[$key]} = {$id_user}";
			$sql[$key] = $this->db->update_string($key, $this->data[$key], $where);
		}

		$this->db->trans_start();
			foreach ($sql as $query)
			{
				$this->db->query($query);
			}
		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	/*
	|--------------------------------------------------------------------------
	|	Establece los datos a actualizar
	|--------------------------------------------------------------------------
	|	@access private
	|	@params array
	|	@return void
	|--------------------------------------------------------------------------
	*/
	private function _setData($data)
	{
		foreach ($this->tables as $t)
		{
			foreach ($data as $key => $value)
			{
				if($this->db->field_exists($key, $t))
				{
					$this->data[$t][$key] = trim($value);
				}
			}
		}
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene las claves primarias de las tablas
	|--------------------------------------------------------------------------
	|	@access private
	|	@params void
	|	@return void
	|--------------------------------------------------------------------------
	*/
	private function _getPrimaryKey()
	{
		foreach ($this->tables as $t)
		{
			$fields = $this->db->field_data($t);
			foreach ($fields as $f)
			{
				if($f->primary_key == 1)
				{
					$this->primaryKey[$t] = $f->name;
				}
			}
		}
	}
}