<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador paises
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Users
| 
|
*/
class Country extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']))
		{
			$this->init->redirectTo();
			die('NO ACCESS');
		}
		$this->load->model('countries');
		$this->lang->load('countries', $this->init->activeLang);
	}

	public function getAll()
	{
		if($this->input->is_ajax_request())
		{
			$this->_countries();
			//$this->_eblocks();
			$this->_neighbours();
			$this->_byEblock();
			$this->data['countryOptions'] = $this->lang->line('dtr-country-options');
			$this->data['economicBlocksTxt'] = $this->lang->line('dtr-economic-blocks');
			$this->data['myCountry'] = $this->countries->get($this->init->activeUser->country);

			$modal['modalSize'] = 'modal-fluid';
			$modal['modalId'] = 'modal-show-countries';
			$modal['modalAttribs'] = 'modal-bottom modal-full-height modal-notify modal-primary';
			$modal['modalTitle'] = $this->lang->line('text-economic-blocks');
			$modal['modalFooter'] = $this->_setButtons();
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/products/modal-countries", $this->data, TRUE);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	private function _countries($id_country=NULL)
	{
		$this->data['countries'] = $this->countries->get($id_country);
	}

	private function _eblocks($id_block=NULL)
	{
		$this->data['economicBlocks'] = $this->countries->get($id_block);
	}

	private function _neighbours()
	{
		$this->data['neighbours'] = $this->countries->getNeighbours();
	}

	private function _byEblock($id_block=NULL)
	{
		$this->data['countriesByEblock'] = $this->countries->getCountryByBlock($id_block);
	}

	private function _setButtons()
	{
		return "<button type=\"button\" class=\"btn btn-primary btn-lg btn-block no-print\" id=\"btn-add-blocks\"><span class=\"fas fa-check\"></span> {$this->lang->line('text-add')}</button>";
	}
}