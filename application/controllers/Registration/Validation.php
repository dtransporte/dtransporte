<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador de pagina registro de usuarios
|--------------------------------------------------------------------------
| Ubicacion: application/controllers
| 
|
*/
class Validation extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(isset($_SESSION['DTRANSPORTE-USER']))
		{
			$this->init->redirectTo();
		}

		$this->load->model('Users/addusers');
	}

	public function index($id_user, $hash)
	{
		/*
			CHEQUEA QUE EL USUARIO Y EL HASH COINCIDAN
			ELIMINA EL USUARIO DE LA TABLA dtr_user_validation
			ACTUALIZA EL CAMPO user_active A 1 DE LA TABLA dtr_users_data
			CREA LA ESTRUCTURA DE DIRECTORIOS DEL USUARIO EN LA CARPETA dtr-users
		*/
		$this->db->where('id_user', $id_user);
		$this->db->where('user_hash', $hash);
		$query = $this->db->get('dtr_user_validation');
		$view = "{$this->init->activeLang}/validation/error";
		if($query->num_rows() > 0)
		{
			$user = $query->row();
			$expiration = mysql_to_unix($user->date_expiration);

			$userData = $this->getusers->get($id_user);
			
			if(now($userData->user_timezone) < $expiration)
			{
				$this->load->model('Users/dirstruct');

				$data['user_active'] = 1;
				$this->db->where('id_user', $id_user);
				$this->db->update('dtr_users', $data);

				$this->db->where('id_user', $id_user);
				$this->db->delete('dtr_user_validation');

				$this->dirstruct->create($id_user);

				
				/*
					Inserta al usuario en la tabla dtr_payments si se trata de una empresa
				*/
				if($userData->user_role === 'assoc')
				{
					$expiration = now() + $this->config->item('dtr-assoc-freedays')*24*60*60;
					$dataPayment = [
						'id_user' => $userData->id_user,
						'payment_expiration' => mdate('%Y-%m-%d', $expiration),
						'payment_price' => $this->config->item('dtr-service-price')['min']
					];
					$this->db->insert('dtr_payments', $dataPayment);
				}

				/*$monologData = [
					'role'=>$user->user_role,
					'fullname' => $user->person_name.' '.$user->person_lastname,
					'company' => $user->company_name
				];
				$this->dmonolog->setAppInfo('monolog-validated-user', $monologData);*/

				$view = "{$this->init->activeLang}/validation/success";
			}
			else
			{
				$this->load->model('Users/deleteusers');
				$this->deleteusers->delete($id_user);
			}
		}
		$this->load->view($view);
	}
}