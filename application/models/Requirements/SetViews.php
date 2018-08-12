<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE OBTENCION DE USUARIOS
|--------------------------------------------------------------------------
| Obtiene los usuarios en funcion de su id o nombre
| 
|
*/

class SetViews extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	/*
	|--------------------------------------------------------------------------
	|	Establece las vistas a mostrar en los tabs
	|--------------------------------------------------------------------------
	|	@access int, string
	|	@params void
	|	@return array
	|--------------------------------------------------------------------------
	*/
	public function set($id_product, $product_attributes=NULL, $isResume=FALSE)
	{
		$result = [];
		$texts = $this->lang->line('tab');
		$icons = $this->lang->line('tab-icon');
		$views = $this->config->item('dtr-requirements-views');
		switch ($id_product) 
		{
			case 1:		// Carga liviana
			case 2: 	// Carga pesada
			case 17: 	// Flete express
			case 18: 	// Mercaderia peligrosa
			case 19: 	// Cargas vivas
			case 20: 	// Traslado vehiculos
			case 21: 	// Carga Regrigerada
				unset($views['operation-type']);
				unset($views['address']['presentation-address']);
				unset($views['cargo']['cargo-moving']);
				unset($views['cargo']['cargo-moving-details']);
				unset($views['cargo']['cargo-details-container']);
				unset($views['cargo']['cargo-details-warehousing']);
				unset($views['cargo']['cargo-details-forklift']);
				if($id_product != 18)
				{
					unset($views['cargo']['cargo-details-hazard']);
				}
				$views['attributes'] = [
					'mirror-address' => 1,
					'show-route' => 1,
					'show-origin' => 1,
					'show-destination' => 1,
					'show-waypoints' => 1,
					'show-containers' => 0
				];
			break;

			case 6:		// Mudanzas
				unset($views['operation-type']);
				unset($views['cargo']['cargo-details-warehousing']);
				unset($views['cargo']['cargo-details']);
				unset($views['cargo']['cargo-specials']);
				unset($views['cargo']['cargo-details-hazard']);
				unset($views['cargo']['cargo-details-container']);
				unset($views['cargo']['cargo-details-forklift']);
				if(isset($product_attributes) AND $product_attributes === 'visit-required')
				{
					unset($views['address']['origin-address']);
					unset($views['address']['destination-address']);
					unset($views['address']['waypoints-address']);
					unset($views['cargo']['cargo-moving-details']);
					$views['attributes'] = [
						'mirror-address' => 0,
						'show-route' => 0,
						'show-origin' => 1,
						'show-destination' => 0,
						'show-waypoints' => 0,
						'show-containers' => 0
					];
				}
				else
				{
					unset($views['address']['presentation-address']);
					$views['attributes'] = [
						'mirror-address' => 1,
						'show-route' => 1,
						'show-origin' => 1,
						'show-destination' => 1,
						'show-waypoints' => 1,
						'show-containers' => 0
					];
				}
			break;

			case 9:		// Aereo Intl
				unset($views['address']['presentation-address']);
				unset($views['cargo']['cargo-moving']);
				unset($views['cargo']['cargo-moving-details']);
				unset($views['cargo']['cargo-details-hazard']);
				unset($views['cargo']['cargo-details-warehousing']);
				unset($views['address']['waypoints-address']);
				unset($views['cargo']['cargo-details-forklift']);
				unset($views['cargo']['cargo-details-container']);
				$views['attributes'] = [
					'mirror-address' => 0,
					'show-route' => 0,
					'show-origin' => 1,
					'show-destination' => 1,
					'show-waypoints' => 0,
					'show-containers' => 0
				];
			break;

			case 10:	// Maritimo Intl
			case 16:	// Terrestre Intl
				unset($views['address']['presentation-address']);
				unset($views['cargo']['cargo-moving']);
				unset($views['cargo']['cargo-moving-details']);
				unset($views['cargo']['cargo-details-hazard']);
				unset($views['cargo']['cargo-details-warehousing']);
				unset($views['cargo']['cargo-details-forklift']);
				$views['attributes'] = [
					'mirror-address' => 0,
					'show-route' => 0,
					'show-origin' => 1,
					'show-destination' => 1
				];
				if(isset($product_attributes) AND $product_attributes === 'lcl')
				{
					$views['attributes']['show-containers'] = 0;
					unset($views['cargo']['cargo-details-container']);
				}
				if($id_product == 16)
				{
					unset($views['cargo']['cargo-details-container']);
					$views['attributes']['show-waypoints'] = 1;
					$views['attributes']['show-route'] = 1;
					$views['attributes']['show-containers'] = 0;
				}
				else
				{
					unset($views['address']['waypoints-address']);
					if($product_attributes === 'lcl')
					{
						$views['attributes']['show-containers'] = 0;
					}
					else
					{
						$views['attributes']['show-containers'] = 1;
					}
				}
			break;

			case 11:	// Alquiler autoelevadores
			case 12:	// Alquiler gruas
				unset($views['address']['origin-address']);
				unset($views['address']['destination-address']);
				unset($views['cargo']['cargo-moving']);
				unset($views['cargo']['cargo-moving-details']);
				unset($views['cargo']['cargo-details-hazard']);
				unset($views['cargo']['cargo-details-warehousing']);
				unset($views['cargo']['cargo-specials']);
				unset($views['address']['waypoints-address']);
				unset($views['cargo']['cargo-details-container']);
				unset($views['cargo']['cargo-details']);
				unset($views['operation-type']);
				if($id_product == 12)
				{
					unset($views['cargo']['cargo-details-forklift']);
				}
				$views['attributes'] = [
					'mirror-address' => 0,
					'show-route' => 0,
					'show-origin' => 1,
					'show-destination' => 0,
					'show-waypoints' => 0,
					'show-containers' => 0
				];
			break;

			case 13:	// Servicio Almacenaje
				unset($views['address']['origin-address']);
				unset($views['address']['destination-address']);
				unset($views['cargo']['cargo-details']);
				unset($views['cargo']['cargo-moving']);
				unset($views['cargo']['cargo-moving-details']);
				unset($views['cargo']['cargo-details-hazard']);
				unset($views['cargo']['cargo-details-container']);
				unset($views['cargo']['cargo-specials']);
				unset($views['address']['waypoints-address']);
				unset($views['cargo']['cargo-details-forklift']);
				unset($views['operation-type']);
				$views['attributes'] = [
					'mirror-address' => 0,
					'show-route' => 0,
					'show-origin' => 0,
					'show-destination' => 0,
					'show-waypoints' => 0,
					'show-containers' => 0
				];
			break;

			default:
				# code...
			break;
		}
		if($isResume === FALSE AND isset($product_attributes))
		{
			$views['attributes'][$product_attributes] = 1;
			$views['attributeTitle'] = $this->lang->line('product-attribute')[$product_attributes]['title'];
		}
		
		$replace = $isResume === FALSE ? [$this->init->activeLang, 'requirements'] : [$this->init->activeLang, 'requirements/resume'];
		if($isResume === FALSE)
		{
			foreach ($views as $key => $v)
			{
				$result[$key] = [
					'views' => str_replace(['%lang%', '%dir%'], $replace, $v),
					'tabTitle' => isset($texts[$key]) ? $texts[$key] : '',
					'tabId' => 'reqTab-'.$key,
					'tabIcon' => isset($icons[$key]) ? $icons[$key] : '',
				];
			}
		}
		else
		{
			foreach ($views as $key => $v)
			{
				$result[$key] = [
					'views' => str_replace(['%lang%', '%dir%'], $replace, $v),
				];
			}
		}
		return $result;
	}
}