<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE CANCELACION DE COTIZACIONES DE EMPRESAS
|--------------------------------------------------------------------------
| 
|
*/

class CancelQuotation extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Requirements/sendRequirement');
	}

	/*
	|--------------------------------------------------------------------------
	|	Cancela una cotizacion
	|--------------------------------------------------------------------------
	|	@access public
	|	@params int
	|	@return boolean
	|--------------------------------------------------------------------------
	*/
	public function cancel($id_quotation)
	{
		/*$quot = $this->getQuotations->get($id_quotation);
		$req = $this->getRequirement->get($quot[0]->id_requirement);
		return $this->sendRequirement->send($req, 'tpl-resend-requirement') AND $this->_sendMailToUser($quot[0], $req[0]);*/
		if($this->faults->insert(NULL, $id_quotation))
		{
			// Obtiene la cotizacion
			$quot = $this->getQuotations->get($id_quotation);

			if($quot[0]->requirement_status === 'closed')
			{
				$this->db->trans_start();
					// Actualiza el estado de la cotizacion
					$data['quotation_status'] = 'cancel';
					$data['quotation_cancelation'] = mdate($this->config->item('dtr-datetime-db'), now($this->init->activeUser->user_timezone));
					$this->db->where('id_quotation', $id_quotation);
					$this->db->update('dtr_quotations', $data);

					// Actualiza el estado de la solicitud si la cotizacion esta cerrada
					$data = [];
					$data['requirement_status'] = 'active';
					$this->db->where('id_requirement', $quot[0]->id_requirement);
					$this->db->update('dtr_requirements', $data);				
				$this->db->trans_complete();

				// Envio correo con la nueva solicitud activa
				if($this->db->trans_status() == TRUE)
				{
					$req = $this->getRequirement->get($quot[0]->id_requirement);
					return $this->sendRequirement->send($req, 'tpl-resend-requirement') AND $this->_sendMailToUser($quot[0], $req[0]);
				}
			}
			else
			{
				$data['quotation_status'] = 'cancel';
				$data['quotation_cancelation'] = mdate($this->config->item('dtr-datetime-db'), now($this->init->activeUser->user_timezone));
				$this->db->where('id_quotation', $id_quotation);
				return $this->db->update('dtr_quotations', $data);
			}
			return TRUE;
		}
		return FALSE;
	}

	/*
	|--------------------------------------------------------------------------
	|	Envia mail al propietario de la solicitud notificando la cancelacion de la cotizacion
	|--------------------------------------------------------------------------
	|	@access private
	|	@params object
	|	@return boolean
	|--------------------------------------------------------------------------
	*/
	private function _sendMailToUser($quotation, $requirement)
	{
		$user = $this->getusers->get($requirement->id_user);
		$fullname = $user->user_first_name . ' ' . $user->user_last_name;

		$tpl = $this->lang->line('tpl-notice-user-cancel-quotation');
		$tpl['tplHeader'] = str_replace('%fullname%', $fullname, $tpl['tplHeader']);

		// Obtiene los datos de la empresa que cancelo la cotizacion
		$this->db->join('dtr_users', 'dtr_users.id_company = dtr_companies.id_company', 'inner');
		$this->db->where('dtr_users.id_user', $quotation->id_assoc);
		$assoc_company = $this->db->get('dtr_companies');
		$assoc_company = $assoc_company->row();

		$search = [
			'%requirement_name%',
			'%company-name%',
			'%quotation_code%',
			'%expiration-date%',
			'%base_url%'
		];
		$replace = [
			$requirement->requirement_name,
			$assoc_company->company_name,
			$quotation->quotation_code,
			mdate($user->user_dformat, mysql_to_unix($requirement->requirement_expiration)),
			base_url()
		];
		$tpl['tplContent'] = str_replace($search, $replace, $tpl['tplContent']);

		$this->mail->to = [
			'name' => $fullname,
			'email' => $user->user_name
		];
		$this->mail->subject = $tpl['subject'];
		$this->mail->message = $this->load->view('mail-tpl', $tpl, TRUE);
		return $this->mail->send();
	}
}