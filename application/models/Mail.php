<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Modelo de gestion de envio de correos
|--------------------------------------------------------------------------
| Ubicacion: application/models
*/

class Mail extends CI_Model
{
	public $from = NULL;
	public $to = NULL;
	public $cc = NULL;
	public $bcc = NULL;
	public $subject = '';
	public $message = '';
	public $errors = NULL;

	function __construct()
	{
		parent::__construct();
		$this->load->config('config.mail');
		$this->load->library('email');
	}

	private function _set()
	{
		if(!isset($this->from))
		{
			$this->from['email'] = $this->config->item('dtr-default-email');
			$this->from['name'] = 'dTransporte';
		}
		$this->email->from($this->from['email'], $this->from['name']);

		if(isset($this->to))
		{
            $this->email->to($this->to);
		}

		if(isset($this->cc))
		{
			$this->email->cc($this->cc);
		}

		if(isset($this->bcc))
		{
			$this->email->bcc($this->bcc);
		}

		$this->email->subject($this->subject);

		$this->email->message($this->message);
	}

	public function send()
	{
		$this->_set();
		if($this->email->send(FALSE))
		{
			return TRUE;
		}
		$this->errors = $this->email->print_debugger();
		return FALSE;
	}

}
