<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Chequos varios
|--------------------------------------------------------------------------
| Ubicacion: application/controllers/Users
| 
|
*/
class Check extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		$this->load->model('Users/deleteusers');
	}

	/*
	|--------------------------------------------------------------------------
	|	Chequea que un usuario haya validado sus datos luego del registro.
	|	En caso de no haberlo hecho y la fecha sea mayor que el momento del chequeo
	|	sera eliminado
	|--------------------------------------------------------------------------
	|	@access public
	|	@params string
	|	@return void
	|--------------------------------------------------------------------------
	*/
	function validation()
	{
		if($this->input->is_ajax_request())
		{
			$this->db->join('dtr_user_settings', 'dtr_user_validation.id_user = dtr_user_settings.id_user_settings', 'inner');
			$users = $this->db->get('dtr_user_validation');
			if($users->num_rows() > 0)
			{
				foreach ($users->result() as $user)
				{
					$now = now($user->user_timezone);
					if($now > mysql_to_unix($user->date_expiration))
					{
						$this->deleteusers->delete($user->id_user);
						$this->db->where('id_user', $user->id_user);
						$this->db->delete('dtr_user_validation');
					}
				}
			}
		}
	}

	/*
	|--------------------------------------------------------------------------
	|	Chequea que un usuario haya validado su nueva contrasenia.
	|	En caso de no haberlo hecho y la fecha sea mayor que el momento del chequeo
	|	sera eliminado de la tabla y debera requerir una nueva
	|--------------------------------------------------------------------------
	|	@access public
	|	@params string
	|	@return void
	|--------------------------------------------------------------------------
	*/
	function passwordReset()
	{
		if($this->input->is_ajax_request())
		{
			$this->db->join('dtr_user_settings', 'dtr_user_reset_pwd.id_user = dtr_user_settings.id_user_settings', 'inner');
			$users = $this->db->get('dtr_user_reset_pwd');
			if($users->num_rows() > 0)
			{
				foreach ($users->result() as $user)
				{
					$now = now($user->user_timezone);
					if($now > mysql_to_unix($user->date_expiration))
					{
						$this->db->where('id_user', $user->id_user);
						$this->db->delete('dtr_user_reset_pwd');
					}
				}
			}
		}
	}

	/*
	|--------------------------------------------------------------------------
	|	Envio de recordatorio de pago.
	|--------------------------------------------------------------------------
	|	@access public
	|	@params string
	|	@return void
	|--------------------------------------------------------------------------
	*/
	public function paymentReminder()
	{
		if($this->input->is_ajax_request())
		{
			$reminders = $this->config->item('dtr-payment-reminder');
			$pendingPay = $this->getusers->getPendingPayments();

			/*
				Chequea si el primer envio @payment_reminder_sent esta a cero
				Chequea que la fecha actual menos la fecha de pago sea menor a @reminders[0]
			*/
			if($pendingPay->num_rows() > 0)
			{
				foreach($pendingPay->result() as $pending)
				{
					$user = $this->getusers->get($pending->id_user);
					$dif = -now($user->user_timezone) + mysql_to_unix($pending->payment_expiration.' 00:00:00');
					if($dif < $reminders)
					{
						if($this->_sendReminder($user, $pending))
						{
							$this->db->where('id_user', $user->id_user);
							$data['payment_reminder_sent'] = 1;
							$this->db->update('dtr_payments', $data);
						}
					}
				}
			}
		}
	}

	private function _sendReminder($user, $payment)
	{
		$this->lang->load('mail-tpl', $this->init->activeLang);
		$this->load->model('mail');

		$tpl = $this->lang->line('tpl-reminder-payment');

		$this->mail->from = [
			'email' => $this->config->item('dtr-default-email'), 
			'name' => 'dTransporte'
		];
		$this->mail->to = [$user->user_name];

		$this->mail->subject = $tpl['subject'];

		$date_expiration = mdate($user->user_dformat, mysql_to_unix($payment->payment_expiration.' 00:00:00'));
		$search = ['%payment-day%', '%payment-amount%'];
		$replace = [$date_expiration, $payment->payment_price];

		$tpl['tplContent'] = str_replace($search, $replace, $tpl['tplContent']);
		$this->mail->message = $this->load->view('mail-tpl', $tpl, TRUE);

		return $this->mail->send();
	}

	/*
	|--------------------------------------------------------------------------
	|	Bloqueo de usuario por falta de pago.
	|--------------------------------------------------------------------------
	|	@access public
	|	@params string
	|	@return void
	|--------------------------------------------------------------------------
	*/
	public function blockUserDuePay()
	{
		if($this->input->is_ajax_request())
		{
			$duePayment = $this->getusers->getDuePayments();

			if($duePayment->num_rows() > 0)
			{
				foreach($duePayment->result() as $due)
				{
					$user = $this->getusers->get($due->id_user);
					$date_expiration = mysql_to_unix($due->payment_expiration) +24*3600;
					$now = now($user->user_timezone);
					// Actualiza la tabla de usuarios y pagos
					if($date_expiration < $now)
					{
						$this->db->trans_start();
							$this->db->where('id_user', $user->id_user);
							$data['user_active'] = 0;
							$this->db->update('dtr_users', $data);

							$this->db->where('id_user', $user->id_user);
							$dataPayment['payment_notes'] = $this->lang->line('text-user-block-by-due');
							$this->db->update('dtr_payments', $dataPayment);
						$this->db->trans_complete();
					}
				}
			}
		}
	}
}