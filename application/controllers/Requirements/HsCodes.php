<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador agregar nueva solicitud
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Requirements
| 
|
*/
class HsCodes extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER'])  OR $this->init->activeUser->user_role != 'user' OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		$this->lang->load('tables', $this->init->activeLang);
	}

	public function index()
	{
		if($this->input->is_ajax_request())
		{
			$data = "<div id=\"grid-hs-codes\"></div>";

			$modal['modalSize'] = 'modal-lg';
			$modal['modalId'] = 'modal-hs-codes';
			$modal['modalAttribs'] = 'modal-dialog-centered modal-notify modal-danger';
			$modal['modalTitle'] = $this->lang->line('text-hs-codes');
			$modal['modalFooter'] = $this->_setButtons();
			$modal['modalBody'] = $data;
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	public function load()
	{
		if($this->input->is_ajax_request())
		{
			$this->load->model('Requirements/getHsCodes');
			
			$code = $this->input->get('code', TRUE);

			$codes = $this->getHsCodes->get($code);
			
			foreach ($codes as $key => $value)
			{
				$dataCodes[] = [
					'code' => $value->code,
					'description' => $value->description
				];
			}
			echo json_encode($dataCodes);
		}
	}

	private function _setButtons()
	{
		return "<button class=\"btn btn-outline-danger\" id=\"btn-insert-code\" disabled><i class=\"fas fa-plus\"></i> {$this->lang->line('text-add')}</button>";
	}
}