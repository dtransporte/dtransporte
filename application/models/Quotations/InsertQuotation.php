<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE OBTENCION DE COTIZACIONES DE EMPRESAS
|--------------------------------------------------------------------------
| 
|
*/

class InsertQuotation extends CI_Model
{
	private $tables = [
		'dtr_quotations',
		'dtr_quotation_concepts',
		'dtr_quotations_requirements'
	];

	private $lastQuotId = NULL;

	function __construct()
	{
		parent::__construct();
	}

	public function insert($requirement, $data)
	{
		// Elimina la tabla de conceptos de cotizacion si se trata de una visita
		if($data['quotation_status'] === 'visit-accepted')
		{
			unset($this->tables[1]);
		}
		if($this->_insert($data))
		{
			if($this->_createDirStruct())
			{
				if($data['quotation_status'] === 'active')
				{
					$this->load->model('Quotations/sendQuotation');
					return $this->sendQuotation->send($this->lastQuotId);
				}
				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}
	/*
	|--------------------------------------------------------------------------
	|	Inserta una nueva cotizacion
	|--------------------------------------------------------------------------
	|	@access private
	|	@params object, array
	|	@return boolean
	|--------------------------------------------------------------------------
	*/
	private function _insert($dat)
	{
		$data = $this->_setData($dat);
		$this->db->trans_start();
			$this->db->insert('dtr_quotations', $data['dtr_quotations']);
			$this->lastQuotId = $this->db->insert_id();

			if($dat['quotation_status'] != 'visit-accepted')
			{
				foreach ($data['dtr_quotation_concepts'] as $key => $value)
				{
					$data['dtr_quotation_concepts'][$key]['id_quotation'] = $this->lastQuotId;
				}
				//var_dump($data['dtr_quotation_concepts']);die();
				$this->db->insert_batch('dtr_quotation_concepts', $data['dtr_quotation_concepts']);
			}

			$data['dtr_quotations_requirements']['id_quotation'] = $this->lastQuotId;
			$this->db->insert('dtr_quotations_requirements', $data['dtr_quotations_requirements']);
		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	/*
	|--------------------------------------------------------------------------
	|	Prepara los datos a ser insertados
	|--------------------------------------------------------------------------
	|	@access privat
	|	@params array
	|	@return array
	|--------------------------------------------------------------------------
	*/
	private function _setData($data)
	{
		$result = [];
		foreach ($this->tables as $t)
		{
			$fields = $this->db->list_fields($t);
			foreach ($fields as $k=>$f)
			{
				if($this->db->field_exists($f, $t))
				{
					switch ($f) {
						case 'quotation_entered':
							$now = now($this->init->activeUser->user_timezone);
							$result[$t][$f] = mdate($this->config->item('dtr-datetime-db'), $now);
						break;

						case 'quotation_sent':
							if($data['quotation_status'] === 'active' OR $data['quotation_status'] === 'visit-accepted')
							{
								$now = now($this->init->activeUser->user_timezone);
								$result[$t][$f] = mdate($this->config->item('dtr-datetime-db'), $now);
							}
						break;

						case 'id_assoc':
							$result[$t][$f] = $this->init->activeUser->id_user;
						break;

						case 'concept_name':
							foreach ($data['concept_name'] as $key => $value)
							{
								$result[$t][] = [
									'concept_name' => $value,
									'concept_value' => $data['concept_value'][$key]
								];
							}
						break;
						
						default:
							if(isset($data[$f]) AND $f != 'concept_value')
							{
								$result[$t][$f] = $data[$f];
							}
						break;
					}
				}
			}
		}
		return $result;
	}

	/*
	|--------------------------------------------------------------------------
	|	Crea la estructura de directorios de la nueva cotizacion
	|--------------------------------------------------------------------------
	|	@access private
	|	@params void
	|	@return boolean
	|--------------------------------------------------------------------------
	*/
	private function _createDirStruct()
	{
		$dir = FCPATH.'dtr-quotations/'.$this->lastQuotId;
		
		if(mkdir($dir) AND mkdir("{$dir}/documents") AND mkdir("{$dir}/qrcode"))
		{
			// Mueve el codigo qr a la nueva ubicacion
			$oldQr = FCPATH."dtr-users/{$this->init->activeUser->id_user}/qrcode.png";
			$newQr = FCPATH."dtr-quotations/{$this->lastQuotId}/qrcode/qrcode.png";
			return rename($oldQr , $newQr);
			/*if(rename($oldQr , $newQr))
			{
				// Mueve las imagenes que hayan sido levantadas al servidor
				$oldFolder = FCPATH."dtr-users/{$this->init->activeUser->id_user}/temp/";
				$imgs = get_filenames($oldFolder);
				$newFolder = FCPATH."dtr-quotations/{$this->lastQuotId}/images/";
				foreach ($imgs as $img)
				{
					rename($oldFolder.$img, $newFolder.$img);
				}
				return TRUE;
			}
			return FALSE;*/
		}
		return FALSE;
	}
}