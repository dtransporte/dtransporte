<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE OBTENCION DE USUARIOS
|--------------------------------------------------------------------------
| Obtiene las direcciones de usuarios
| 
|
*/

class SendRequirement extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->lang->load('mail-tpl', $this->init->activeLang);
		$this->lang->load('product', $this->init->activeLang);
		$this->load->model('mail');
		$this->load->model('countries');
		$this->load->model('Products/getproducts');
	}

	/*
	|--------------------------------------------------------------------------
	|	Envia un correo a todos las empresas que coincidan con el producto solicitado
	|	y con con las direcciones de origen y destino de la solicitud
	|--------------------------------------------------------------------------
	|	@access public
	|	@params object
	|	@return bool
	|--------------------------------------------------------------------------
	*/
	function send($requirement, $idTpl='tpl-send-requirement')
	{
		$bcc = $this->setRecipients($requirement);
		if(count($bcc) > 0)
		{
			$base_url = base_url();
			foreach ($bcc as $to)
			{
				$user = $this->getusers->get(NULL, $to['email']);
				$dtf = $user->user_dformat.' '.$user->user_tformat;
				$dtf = str_replace(':%s', '', $dtf);

				$product = $this->getproducts->get($requirement[0]->id_product);

				$tpl = $this->lang->line($idTpl);
				$this->mail->subject = $tpl['subject'];
				$tpl['tplHeader'] = str_replace('%fullname%', $to['name'], $tpl['tplHeader']);
				$search = [
					'%product-description%',
					'%product-category%',
					'%expiration-date%',
					'%base_url%'
				];
				$replace = [
					$this->lang->line('product')[$product->product_description],
					$this->lang->line('category')[$product->category_name],
					mdate($dtf, mysql_to_unix($requirement[0]->requirement_expiration)),
					$base_url
				];
				$tpl['tplContent'] = str_replace($search, $replace, $tpl['tplContent']);

				$message = $this->load->view('mail-tpl', $tpl, TRUE);

				$this->mail->message = $message;

				$this->mail->bcc = $to;

				if(!$this->mail->send())
				{
					return FALSE;
				}
			}
			return TRUE;
		}
		return TRUE;
	}

	/*
	|--------------------------------------------------------------------------
	|	Establece las empresas a las que sera enviado el correo
	|--------------------------------------------------------------------------
	|	@access public
	|	@params object
	|	@return array
	|--------------------------------------------------------------------------
	*/
	public function setRecipients($requirement)
	{
		$recipients = [];
		$countries = $this->_setCountries($requirement);

		// Obtiene todas las empresas que corresponden al pais de la solicitud
		$this->db->join('dtr_address', 'dtr_users.id_address = dtr_address.id_address', 'join');
		$this->db->join('dtr_products_user', 'dtr_users.id_user = dtr_products_user.id_user', 'join');
		$this->db->where('dtr_users.user_role', 'assoc');
		$this->db->where('dtr_users.user_active', 1);
		$assocs = $this->db->get('dtr_users');
		foreach ($assocs->result() as $assoc)
		{
			if(in_array($assoc->country, $countries) AND $requirement[0]->id_product == $assoc->id_product)
			{
				$recipients[] = [
					'name'=>$assoc->user_first_name.' '. $assoc->user_last_name,
					'email'=>$assoc->user_name
				];
			}
		}

		// Obtiene todas las empresas que corresponden al pais de la solicitud por bloque economico
		$assocCompany = $this->db->get('dtr_products_user');
		foreach ($assocCompany->result() as $assoc)
		{
			$blocks = json_decode($assoc->receive_reqs_from);
			foreach ($blocks as $b)
			{
				if($b != 'only-my-country')
				{
					$country = $this->countries->getCountryByBlock($b);
					foreach ($country as $c)
					{					
						if(in_array($c->iso, $countries) AND $requirement[0]->id_product == $assoc->id_product)
						{
							$user = $this->db->get_where('dtr_users', ['id_user' => $assoc->id_user]);
							$user = $user->row();
							if(!in_array(['name'=>$user->user_first_name.' '. $user->user_last_name, 'email'=>$user->user_name], $recipients))
							{
								$recipients[] = [
									'name'=>$user->user_first_name.' '. $user->user_last_name,
									'email'=>$user->user_name
								];
							}
						}
					}
				}
			}
		}
		return $recipients;
	}

	private function _setCountries($requirement)
	{
		$countries = [];
		foreach ($requirement as $req)
		{
			$countries[] = $req->country;
		}
		return array_unique($countries);
	}
}

