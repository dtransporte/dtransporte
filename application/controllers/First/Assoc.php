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
class Assoc extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']) OR $this->init->activeUser->user_role != 'assoc' OR $this->init->activeUser->user_first_time == 0)
		{
			$this->init->redirectTo();
			die('NO ACCESS');
		}
		$this->lang->load('validation', $this->init->activeLang);
		$this->lang->load('countries', $this->init->activeLang);
		$this->load->model('countries');
		$this->load->model('password');
		$this->load->model('currencies');
		$this->load->model('Products/getproducts');
	}

	function index()
	{
		$this->_set();
		$this->load->view('index', $this->data);
	}

	function _set()
	{
		// Carga pagina activa y menu
		$this->data['activePage'] = $this->config->item('dtr-first-assoc-files');
		$this->data['menuItems'] = $this->lang->line('dtr-first-time-menu');

		// Carga paises y bloques economicos
		$this->data['countries'] = $this->countries->get();
		$this->data['countryOptions'] = $this->lang->line('dtr-country-options');
		$this->data['economicBlocks'] = $this->lang->line('dtr-economic-blocks');
		$this->data['myCountry'] = $this->countries->get($this->init->activeUser->country);

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

		// Levanta los pagos de la empresa
		$payment = $this->getusers->getAssocPayments($this->init->activeUser->id_user);
		$payment = $payment[0];
		$this->data['paymentDay'] = mdate($this->init->activeUser->user_dformat, mysql_to_unix($payment->payment_expiration.' 00:00:00'));
		$this->data['paymentAmount'] = $payment->payment_price;

		// Listado de productos y categorias
		$this->data['categories'] = $this->getproducts->getCategories();
		$this->data['products'] = $this->getproducts->get();
		$this->data['productsByUser'] = $this->getproducts->byUser($this->init->activeUser->id_user);
		$this->data['productsByUserFormatted'] = $this->getproducts->byUserFormatted($this->init->activeUser->id_user);

		// Carga la configuracion de archivos para ser subidos al servidor
		// Elimino los filtros para archivos que no son imagenes
		$imgCfg = $this->config->item('dtr-upload-files');
		unset($imgCfg['filters']['mime_types'][1]);
		$imgCfg['multi_selection'] = 0;
		$imgCfg['multipart_params']['isUserImage'] = 1;
		$imgCfg['multipart_params']['upload_path'] = '%user_path%/me';
		$imgCfg['multipart_params'][$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
		$this->data['imgCfg'] = $imgCfg;

		$message = json_encode($this->lang->line('dtr-product-noselect'));
		$this->data['activePage']['fns'][] = "var NoServiceSelected = {$message};\n";
	}
}