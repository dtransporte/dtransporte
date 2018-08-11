<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|---------------------------------------------------------------------------------------
| MANEJA LOS PRODUCTOS
|---------------------------------------------------------------------------------------
| 
|
*/

class Getproducts extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->lang->load('product', $this->init->activeLang);
	}

	/*
	|----------------------------------------------------------------------------------
	|	Obtiene el listado de productos
	|----------------------------------------------------------------------------------
	|	@access public
	|	@params int
	|	@return object
	|----------------------------------------------------------------------------------
	*/
	public function get($id_product=NULL, $showVisible=FALSE)
	{
		$this->db->join('dtr_product_categories', 'dtr_product_categories.id_category = dtr_products.id_category', 'inner');

		if(isset($id_product))
		{
			$this->db->where('dtr_products.id_product', $id_product);
		}
		$isVisible = $showVisible == TRUE ? 0 : 1;
		$this->db->where('dtr_products.product_visible', $isVisible);
		$products = $this->db->get('dtr_products');

		return isset($id_product) ? $products->row() : $products->result();
	}

	/*
	|----------------------------------------------------------------------------------
	|	Obtiene el listado de categorias de productos
	|----------------------------------------------------------------------------------
	|	@access public
	|	@params int
	|	@return object
	|----------------------------------------------------------------------------------
	*/
	public function getCategories($id_category=NULL, $showVisible=FALSE)
	{
		if(isset($id_category))
		{
			$this->db->where('id_category', $id_category);
		}
		$isVisible = $showVisible == TRUE ? 0 : 1;
		$this->db->where('category_visible', $isVisible);
		$this->db->order_by('category_order');
		$categories = $this->db->get('dtr_product_categories');

		return isset($id_category) ? $categories->row() : $categories->result();
	}

	/*
	|----------------------------------------------------------------------------------
	|	Obtiene el listado de productos por usuario
	|----------------------------------------------------------------------------------
	|	@access public
	|	@params int
	|	@return object | FALSE
	|----------------------------------------------------------------------------------
	*/
	public function byUser($id_user)
	{
		$this->db->where('id_user', $id_user);
		$prods = $this->db->get('dtr_products_user');
		return $prods->num_rows() == 0 ? FALSE : $prods->result();
	}

	/*
	|----------------------------------------------------------------------------------
	|	Obtiene el listado de productos por usuario formateados para ser presentado en 
	|	el formulario de productos del usuario
	|----------------------------------------------------------------------------------
	|	@access public
	|	@params int
	|	@return string | FALSE
	|----------------------------------------------------------------------------------
	|
	|	Prototipo de valor retornado
	|	[
	|		{"id_category":"2","id_product":"10","receiveFrom":["mera","nafta","ue"]},
	|		{"id_category":"2","id_product":"16","receiveFrom":["mer"]},
	|		{"id_category":"1","id_product":"2","receiveFrom":["only-my-country"]},
	|		{"id_category":"6","id_product":"21","receiveFrom":["neighbours"]},
	|		{"id_category":"6","id_product":"18","receiveFrom":["neighbours","CL"]},
	|		{"id_category":"4","id_product":"13","receiveFrom":["only-my-country"]}
	|	]
	*/
	public function byUserFormatted($id_user)
	{
		//$this->lang->load('countries', $this->init->activeLang);
		//$this->load->model('countries');
		$result = [];
		$products = $this->byUser($id_user);
		if($products)
		{
			foreach ($products as $prod)
			{
				$receiveFrom = json_decode($prod->receive_reqs_from);
				foreach ($receiveFrom as $from)
				{
					if(!empty($this->lang->line('dtr-country-options')[$from]))
					{
						$receiveFromTxt[$from] = $this->lang->line('dtr-country-options')[$from];
					}
					elseif (!empty($this->lang->line('dtr-economic-blocks')[$from]))
					{
						$receiveFromTxt[$from] = $this->lang->line('dtr-economic-blocks')[$from];
					}
					else{
						$country = $this->countries->get($from);
						$receiveFromTxt[$from] = $country->country;
					}
				}
				$result[] = [
					'id_category' => $prod->id_category,
					'id_product' => $prod->id_product,
					'receiveFrom' => $receiveFrom,
					'receiveFromTxt' => $receiveFromTxt
				];
			}
			return $result;
		}
		return FALSE;
	}
}

/*
*/