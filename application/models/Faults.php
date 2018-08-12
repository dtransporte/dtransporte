<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|---------------------------------------------------------------------------------------
| MANEJA LAS PENALIZACIONES QUE SERAN ADJUDICADAS A LOS USUARIOS POR CONCEPTO DE
|  CANCELACION
|---------------------------------------------------------------------------------------
| 
|
*/

class Faults extends CI_Model
{
	private $faults = NULL;
	function __construct()
	{
		parent::__construct();
		$this->config->load('config.ranking');
		$this->faults = $this->init->activeUser->user_role === 'user' ? $this->config->item('dtr-user-faults') : $this->config->item('dtr-assoc-faults');
	}

	/*
	|----------------------------------------------------------------------------------
	|	Establece la penalizacion.
	|		Solo se calcula la penalizacion para el rol user. 
	|		El rol assoc lleva la penalizacion maxima
	|----------------------------------------------------------------------------------
	|	@access public
	|	@params int, int
	|	@return int
	|----------------------------------------------------------------------------------
	*/
	public function set($id_requirement=NULL, $id_quotation=NULL)
	{
		if(! $this->_applyFault())
		{
			return 0;
		}
		if(isset($id_requirement))
		{
			return $this->_calculate($id_requirement);
		}
		elseif(isset($id_quotation))
		{
			return $this->faults['max'];
		}
	}

	/*
	|----------------------------------------------------------------------------------
	|	Obtiene el total de las penalizaciones por usuario
	|----------------------------------------------------------------------------------
	|	@access public
	|	@params int
	|	@return int
	|----------------------------------------------------------------------------------
	*/
	public function getTotal($id_user=NULL)
	{
		$total = 0;
		if(isset($id_user))
		{
			$this->db->where('id_user', $id_user);
		}
		$result = $this->db->get('dtr_faults');
		if($result->num_rows() > 0)
		{
			foreach($result->result() as $fault)
			{
				$total += $fault->fault;
			}
		}
		return $total;
	}

	/*
	|----------------------------------------------------------------------------------
	|	Chequea si es aplicable la penalizacion.
	|----------------------------------------------------------------------------------
	|	@access private
	|	@params void
	|	@return boolean
	|----------------------------------------------------------------------------------
	*/
	private function _applyFault()
	{
		$maxDates = $this->config->item('dtr-max-no-faults');
		$limitDate = mysql_to_unix($this->init->activeUser->user_entered) + $maxDates;
		$now = now($this->init->activeUser->user_timezone);

		return $now < $limitDate ? FALSE : TRUE;
	}

	private function _calculate($id_requirement)
	{
		$req = $this->getRequirement->get($id_requirement);
		if($req[0]->requirement_status === 'closed')
		{
			return $this->faults['max'];
		}
		$this->db->join('dtr_quotations_requirements', 'dtr_quotations_requirements.id_requirement = dtr_requirements.id_requirement', 'inner');
		$this->db->join('dtr_quotations', 'dtr_quotations_requirements.id_quotation = dtr_quotations.id_quotation', 'inner');
		$this->db->where('dtr_requirements.id_requirement', $id_requirement);
		$this->db->where('dtr_quotations.quotation_status !=', 'cancel');
		$total = $this->db->count_all_results('dtr_requirements');
		if($total == 0)
		{
			return $this->faults['min'];
		}
		return $this->faults['min'] + $this->faults['step'] * $total;
	}

