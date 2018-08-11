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
class Add extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER'])  OR $this->init->activeUser->user_role != 'user' OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		$this->config->load('config.requirements');
		$this->lang->load('requirement', $this->init->activeLang);
		$this->lang->load('tables', $this->init->activeLang);
		$this->load->model('Products/getproducts');
		$this->load->model('Requirements/setViews');
		$this->load->model('codeqr');
		$this->load->model('countries');
		$this->load->model('currencies');
	}

	function index($id_product, $product_attributes=NULL)
	{
		$this->_set($id_product, $product_attributes);
		$this->load->view('index', $this->data);
	}

	function _set($id_product, $product_attributes=NULL)
	{
		// Carga pagina activa y menu
		$this->data['activePage'] = $this->config->item('dtr-requirements-add-files');
		$this->data['menuItems'] = $this->lang->line('dtr-user-menu');

		// Carga el producto activo
		$this->data['product'] = $this->getproducts->get($id_product);

		// Carga las vistas a ser mostradas en los tabs
		$views = $this->setViews->set($id_product, $product_attributes);
		$this->data['requirementsViews'] = $views;
		if($id_product == 10 AND isset($product_attributes) AND $product_attributes === 'fcl')
		{
			$this->lang->load('containers', $this->init->activeLang);
		}

		if($id_product == 9 OR $id_product == 10 OR $id_product == 16)
		{
			$this->lang->load('incoterm', $this->init->activeLang);
		}

		if($id_product == 6)
		{
			$this->lang->load('moving', $this->init->activeLang);
		}

		// Establece la imagen y el texto del codigo qr
		$qrCode = $this->codeqr->get();
		$this->data['qrText'] = $this->codeqr->qrText;
		$this->data['qrImageSrc'] = $this->init->activeUser->userDir.'/qrcode.png';

		// Carga listado de paises
		$this->data['countries'] = $this->countries->get();
		$this->data['myCountry'] = $this->countries->get($this->init->activeUser->country);

		// Carga listado de monedas
		$this->data['currencies'] = $this->currencies->get();

		// Carga config de imagenes
		$imagesCfg = $this->config->item('dtr-upload-files');
		// Elimina extensiones que no son imagenes
		unset($imagesCfg['filters']['mime_types'][1]);
		$imagesCfg['multipart_params']['upload_path'] = $this->init->activeUser->userPath.'/temp/';
		$imagesCfg['multipart_params']['maxFilesUpload'] = $this->config->item('dtr-requirements-max-files');
		$imagesCfg['multipart_params']['deleteFiles'] = 0;
		$imagesCfg['multipart_params']['previewContainer'] = 'images-requirements-preview';
		$this->data['imagesCfg'] = $imagesCfg;

		// Elimina todas las imagenes del directorio temp
		delete_files($this->init->activeUser->userPath.'/temp/');

		$difExpSch = $this->config->item('dtr-dif-exp-sch');
		$this->data['activePage']['fns'][] = "var DifExpSch = {$difExpSch};\n";

		$userDtf = str_replace(['%d', '%m', '%Y', '%H', '%i', '%s', '%a'], ['DD', 'MM', 'YYYY', 'HH', 'mm', '', ''], $this->init->activeUser->dtf);
		$userDtf = trim($userDtf);
		$this->data['activePage']['fns'][] = "var UserDtf = '{$userDtf}';\n";

		$fancyData = json_encode($this->lang->line('dtr-grid-user-address'));
		$this->data['activePage']['fns'][] = "var FGData = {$fancyData};\n";

		$fancyHs = json_encode($this->lang->line('dtr-grid-hs-codes'));
		$this->data['activePage']['fns'][] = "var FGHs = {$fancyHs};\n";

		$errorReqMessage =  json_encode($this->lang->line('dtr-message-add-requirement-error'));
		$this->data['activePage']['fns'][] = "var ErrorMessages = {$errorReqMessage};\n";

		$this->data['activePage']['fns'][] = "var ProductType = '{$product_attributes}';\n";
	}
}