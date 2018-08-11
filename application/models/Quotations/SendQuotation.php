<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE OBTENCION DE COTIZACIONES DE EMPRESAS
|--------------------------------------------------------------------------
| 
|
*/

class SendQuotation extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('mail');
		$this->load->model('Products/getproducts');
	}

	public function send($id_quotation)
	{
		$this->db->join('dtr_quotations', 'dtr_quotations.id_quotation = dtr_quotations_requirements.id_quotation', 'inner');
		$this->db->join('dtr_requirements', 'dtr_requirements.id_requirement = dtr_quotations_requirements.id_requirement', 'inner');
		$this->db->join('dtr_users', 'dtr_requirements.id_user = dtr_users.id_user', 'inner');
		$this->db->join('dtr_user_settings', 'dtr_user_settings.id_user_settings = dtr_users.id_user', 'inner');

		$this->db->where('dtr_quotations_requirements.id_quotation', $id_quotation);
		$this->db->where('dtr_users.user_active', 1);

		$quotation = $this->db->get('dtr_quotations_requirements');
		$q= $quotation->row();

		$product = $this->getproducts->get($q->id_product);
		
		$fullname = $q->user_first_name . ' ' . $q->user_last_name;
		$this->mail->to = [
			'name' => $fullname,
			'email' => $q->user_name
		];

		$this->lang->load('mail-tpl', $q->user_lang);
		$this->lang->load('product', $q->user_lang);

		$tpl = $this->lang->line('tpl-send-quotation');
		$this->mail->subject = $tpl['subject'];

		$search = [
			'%fullname%',
			'%requirement_name%'
		];
		$replace = [
			$fullname,
			$q->requirement_name
		];
		$tpl['tplHeader'] = str_replace($search, $replace, $tpl['tplHeader']);

		$this->db->join('dtr_users', 'dtr_users.id_company = dtr_companies.id_company', 'inner');
		$this->db->where('dtr_users.id_user', $this->init->activeUser->id_user);
		$company = $this->db->get('dtr_companies');
		$c = $company->row();

		$search = [
			'%product-description%',
			'%company-name%',
			'%base_url%'
		];
		$replace = [
			$this->lang->line('product')[$product->product_description],
			$c->company_name,
			base_url()
		];
		$tpl['tplContent'] = str_replace($search, $replace, $tpl['tplContent']);

		$this->mail->message = $this->load->view('mail-tpl', $tpl, TRUE);

		return $this->mail->send();
	}
}