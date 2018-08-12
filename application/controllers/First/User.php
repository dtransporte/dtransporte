<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador pagina inicio rol usuario
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/First
| 
|
*/
class User extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']) OR $this->init->activeUser->user_first_time == 0)
		{
			$this->init->redirectTo();
			//die('NO ACCESS');
		}
		$this->lang->load('validation', $this->init->activeLang);
		$this->load->model('countries');
		$this->load->model('password');
		$this->load->model('currencies');
	}

	function index()
	{
		$this->_set();
		$this->load->view('index', $this->data);
	}

	function _set()
	{
		// Carga pagina activa y menu
		$this->data['activePage'] = $this->config->item('dtr-first-user-files');
		$this->data['menuItems'] = $this->lang->line('dtr-first-time-menu');

		// Carga listado de paises
		$this->data['countries'] = $this->countries->get();

		// Longitud de contrasenias
		$this->data['minMaxPwd'] = $this->password->setLength();

		// Listado de monedas
		$this->data['currencies'] = $this->currencies->get();

		// Listado de idiomas
		$this->data['languages'] = $this->config->item('dtr-languages');

		// Listado de formatos de fecha
		$this->data['dateFormat'] = $this->config->item('dtr-date-format');

		// Listado de formatos de hora
		$this->data['timeFormat'] = $this->config->item('dtr-time-format');

		// Listado de fuentes disponibles
		$this->data['fontFamily'] = $this->config->item('dtr-font-family');

		// Listado de tamanios fuentes disponibles
		$this->data['fontSize'] = $this->config->item('dtr-font-size');

		// Listado de estilos de menu
		$this->data['menuStyle'] = $this->lang->line('dtr-menu-style');

		// Duracion de bloqueo de pantalla
		$this->data['blockScrDuration'] = $this->config->item('dtr-block-screen-duration');

		// Carga la configuracion de archivos para ser subidos al servidor
		// Elimino los filtros para archivos que no son imagenes
		$imgCfg = $this->config->item('dtr-upload-files');
		unset($imgCfg['filters']['mime_types'][1]);
		$imgCfg['multi_selection'] = 0;
		$imgCfg['multipart_params']['isUserImage'] = 1;
		$imgCfg['multipart_params']['upload_path'] = '%user_path%/me';
		$imgCfg['multipart_params'][$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
		$this->data['imgCfg'] = $imgCfg;
	}
}