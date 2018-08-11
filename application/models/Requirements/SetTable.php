<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE GENERACION DE DATOS BOOTSTRAP TABLE
|--------------------------------------------------------------------------
| 
|
*/

class SetTable extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function set($data, $columns)
	{
		$this->load->model('Quotations/getQuotations');
		$user = $this->init->activeUser;
		$result = [];

		for($k=0; $k < count($data); $k++)
		{
			foreach($columns as $c)
			{
				$index = $c['field'];
				$d = isset($data[$k]->$index) ? $data[$k]->$index : NULL;
				$numQuots = $this->getQuotations->numByRequirement($data[$k]->id_requirement);
				switch ($index)
				{
					case 'requirement_expiration':
					case 'requirement_schedule':
						$dtf = str_replace(':%s', '', $user->dtf);
						$result[$k][$index] = mdate($dtf, mysql_to_unix($d));
					break;

					case 'requirement_name_formatted':
						$title = $this->lang->line('text-show-requirement');
						$result[$k][$index] = "
						<a href=\"javascript:;\" class=\"btn btn-link show-requirement\" title=\"{$title}\">
						{$data[$k]->requirement_name}
						</a>
						";
					break;

					case 'requirement_status_formatted':
						$status = $data[$k]->requirement_status;
						$statusFomatted = $this->lang->line('dtr-requirement-status')[$status];
						if($status === 'prog')
						{
							$tz = ($user->user_tz_offset - $this->config->item('dtr-diff-time-server')) * 3600;
							$reqProgDate = (mysql_to_unix($data[$k]->requirement_programation) + $tz) * 1000;
							$result[$k][$index] = "
							<div class=\"pointer bg-light text-danger btn-status show-programation p-1 rounded\">
								{$statusFomatted}
								<div class=\"d-none countdown\" data-programation=\"{$reqProgDate}\"></div>
							</div>";
						}
						else
						{
							$result[$k][$index] = $statusFomatted;
						}
					break;

					case 'product_description_formatted':
						$product = $this->getproducts->get($data[$k]->id_product);
						$result[$k][$index] = $this->lang->line('product')[$product->product_description];
					break;

					case 'requirement_buttons':
						$status = $data[$k]->requirement_status;
						$btns = [];
						switch($status)
						{
							case 'active':
								$btns[] = "<a role=\"button\" class=\"mr-4 cancel-requirement text-danger\" title=\"{$this->lang->line('text-cancel-requirement')}\"><i class=\"fas fa-minus-square fa-lg\"></i></a>";
							break;
							case 'closed':
								$btns[] = "<a role=\"button\" class=\"mr-4 cancel-requirement text-danger\" title=\"{$this->lang->line('text-cancel-requirement')}\"><i class=\"fas fa-minus-square fa-lg\"></i></a>";
							break;
							case 'nosent':
								$btns[] = "<a role=\"button\" class=\"mr-4 send-requirement text-primary\" title=\"{$this->lang->line('text-send-requirement')}\"><i class=\"fas fa-envelope fa-lg\"></i></a>";
								$btns[] = "<a role=\"button\" class=\"mr-4 delete-requirement text-danger\" title=\"{$this->lang->line('text-delete-requirement')}\"><i class=\"fas fa-trash-alt fa-lg\"></i></a>";
								$btns[] = "<a role=\"button\" class=\"mr-4 prog-requirement text-info\" title=\"{$this->lang->line('text-prog-requirement')}\"><i class=\"far fa-clock fa-lg\"></i></a>";
							break;
							case 'prog':
								$btns[] = "<a role=\"button\" class=\"mr-4 send-requirement text-primary\" title=\"{$this->lang->line('text-send-requirement')}\"><i class=\"fas fa-envelope fa-lg\"></i></a>";
								$btns[] = "<a role=\"button\" class=\"mr-4 delete-requirement text-danger\" title=\"{$this->lang->line('text-delete-requirement')}\"><i class=\"fas fa-trash-alt fa-lg\"></i></a>";
								$btns[] = "<a role=\"button\" class=\"mr-4 delete-programation text-warning\" title=\"{$this->lang->line('text-prog-delete')}\"><i class=\"fas fa-ban fa-lg\"></i></a>";
							break;
							case 'finish':
								if($data[$k]->requirement_rank_by_user == 0)
								{
									$btns[] = "<a role=\"button\" class=\"mr-4 rank-user text-primary\" title=\"{$this->lang->line('text-rank-user')}\"><i class=\"far fa-thumbs-up fa-lg\"></i></a>";
								}
							break;
						}
						if($numQuots > 0)
						{
							$this->lang->load('quotation', $this->init->activeLang);
							$quotations = $this->getQuotations->get(NULL, $data[$k]->id_requirement);
							if($status === 'closed')
							{
								$cls = 'btn-success';
							}
							elseif($status === 'active')
							{
								$cls = 'btn-primary';
							}
							elseif($status === 'finish')
							{
								$cls = 'btn-default';
							}
							else
							{
								$cls = 'btn-danger';
							}

							// Establece el boton dropdown donde se muestran las cotizaciones individuales
							$btns[] = "<div class=\"btn-group\">";
								$btns[] = "<a role=\"button\" class=\"show-related-quotations btn btn-sm {$cls}\">
									{$numQuots} {$this->lang->line('text-quotations')}
									</a>";
								$btns[] = "<a role=\"button\" class=\"dropdown-toggle btn btn-sm {$cls}\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
									<span class=\"sr-only\">Toggle Dropdown</span>
									</a>";
								$btns[] = "<div class=\"dropdown-menu\">";
								foreach ($quotations as $q)
								{
									$icon = ($q->quotation_status === 'closed' OR $q->quotation_status === 'active' OR $q->quotation_status === 'finish') ? 'fas fa-check' : 'fas fa-times';
									$btns[] = "<a class=\"dropdown-item resume-quotation\" href=\"#\" data-qid=\"{$q->id_quotation}\"><i class=\"{$icon}\"></i> {$q->quotation_code} <i>{$this->lang->line('dtr-quotation-status')[$q->quotation_status]}</i></a>";
								}
								$btns[] = "</div>";
							$btns[] = "</div>";
						}
						$result[$k][$index] = implode('', $btns);
					break;

					default:
						$result[$k][$index] = $d;
					break;
				}
			}
		}
		// $unique = array_map('unserialize', array_unique(array_map('serialize', $result)));
		return $result;
	}
}