/*
[
	{
	"id_requirement":"4",
	"id_user":"4",
	"id_product":"16",
	"requirement_name":"Vinos Brasil",
	"requirement_status":"prog",
	"requirement_qrcode":"y4lveXsAN6oGTtzcEW5hZ0q2JUwfP9",
	"requirement_entered":"2018-07-29 04:01:10",
	"requirement_expiration":"2018-08-03 14:00:00",
	"requirement_schedule":"2018-08-04 06:00:00",
	"requirement_programation":"2018-07-30 02:00:00",
	"requirement_closed":null,
	"requirement_cancelation":null,
	"requirement_currency":"dolar",
	"requirement_pay_terms":"Cheque Santander a 7 dias",
	"requirement_rank_by_user":"0",
	"requirement_rank_by_assoc":"0",
	"requirement_notes":"Material fragil. Se requiere idoneidad",

	"cargo_id":"4",
	"cargo_units_qty":"1",
	"cargo_weight":"28000",
	"cargo_m2":"1",
	"cargo_volume":"30",
	"cargo_height":"0",
	"cargo_frozen_chain":"0",
	"cargo_num_packs":"1",
	"cargo_product_type":"fcl",
	"cargo_forklift_type":null,
	"cargo_forklift_driver":"0",
	"cargo_additionals":"[{\"item\":\"forklift\",\"name\":\"Autoelevador\",\"quantity\":\"1\",\"place\":\"origin\",\"notes\":\"\"}]",
	"cargo_containers":null,
	"cargo_moving_type":null,
	"cargo_moving_detail":null,
	"cargo_moving_require_visit":"no-visit-required",
	"cargo_hazard_detail":null,
	"cargo_notes":"Mercaderia paletizada",

	"id_operationtype":"2",
	"operation_type":"expo",
	"operation_incoterm":"exw",
	"operation_currency":"dolar",
	"operation_value":"35000",
	"custom_clearance":"0",
	"require_insurance":"0",
	"require_co":"0",
	"inspection_required":"origin",
	"inspection_company":"SGS",
	"inspection_notes":"",
	"operation_ncm_codes":"[{\"code\":\"2204210010\",\"value\":\"35000\",\"description\":\"Vinos finso de mesa\"}]",

	"id":"7",
	"id_address":"4",
	"address_type":"origin",
	"address_notes":"",
	"country":"UY",
	"locality":"Montevideo",
	"postal_code":"11700",
	"address":"Av. Agraciada 3428, 11700 Montevideo, Uruguay",
	"latitude":"-34.8688068",
	"longitude":"-56.20533390000003",
	"place_id":"Ei1Bdi4gQWdyYWNpYWRhIDM0MjgsIDExNzAwIE1vbnRldmlkZW8sIFVydWd1YXkiMRIvChQKEgm9jkkdVdWhlRGv7Ofz-6j5LxDkGioUChIJP28Zlv9_n5UR4rJWLx04LcM"
	},

	{"id_requirement":"4","id_user":"4","id_product":"16","requirement_name":"Vinos Brasil","requirement_status":"prog","requirement_qrcode":"y4lveXsAN6oGTtzcEW5hZ0q2JUwfP9","requirement_entered":"2018-07-29 04:01:10","requirement_expiration":"2018-08-03 14:00:00","requirement_schedule":"2018-08-04 06:00:00","requirement_programation":"2018-07-30 02:00:00","requirement_closed":null,"requirement_cancelation":null,"requirement_currency":"dolar","requirement_pay_terms":"Cheque Santander a 7 dias","requirement_rank_by_user":"0","requirement_rank_by_assoc":"0","requirement_notes":"Material fragil. Se requiere idoneidad","cargo_id":"4","cargo_units_qty":"1","cargo_weight":"28000","cargo_m2":"1","cargo_volume":"30","cargo_height":"0","cargo_frozen_chain":"0","cargo_num_packs":"1","cargo_product_type":"fcl","cargo_forklift_type":null,"cargo_forklift_driver":"0","cargo_additionals":"[{\"item\":\"forklift\",\"name\":\"Autoelevador\",\"quantity\":\"1\",\"place\":\"origin\",\"notes\":\"\"}]","cargo_containers":null,"cargo_moving_type":null,"cargo_moving_detail":null,"cargo_moving_require_visit":"no-visit-required","cargo_hazard_detail":null,"cargo_notes":"Mercaderia paletizada","id_operationtype":"2","operation_type":"expo","operation_incoterm":"exw","operation_currency":"dolar","operation_value":"35000","custom_clearance":"0","require_insurance":"0","require_co":"0","inspection_required":"origin","inspection_company":"SGS","inspection_notes":"","operation_ncm_codes":"[{\"code\":\"2204210010\",\"value\":\"35000\",\"description\":\"Vinos finso de mesa\"}]","id":"8","id_address":"10","address_type":"destination","address_notes":null,"country":"BR","locality":"","postal_code":"01311-200","address":"Av. Paulista, 1209 - Bela Vista, S\u00e3o Paulo - SP, 01311-200, Brasil","latitude":"-23.5640173","longitude":"-46.653691200000026","place_id":"EkNBdi4gUGF1bGlzdGEsIDEyMDkgLSBCZWxhIFZpc3RhLCBTw6NvIFBhdWxvIC0gU1AsIDAxMzExLTIwMCwgQnJhc2lsIjESLwoUChIJL1x_fchZzpQR51q58UujqfoQuQkqFAoSCRWjCtrIWc6UEWp3yfIxlJ_V"}]
*/