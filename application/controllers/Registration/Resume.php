<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CONTROLADOR DE REGISTRO DE USUARIO - PAGINA PUBLICA
| -------------------------------------------------------------------
| 
|
*/
class Resume extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(isset($_SESSION['DTRANSPORTE-USER']))
		{
			$this->init->redirectTo();
		}
		$this->load->model('countries');
	}

	/*
	|--------------------------------------------------------------------------
	|	Muestra el resumen del usuario previo al envio de sus datos
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
			$userData = $this->input->get(NULL, TRUE);
			$this->_setResume($userData);

			$modal['modalSize'] = 'modal-lg';
			$modal['modalId'] = 'modal-resume-registration';
			$modal['modalAttribs'] = 'modal-side modal-full-height modal-right modal-notify modal-info';
			$modal['modalTitle'] = $this->lang->line('text-registration-resume');
			$modal['modalFooter'] = $this->_setButtons();
			$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/registration/resume", $this->data, TRUE);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	private function _setResume($data)
	{
		$this->data['userData'] = $data;
		$this->data['userData']['extendedCountry'] = $this->countries->get($data['country']);
	}

	private function _setButtons()
	{
		$btns[] = "<button type=\"button\" class=\"btn btn-primary no-print\" id=\"btn-send-registration\"><span class=\"fas fa-check\"></span> {$this->lang->line('text-send-registration')}</button>";
		$btns[] = "<button type=\"button\" class=\"btn btn-secondary no-print\" data-dismiss=\"modal\"><span class=\"fas fa-times\"></span> {$this->lang->line('text-cancel')}</button>";
		return implode(' ', $btns);
	}
}