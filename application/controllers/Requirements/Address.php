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
class Address extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']) OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
	}

	public function index()
	{
		if($this->input->is_ajax_request())
		{
			$modal['modalSize'] = 'modal-lg';
			$modal['modalId'] = 'modal-show-address';
			$modal['modalAttribs'] = 'cascading-modal';
			$modal['modalTitle'] = $this->lang->line('text-address');
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/requirements/modal-map", NULL, TRUE);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	public function useAddress()
	{
		if($this->input->is_ajax_request())
		{
			$this->lang->load('tables', $this->init->activeLang);
			$data = "<div id=\"tbl-use-address\"></div>";

			$modal['modalSize'] = 'modal-lg';
			$modal['modalId'] = 'modal-use-address';
			$modal['modalAttribs'] = 'modal-dialog-centered';
			$modal['modalTitle'] = '';
			$modal['modalBody'] = $data;
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	public function loadAddress()
	{
		if($this->input->is_ajax_request())
		{
			$this->load->model('Requirements/getAddress');
			$address_type = $this->input->get('address_type', TRUE);
			$address = $this->getAddress->get($this->init->activeUser->id_user, $address_type);

			$dataAddress[] = ['address' => 'León Pérez 3456, Montevideo, Uruguay'];
			//$dataAddress[] = [];
			if($address)
			{
				foreach ($address as $key => $value)
				{
					$dataAddress[] = [
						'address' => $value->address
					];
				}
			}
			echo json_encode($dataAddress);
		}
	}
}