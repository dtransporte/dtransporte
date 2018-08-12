<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE OBTENCION DE USUARIOS
|--------------------------------------------------------------------------
| Obtiene las direcciones de usuarios
| 
|
*/

class InsertRequirement extends CI_Model
{
	private $tables = [
		'dtr_requirements',
		'dtr_requirements_detail',
		'dtr_requirements_optype'
	];

	private $lastReqId = NULL;

	function __construct()
	{
		parent::__construct();
	}

	public function insert($data)
	{
		if($this->_insert($data))
		{
			if($this->_createDirStruct())
			{
				if($data['requirement_status'] === 'active')
				{
					$this->load->model('Requirements/sendRequirement');
					$this->load->model('Requirements/getRequirement');
					$requirement = $this->getRequirement->get($this->lastReqId);
					return $this->sendRequirement->send($requirement);
				}
				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}

	/*
	|--------------------------------------------------------------------------
	|	Inserta una nueva solicitud
	|--------------------------------------------------------------------------
	|	@access public
	|	@params array
	|	@return bool
	|--------------------------------------------------------------------------
	*/
	private function _insert($data)
	{
		$result = [];
		if(isset($data['o-address']))
		{
			$oaddress = $this->_setAddress($data, 'o-');
			$daddress = $this->_setAddress($data, 'd-');
		}
		else
		{
			$address = $this->_setAddress($data, '');
		}
		$dataInsert = $this->_setData($data);

		$this->db->trans_start();
			$this->db->insert('dtr_requirements', $dataInsert['dtr_requirements']);
			$lastReqId = $this->db->insert_id();
			$this->lastReqId = $lastReqId;

			$dataInsert['dtr_requirements_detail']['id_requirement'] = $lastReqId;
			$this->db->insert('dtr_requirements_detail', $dataInsert['dtr_requirements_detail']);

			if(isset($dataInsert['dtr_requirements_optype']))
			{
				$dataInsert['dtr_requirements_optype']['id_requirement'] = $lastReqId;
				$this->db->insert('dtr_requirements_optype', $dataInsert['dtr_requirements_optype']);
			}

			// Agrega direccion origen si esta definida
			if(isset($oaddress['dtr_requirements_address']['o-']))
			{
				if(isset($oaddress['dtr_address']['o-']))
				{
					$this->db->insert('dtr_address', $oaddress['dtr_address']['o-']);
					$lastAddressId = $this->db->insert_id();
					$oaddress['dtr_requirements_address']['o-']['id_address'] = $lastAddressId;
				}
				$oaddress['dtr_requirements_address']['o-']['id_requirement'] = $lastReqId;
				$this->db->insert('dtr_requirements_address', $oaddress['dtr_requirements_address']['o-']);
			}

			// Agrega direccion destino si esta definida
			if(isset($daddress['dtr_requirements_address']['d-']))
			{
				if(isset($daddress['dtr_address']['d-']))
				{
					$this->db->insert('dtr_address', $daddress['dtr_address']['d-']);
					$lastAddressId = $this->db->insert_id();
					$daddress['dtr_requirements_address']['d-']['id_address'] = $lastAddressId;
				}
				$daddress['dtr_requirements_address']['d-']['id_requirement'] = $lastReqId;
				$this->db->insert('dtr_requirements_address', $daddress['dtr_requirements_address']['d-']);
			}

			// Agrega direccion presentacion si esta definida
			
			if(isset($address))
			{
				if(isset($address['dtr_address']))
				{
					$this->db->insert('dtr_address', $address['dtr_address']);
					$lastAddressId = $this->db->insert_id();
					$address['dtr_requirements_address']['id_address'] = $lastAddressId;
				}
				$address['dtr_requirements_address']['id_requirement'] = $lastReqId;
				$address['dtr_requirements_address']['address_type'] = 'origin';
				$this->db->insert('dtr_requirements_address', $address['dtr_requirements_address']);
			}

			// Agrega paradas interemedias si estan definidas
			if(isset($data['wp-address']))
			{
				$this->_insertWayPoints($data['wp-address'], $data['wp-notes']);
			}
			
		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	private function _setData($data)
	{
		$user = $this->init->activeUser;
		$result = [];
		foreach ($this->tables as $t)
		{
			$fields = $this->db->list_fields($t);
			foreach($fields as $f)
			{
				if($this->db->field_exists($f, $t))
				{
					switch ($f)
					{
						case 'id_user':
							$result[$t]['id_user'] = $user->id_user;
						break;

						case 'requirement_entered':
							$tz = $user->user_timezone;
							$result[$t]['requirement_entered'] = mdate($this->config->item('dtr-datetime-db'), now($tz));
						break;

						case 'requirement_name':
							if(empty(trim($data['requirement_name'])))
							{
								$this->load->helper('string');
								$result[$t][$f] = random_string('numeric', 4);
							}
							else
							{
								$result[$t][$f] = $data[$f];
							}
						break;
						
						default:
							if(isset($data[$f]))
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
	##########################################################################
	#	DIRECCIONES
	##########################################################################
	/*
	|--------------------------------------------------------------------------
	|	Establece las direcciones a ser insertadas
	|--------------------------------------------------------------------------
	|	@access private
	|	@params array
	|	@return array
	|--------------------------------------------------------------------------
	*/
	private function _setAddress($data, $prefix)
	{
		$result = [];
		$address = [];
		
		$address = $this->_existsAddress($data, $prefix);
		$address_type = ($prefix === 'o-' OR $prefix == '') ? 'origin' : 'destination';
		if(is_array($address))
		{
			$result = $address;
			$id_address = '';
		}
		else
		{
			$id_address = $address;
		}
		if($prefix == '')
		{
			$result['dtr_requirements_address']['address_notes'] = $data['address_notes'];
			$result['dtr_requirements_address']['id_address'] = $id_address;
			$result['dtr_requirements_address']['address_type'] = $address_type;
		}
		else
		{
			$result['dtr_requirements_address'][$prefix]['address_notes'] = $data[$prefix.'address_notes'];
			$result['dtr_requirements_address'][$prefix]['id_address'] = $id_address;
			$result['dtr_requirements_address'][$prefix]['address_type'] = $address_type;
		}
		
		return $result;
	}

	/*
	|--------------------------------------------------------------------------
	|	Elimina los prefijos de las direcciones a ser insertadas
	|--------------------------------------------------------------------------
	|	@access private
	|	@params array, string
	|	@return array
	|--------------------------------------------------------------------------
	*/
	private function _setAddressKeys($data, $prefix)
	{
		$result = [];
		foreach($data as $key => $address)
		{
			if($prefix != '')
			{
				$pref = substr($key, 0, 2);
				if($pref === $prefix)
				{
					$key = substr($key, 2);
				}
			}
			if ($this->db->field_exists($key, 'dtr_address'))
			{
				if($prefix != '')
				{
					$result['dtr_address'][$prefix][$key] = $address;
				}
				else
				{
					$result['dtr_address'][$key] = $address;
				}
			}
		}
		return $result;
	}

	/*
	|--------------------------------------------------------------------------
	|	Chequea si las direcciones ya existen
	|--------------------------------------------------------------------------
	|	@access private
	|	@params array, string
	|	@return array
	|--------------------------------------------------------------------------
	*/
	private function _existsAddress($data, $prefix)
	{
		$result = [];
		$address = $this->_setAddressKeys($data, $prefix);
		if($prefix == '')
		{
			$queryAddr = $this->db->get_where('dtr_address', ['place_id' => $address['dtr_address']['place_id']]);
		}
		else
		{
			$queryAddr = $this->db->get_where('dtr_address', ['place_id' => $address['dtr_address'][$prefix]['place_id']]);
		}

		// Si no existe la direccion prepara el array de datos para ser insertado
		if($queryAddr->num_rows() == 0)
		{
			$result = $address;
		}
		// Si existe la direccion, devuelve el id de la misma
		else
		{
			$query = $queryAddr->row();
			$result = $query->id_address;
		}
		return $result;
	}

	private function _insertWayPoints($wpadress, $wpnotes)
	{
		foreach ($wpadress as $k => $w)
		{
			$queryAddr = $this->db->get_where('dtr_address', ['address' => $w]);
			if($queryAddr->num_rows() == 0)
			{
				$data['address'] = $w;
				$this->db->insert('dtr_address', $data);
				$lastAddressId = $this->db->insert_id();

				$wp['id_address'] = $lastAddressId;
				$wp['address_type'] = 'waypoint';
				$wp['address_notes'] = trim($wpnotes[$k]);
				$wp['id_requirement'] = $this->lastReqId;
				$this->db->insert('dtr_requirements_address', $wp);
			}
			else
			{
				$query = $queryAddr->row();
				$data = [
					'id_address' => $query->id_address,
					'id_requirement' => $this->lastReqId,
					'address_type' => 'waypoint',
					'address_notes' => trim($wpnotes[$k])
				];
				$this->db->insert('dtr_requirements_address', $data);
			}
		}
	}

	/*
	|--------------------------------------------------------------------------
	|	Crea la estructura de directorios de la nueva solicitud y mueve las 
	|	imagenes que hayan sido levantadas al nuevo directorio
	|--------------------------------------------------------------------------
	|	@access private
	|	@params void
	|	@return boolean
	|--------------------------------------------------------------------------
	*/
	private function _createDirStruct()
	{
		$dir = FCPATH.'dtr-requirements/'.$this->lastReqId;
		
		if(mkdir($dir) AND mkdir("{$dir}/images") AND mkdir("{$dir}/qrcode"))
		{
			// Mueve el codigo qr a la nueva ubicacion
			$oldQr = FCPATH."dtr-users/{$this->init->activeUser->id_user}/qrcode.png";
			$newQr = FCPATH."dtr-requirements/{$this->lastReqId}/qrcode/qrcode.png";
			if(rename($oldQr , $newQr))
			{
				// Mueve las imagenes que hayan sido levantadas al servidor
				$oldFolder = FCPATH."dtr-users/{$this->init->activeUser->id_user}/temp/";
				$imgs = get_filenames($oldFolder);
				$newFolder = FCPATH."dtr-requirements/{$this->lastReqId}/images/";
				foreach ($imgs as $img)
				{
					rename($oldFolder.$img, $newFolder.$img);
				}
				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}
}

/*
	DATA
array(2) {
  ["dtr_requirements"]=>
  array(8) {
    ["id_product"]=>
    string(1) "2"
    ["requirement_name"]=>
    string(9) "Repuestos"
    ["requirement_status"]=>
    string(6) "active"
    ["requirement_expiration"]=>
    string(16) "2018-07-29 14:47"
    ["requirement_schedule"]=>
    string(16) "2018-07-29 22:47"
    ["requirement_currency"]=>
    string(6) "native"
    ["requirement_pay_terms"]=>
    string(7) "contado"
    ["requirement_notes"]=>
    string(4) "nada"
  }
  ["dtr_requirements_detail"]=>
  array(5) {
    ["cargo_units_qty"]=>
    string(1) "1"
    ["cargo_weight"]=>
    string(5) "30000"
    ["cargo_volume"]=>
    string(2) "35"
    ["cargo_additionals"]=>
    string(169) "[{"item":"forklift","name":"Autoelevador","quantity":"1","place":"origin","notes":""},{"item":"workers","name":"Peones","quantity":"3","place":"destination","notes":""}]"
    ["cargo_notes"]=>
    string(19) "material paletizado"
  }
}
{"csrf":"","msg":{"cls":"success","message":"La solicitud ha sido exitosamente agregada.","duration":3000,"href":"index.php\/Place\/User"}}





 DIRECCIONES
	array(1) {
  ["dtr_requirements_address"]=>
  array(1) {
    ["o-"]=>
    array(3) {
      ["address_type"]=>
      string(6) "origin"
      ["address_notes"]=>
      string(10) "origennnnn"
      ["id_address"]=>
      string(1) "1"
    }
  }
}
array(2) {
  ["dtr_requirements_address"]=>
  array(1) {
    ["d-"]=>
    array(3) {
      ["address_type"]=>
      string(11) "destination"
      ["address_notes"]=>
      string(13) "destinooooooo"
      ["id_address"]=>
      string(0) ""
    }
  }
  ["dtr_address"]=>
  array(1) {
    ["d-"]=>
    array(1) {
      ["dtr_address"]=>
      array(1) {
        ["d-"]=>
        array(1) {
          ["dtr_address"]=>
          array(7) {
            ["latitude"]=>
            string(11) "-31.4679335"
            ["longitude"]=>
            string(11) "-57.1013188"
            ["place_id"]=>
            string(27) "ChIJqYIp4ifdrZURPwLSqN75meQ"
            ["postal_code"]=>
            string(0) ""
            ["locality"]=>
            string(0) ""
            ["country"]=>
            string(2) "UY"
            ["address"]=>
            string(30) "Departamento de Salto, Uruguay"
          }
        }
      }
    }
  }
}
{"csrf":{"csrf_test_name":"da73bdf2d119fadd6e0941d4a8e38a51"},"msg":{"cls":"danger","message":"ERROR !!!<br>La solicitud no ha podido ser agregada.","duration":5000}}
*/