<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Controlador de visitantes de la pagina
| -------------------------------------------------------------------------
| 
|
| -------------------------------------------------------------------------
| Ubicacion
|	application/controllers
| -------------------------------------------------------------------------
*/
class Visitors extends CI_Model
{
	private $ipAddress = NULL;
	private $url = 'http://ip-api.com/php/';

	function __construct()
	{
		parent::__construct();
		$this->ipAddress = $this->input->ip_address();
	}

	public function set()
	{
		$this->_upgrade();
	}

	private function _upgrade()
	{
		$query = @unserialize(file_get_contents($this->url.$this->ipAddress));
		if($query && $query['status'] == 'success')
		{
			$result = $this->db->get_where('dtr_visitors', ['ip_address' => $query['query']]);
			if($result->num_rows() == 0)
			{
				$data = $query;
				$data['ip_address'] = $query['query'];
				unset($data['status']);
				unset($data['query']);
				$data['date'] = mdate($this->config->item('dtr-datetime-db'), now($data['timezone']));
				$this->db->insert('dtr_visitors', $data);
			}
			else
			{
				$r = $result->row();
				$data['date'] = mdate($this->config->item('dtr-datetime-db'), now($query['timezone']));
				$this->db->where('ip_address', $query['query']);
				$this->db->update('dtr_visitors', $data);
			}
			return FALSE;
		}
		return FALSE;
	}


}