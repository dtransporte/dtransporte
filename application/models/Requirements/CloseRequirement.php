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

class CloseRequirement extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	/*
	|--------------------------------------------------------------------------
	|	Cierra una solicitud
	|--------------------------------------------------------------------------
	|	@access public
	|	@params array
	|	@return bool
	|--------------------------------------------------------------------------
	*/
	public function close($data)
	{
		$this->db->trans_start();
			$this->db->where('id_requirement', $data['id_requirement']);
			$d['requirement_status'] = 'closed';
			$this->db->update('dtr_requirements', $d);

			$d = [];
			$this->db->where('id_quotation', $data['id_quotation']);
			$d['quotation_status'] = 'closed';
			$this->db->update('dtr_quotations', $d);
		$this->db->trans_complete();

		if($this->db->trans_status())
		{
			return $this->_sendMail($data);
		}
		return FALSE;
	}

	private function _sendMail($data)
	{
		$this->load->model('mail');
		$this->load->model('Quotations/getQuotations');

		$requirement = $this->getQuotations->get(NULL, $data['id_requirement']);
		$requirement = $requirement[0];

		$id_assoc = $requirement->id_assoc;
		$id_user = $requirement->id_user;

		// Obtengo datos de los usuarios
		$assoc = $this->getusers->get($id_assoc);
		$user = $this->getusers->get($id_user);

		// Envia correo a usuario
		$this->lang->load('mail-tpl', $user->user_lang);
		$tpl = $this->lang->line('tpl-send-close-requirement-user');
		$user_fulname = $user->user_first_name.' '.$user->user_last_name;
		$assoc_fulname = $assoc->user_first_name.' '.$assoc->user_last_name;

		// Header
		$search = [
			'%fullname%',
			'%requirement_name%'
		];
		$replace = [
			$user_fulname,
			$requirement->requirement_name
		];
		$tpl['tplHeader'] = str_replace($search, $replace, $tpl['tplHeader']);

		// Content
		$search = [
			'%quotation_code%',
			'%company-name%',
			'%company-phone%',
			'%person-name%',
			'%base_url%'
		];
		$replace = [
			$requirement->quotation_code,
			$assoc->company_name,
			$assoc->phone_number,
			$assoc_fulname,
			base_url()
		];
		$tpl['tplContent'] = str_replace($search, $replace, $tpl['tplContent']);

		$this->mail->to = [
			'name' => $user_fulname,
			'email' => $user->user_name
		];
		$this->mail->subject = $tpl['subject'];

		$this->mail->message = $this->load->view('mail-tpl', $tpl, TRUE);

		if($this->mail->send())
		{
			// Envia correo a empresa
			$this->lang->load('mail-tpl', $assoc->user_lang);
			$tpl = $this->lang->line('tpl-send-close-requirement-assoc');

			// Header
			$search = [
				'%fullname%',
				'%requirement_name%'
			];
			$replace = [
				$assoc_fulname,
				$requirement->requirement_name
			];
			$tpl['tplHeader'] = str_replace($search, $replace, $tpl['tplHeader']);

			// Content
			$search = [
				'%quotation_code%',
				'%company-name%',
				'%company-phone%',
				'%person-name%',
				'%base_url%'
			];
			$replace = [
				$requirement->quotation_code,
				$user->company_name,
				$user->phone_number,
				$user_fulname,
				base_url()
			];
			$tpl['tplContent'] = str_replace($search, $replace, $tpl['tplContent']);

			$this->mail->to = [
				'name' => $assoc_fulname,
				'email' => $assoc->user_name
			];
			$this->mail->subject = $tpl['subject'];

			$this->mail->message = $this->load->view('mail-tpl', $tpl, TRUE);

			return $this->mail->send();
		}
	}
}