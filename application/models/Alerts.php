<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE OBTENCION DE ALERTAS USUARIOS
|--------------------------------------------------------------------------
| 
|
*/

class Alerts extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function set()
	{
		$alert = [];
		if($this->init->activeUser->user_role === 'user')
		{
			$alerts = $this->getRequirement->numByStatus($this->init->activeUser->id_user, ['active', 'nosent', 'prog']);
			$totalAlerts = count($alerts);
			if($totalAlerts > 0)
			{
				foreach ($alerts as $key => $value)
				{
					$search = ['%num%', '%status%'];
					$replace = [$value, $this->lang->line('dtr-requirement-status')[$key]];
					$alert[] = [
						'name' => str_replace($search, $replace, $this->lang->line('text-alert-requirement-status')),
						'icon' => 'fas fa-exclamation-circle',
						'url' => '#requirements-list'
					];
				}
			}
		}
		if($this->init->activeUser->user_role === 'assoc')
		{
			$alerts = $this->getQuotations->getRequirementNoQuoted($this->init->activeUser->id_user);
			$totalAlerts = count($alerts);
			if($totalAlerts > 0)
			{
				$alert[] = [
					'name' => str_replace('%num%', $totalAlerts, $this->lang->line('text-requirement-pending-quot')),
					'icon' => 'fas fa-exclamation-circle',
					'url' => '#'
				];
			}
		}
		$alerts = $this->getQuotations->countRequirementsNoRanked();
		if($alerts > 0)
		{
			$alert[] = [
					'name' => str_replace('%num%', $alerts, $this->lang->line('text-you-have-requirements-pending-rank')),
					'icon' => 'fas fa-exclamation-circle',
					'url' => '#'
				];
		}
		return $alert;
	}
}