<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Actualiza los productos asociados a un usuario
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Products
| 
|
*/
class UpdateByUser extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']))
		{
			//$this->init->redirectTo();
			die('NO ACCESS');
		}
		$this->load->model('Products/updateproducts');
	}

	public function index()
	{
		if($this->input->is_ajax_request())
		{
			$msgId = 'dtr-message-update-error';
			$data = $this->input->post(NULL, TRUE);
			if($this->updateproducts->updateByUser($this->init->activeUser->id_user, $data))
			{
				$msgId = 'dtr-message-update-ok';
			}
			$result = [
				'msg' => $this->lang->line($msgId),
				'hash' => $this->security->get_csrf_hash()
			];
			echo json_encode($result);
		}
	}

	/*
	|--------------------------------------------------------------------------
	|	Elimina un producto asociado al usuario activo
	|--------------------------------------------------------------------------
	|	@access public
	|	@params void
	|	@return void
	|--------------------------------------------------------------------------
	*/
	function remove()
	{
		if($this->input->is_ajax_request())
		{
			$msgId = 'dtr-message-delete-error';
			$data = $this->input->get(NULL, TRUE);
			$this->db->where('id_product', $data['id_product']);
			$this->db->where('id_user', $this->init->activeUser->id_user);
			if($this->db->delete('dtr_products_user'))
			{
				$msgId = 'dtr-message-delete-ok';
			}
			echo json_encode([
				'hash' => $this->security->get_csrf_hash(),
				'message' => $this->lang->line($msgId)
				]
			);
		}
	}
}