<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador resumen de solicitud
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Requirements
| 
|
*/
class Resume extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']) OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		$this->config->load('config.requirements');
		$this->lang->load('requirement', $this->init->activeLang);
		$this->load->model('Products/getproducts');
		$this->load->model('Requirements/setViews');
		$this->load->model('countries');
		$this->load->model('currencies');
	}


	function set()
	{
		if($this->input->is_ajax_request())
		{
			$get  = $this->input->get(NULL, TRUE);
			$product_type = isset($get['cargo_product_type']) ? $get['cargo_product_type'] : NULL;
			$data['resume'] = $get;
			// Carga el producto activo
			$data['product'] = $this->getproducts->get($get['id_product']);

			// Carga codigo qr
			$data['qrImageSrc'] = $this->init->activeUser->userDir.'/qrcode.png';
			$data['qrText'] = $get['requirement_qrcode'];

			// Carga las vistas
			$data['views'] = $this->setViews->set($get['id_product'], $product_type, TRUE);

			// Carga listado de monedas
			$data['currencies'] = $this->currencies->get();

			// Carga las imagenes si fueron definidas
			$path = $this->init->activeUser->userPath.'/temp/';
			$images = get_filenames($path);
			if(count($images) > 0)
			{
				foreach ($images as $img)
				{
					$data['images'][] = $this->init->activeUser->userDir.'/temp/'.$img;
				}
			}

			// Carga nombres de paises
			if(isset($get['country']))
			{
				$data['resume']['country'] = $this->countries->get($get['country']);
			}
			else
			{
				$data['resume']['o-country'] = $this->countries->get($get['o-country']);
				$data['resume']['d-country'] = $this->countries->get($get['d-country']);
			}

			if($get['id_product'] == 10 AND isset($product_type) AND $product_type === 'fcl')
			{
				$this->lang->load('containers', $this->init->activeLang);
			}

			if($get['id_product'] == 9 OR $get['id_product'] == 10 OR $get['id_product'] == 16)
			{
				$this->lang->load('incoterm', $this->init->activeLang);
			}

			if($get['id_product'] == 6)
			{
				$this->lang->load('moving', $this->init->activeLang);
			}

			$modal = $this->_setModal($data, $data['resume']['requirement_status']);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	function get()
	{
		if($this->input->is_ajax_request())
		{
			$this->load->model('Requirements/getRequirement');
			$id_requirement = $this->input->get('id_requirement', TRUE);

			// Obtiene la solicitud
			$req = $this->getRequirement->get($id_requirement, NULL, TRUE);
			//var_dump($req);
			$requirement = $req[0];
			$data['resume'] = $requirement;

			// Carga el producto activo
			$data['product'] = $this->getproducts->get($requirement['id_product']);

			// Carga listado de monedas
			$data['currencies'] = $this->currencies->get();

			// Carga las vistas
			$data['views'] = $this->setViews->set($requirement['id_product'], $requirement['cargo_product_type'], TRUE);

			// Carga codigo qr
			$data['qrImageSrc'] = base_url()."dtr-requirements/{$requirement['id_requirement']}/qrcode/qrcode.png";
			$data['qrText'] = $requirement['requirement_qrcode'];

			foreach($req as $r)
			{
				if($r['address_type'] === 'origin')
				{
					if($data['views']['attributes']['views']['show-destination'] == 1)
					{
						$data['resume']['o-country'] = $this->countries->get($r['country']);
						$data['resume']['o-address'] = $r['address'];
						$data['resume']['o-address_notes'] = $r['address_notes'];
					}
					else
					{
						$data['resume']['country'] = $this->countries->get($r['country']);
						$data['resume']['address'] = $r['address'];
						$data['resume']['address_notes'] = $r['address_notes'];
					}
				}
				elseif($r['address_type'] === 'destination')
				{
					$data['resume']['d-country'] = $this->countries->get($r['country']);
					$data['resume']['d-address'] = $r['address'];
					$data['resume']['d-address_notes'] = $r['address_notes'];
				}
				elseif($r['address_type'] === 'waypoint')
				{
					$data['resume']['wp-address'][] = $r['address'];
					$data['resume']['wp-notes'][] = $r['address_notes'];
				}
			}
			

			// Carga las imagenes si fueron definidas
			$dir = "dtr-requirements/{$requirement['id_requirement']}/images/";
			$path = FCPATH.$dir;
			$images = get_filenames($path);
			if(count($images) > 0)
			{
				foreach ($images as $img)
				{
					$data['images'][] = base_url()."{$dir}{$img}";
				}
			}

			if($requirement['id_product'] == 10 AND isset($requirement['cargo_product_type']) AND $requirement['cargo_product_type'] === 'fcl')
			{
				$this->lang->load('containers', $this->init->activeLang);
			}

			if($requirement['id_product'] == 9 OR $requirement['id_product'] == 10 OR $requirement['id_product'] == 16)
			{
				$this->lang->load('incoterm', $this->init->activeLang);
			}

			if($requirement['id_product'] == 6)
			{
				$this->lang->load('moving', $this->init->activeLang);
			}

			$modal = $this->_setModal($data);
			echo $this->load->view('modal', $modal, TRUE);
		}
	}

	private function _setButtons($status=NULL)
	{
		if(isset($status))
		{
			$btn[] = "<div class=\"btn-toolbar justify-content-between alert w-100\" role=\"toolbar\">";
				$btn[] = "<div class=\"btn-group\" role=\"group\">";
				if($status === 'active')
				{
					$btn[] = "<button type=\"button\" class=\"btn btn-primary btn-lg btn-send\" id=\"btn-send\"><i class=\"fas fa-envelope\"></i> {$this->lang->line('text-send')}</button>";
				}
				elseif($status === 'prog')
				{
					$btn[] = "<button type=\"button\" class=\"btn btn-primary btn-lg btn-send\" id=\"btn-prog\"><i class=\"fas fa-clock\"></i> {$this->lang->line('text-prog')}</button>";
				}
				else
				{
					$btn[] = "<button type=\"button\" class=\"btn btn-primary btn-lg btn-send\" id=\"btn-save\"><i class=\"fas fa-save\"></i> {$this->lang->line('text-save')}</button>";
				}
				$btn[] = "<button type=\"button\" class=\"btn btn-secondary btn-lg\" id=\"btn-print\"><i class=\"fas fa-print\"></i> {$this->lang->line('text-print')}</button>";
				$btn[] = "</div>";
				$btn[] = "<div class=\"btn-group\" role=\"group\">";
					$btn[] = "<button type=\"button\" class=\"btn btn-default btn-lg\" data-dismiss=\"modal\"><i class=\"fas fa-ban\"></i> {$this->lang->line('text-close')}</button>";
				$btn[] = "</div>";
			$btn[] = "</div>";
		}
		else
		{
			$btn[] = "<button type=\"button\" class=\"btn btn-unique btn-lg\" data-dismiss=\"modal\"><i class=\"fas fa-ban\"></i> {$this->lang->line('text-close')}</button>";
			$btn[] = "<button type=\"button\" class=\"btn btn-secondary btn-lg\" id=\"btn-print\"><i class=\"fas fa-print\"></i> {$this->lang->line('text-print')}</button>";
		}
		return implode('', $btn);
	}

	private function _setModal($data, $status=NULL)
	{
		$modal['modalAttribs'] = isset($status) ? 'modal-warning' : 'modal-info';
		$modal['modalSize'] = 'modal-lg';
		$modal['modalId'] = 'modal-requirement-resume';
		$modal['modalAttribs'] .= ' modal-full-height modal-top modal-notify ';
		$modal['modalTitle'] = '<span class="text-dark">'.$this->lang->line('text-requirement-resume').'</span>';
		$modal['modalFooter'] = $this->_setButtons($status);
		$modal['modalBody'] = $this->load->view("{$this->init->activeLang}/requirements/modal-resume", $data, TRUE);
		return $modal;
	}

}