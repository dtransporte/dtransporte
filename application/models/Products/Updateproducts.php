<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|---------------------------------------------------------------------------------------
| MANEJA LOS PRODUCTOS
|---------------------------------------------------------------------------------------
| 
|
*/

class Updateproducts extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}


	/*
	|----------------------------------------------------------------------------------
	|	Actualiza los productos asociados a un usuario
	|----------------------------------------------------------------------------------
	|	@access public
	|	@params int
	|	@return bool
	|----------------------------------------------------------------------------------
	|
	|
	|	Prototipo de valor a insertar o actualizar
	|	[
	|		{"id_category":"2","id_product":"10","receiveFrom":["mera","nafta","ue"]},
	|		{"id_category":"2","id_product":"16","receiveFrom":["mer"]},
	|		{"id_category":"1","id_product":"2","receiveFrom":["only-my-country"]},
	|		{"id_category":"6","id_product":"21","receiveFrom":["neighbours"]},
	|		{"id_category":"6","id_product":"18","receiveFrom":["neighbours","CL"]},
	|		{"id_category":"4","id_product":"13","receiveFrom":["only-my-country"]}
	|	]
	*/
	public function updateByUser($id_user, $data)
	{
		$decoded = json_decode($data['receive_reqs_from'], TRUE);

		$this->db->trans_start();
		foreach ($decoded as $value)
		{
			$d['id_product'] = $value['id_product'];
			$d['id_category'] = $value['id_category'];
			$d['receive_reqs_from'] = trim(json_encode($value['receiveFrom']));
			$exists = $this->db->get_where('dtr_products_user', ['id_user' => $id_user, 'id_product' => $d['id_product']]);
			if($exists->num_rows() == 0)
			{
				$d['id_user'] = $id_user;
				$this->db->insert('dtr_products_user', $d);
			}
			else
			{
				$this->db->where('id_user', $id_user);
				$this->db->where('id_product', $d['id_product']);
				$this->db->update('dtr_products_user', $d);
			}
		}
		$this->_updatePrice($id_user, $data['payment_price']);
		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	private function _updatePrice($id_user, $price)
	{
		$data = [];
		$data['payment_price'] = $price;
		$payment = $this->getusers->getAssocPayments($id_user);
		if(count($payment) > 0)
		{
			$this->db->where('id_user', $id_user);
			$this->db->update('dtr_payments', $data);
		}
		else
		{
			$expiration = now() + $this->config->item('dtr-assoc-freedays')*24*60*60;
			$data['id_user'] = $id_user;
			$data['payment_expiration'] = mdate('%Y-%m-%d', $expiration);
			$this->db->insert('dtr_payments', $data);
		}
	}
}