	/*
	|----------------------------------------------------------------------------------
	|	Inserta la penalizacion.
	|		Solo se calcula la penalizacion para el rol user. 
	|		El rol assoc lleva la penalizacion maxima.
	|	IMPORTANTE: EL DISPARADOR addCancelExpiration ASOCIADO A LA TABLA dtr_faults
	|					ACTUALIZA LAS TABLAS dtr_requirements Y dtr_quotations CON EL 
	|					NUEVO ESTADO
	|----------------------------------------------------------------------------------
	|	@access public
	|	@params int, int
	|	@return int
	|----------------------------------------------------------------------------------
	*/
	public function insert($id_requirement=NULL, $id_quotation=NULL)
	{
		$data['id_user'] = $this->init->activeUser->id_user;
		if(isset($id_requirement))
		{
			$data['fault'] = $this->_applyFault() == TRUE ? $this->_calculate($id_requirement) : 0;
			$data['id_requirement'] = $id_requirement;
		}
		elseif(isset($id_quotation))
		{
			$data['fault'] = $this->_applyFault() == TRUE ? $this->faults['max'] : 0;
			$data['id_quotation'] = $id_quotation;
		}
		$this->db->trans_start();
			$this->db->insert('dtr_faults', $data);
		$this->db->trans_complete();

		if($this->db->trans_status() === TRUE)
		{
			return $this->_sendMail($id_requirement, $id_quotation);
		}
	}

	private function _sendMail($id_requirement=NULL, $id_quotation=NULL)
	{
		$this->load->model('mail');
		$base_url = base_url();
		// Envia el correo a todos las empresas asociadas que coincidan con el producto y pais
		if(isset($id_requirement))
		{
			$this->load->model('Requirements/sendRequirement');
			$this->load->model('Requirements/getRequirement');
			$requirement = $this->getRequirement->get($id_requirement);
			$bcc = $this->sendRequirement->setRecipients($requirement);
			if(count($bcc) > 0)
			{
				foreach ($bcc as $to)
				{
					$user = $this->getusers->get(NULL, $to['email']);
					$dtf = $user->user_dformat.' '.$user->user_tformat;
					$dtf = str_replace(':%s', '', $dtf);

					$lang = is_array($this->lang->load('mail-tpl', $user->user_lang, TRUE)) ? $user->user_lang : $this->init->activeLang;
					$this->lang->load('mail-tpl', $lang);

					$tpl = $this->lang->line('tpl-cancel-requirement');
					$this->mail->subject = $tpl['subject'];
					$tpl['tplHeader'] = str_replace(['%fullname%', '%requirement_name%'], [$to['name'], $requirement[0]->requirement_name], $tpl['tplHeader']);
					$search = [
						'%requirement_name%',
						'%base_url%'
					];
					$replace = [
						$requirement[0]->requirement_name,
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
		else
		{
			$this->db->join('dtr_quotations', 'dtr_quotations.id_quotation = dtr_quotations_requirements.id_quotation', 'inner');
			$this->db->join('dtr_requirements', 'dtr_requirements.id_requirement = dtr_quotations_requirements.id_requirement', 'inner');
			$this->db->join('dtr_users', 'dtr_requirements.id_user = dtr_users.id_user', 'inner');

			$this->db->where('dtr_quotations_requirements.id_quotation', $id_quotation);

			$requirement = $this->db->get('dtr_quotations_requirements');
			$requirement = $requirement->row();

			$to['name'] = $requirement->user_first_name . ' ' . $requirement->user_last_name;
			$to['email'] = $requirement->user_name;

			$user = $this->getusers->get(NULL, $to['email']);
			$lang = is_array($this->lang->load('mail-tpl', $user->user_lang, TRUE)) ? $user->user_lang : $this->init->activeLang;
					$this->lang->load('mail-tpl', $lang);

			$tpl = $this->lang->line('tpl-cancel-quotation');
			
			$this->mail->subject = $tpl['subject'];

			$tpl['tplHeader'] = str_replace(['%fullname%', '%requirement_name%', '%quotation_code%'], [$to['name'], $requirement->requirement_name, $requirement->quotation_code], $tpl['tplHeader']);

			$this->db->join('dtr_companies', 'dtr_companies.id_company = dtr_users.id_company', 'inner');
			$this->db->where('dtr_users.id_user', $this->init->activeUser->id_user);
			$company = $this->db->get('dtr_users');
			$company = $company->row();
			$search = [
				'%company-name%',
				'%base_url%'
			];
			$replace = [
				$company->company_name,
				$base_url
			];
			$tpl['tplContent'] = str_replace($search, $replace, $tpl['tplContent']);

			$message = $this->load->view('mail-tpl', $tpl, TRUE);

			$this->mail->message = $message;

			$this->mail->to = $to;

			return $this->mail->send();
		}
	}
}