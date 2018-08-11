<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Muestra los productos
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Products
| 
|
*/
class Show extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER'])  OR $this->init->activeUser->user_role != 'user' OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		$this->load->model('Products/getproducts');
	}

	/*
	|--------------------------------------------------------------------------
	|	Muestra el listado de productos rol usuario.
	|	Seran usados para agregar una nueva solicitud
	|--------------------------------------------------------------------------
	|	@access public
	|	@params void
	|	@return void
	|--------------------------------------------------------------------------
	*/
	public function index()
	{
		if($this->input->is_ajax_request())
		{
			// Listado de productos y categorias
			$data['categories'] = $this->getproducts->getCategories();
			$data['products'] = $this->getproducts->get();

			$modal['modalSize'] = 'modal-fluid modal-xl';
			$modal['modalId'] = 'modal-show-products';
			$modal['modalAttribs'] = 'cascading-modal';
			$modal['modalTitle'] = $this->lang->line('text-select-product');
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/products/modal-show", $data, TRUE);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}
}