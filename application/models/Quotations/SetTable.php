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
		$base_url = base_url();
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
					case 'quotation_entered':
						$dtf = str_replace(':%s', '', $user->dtf);
						$result[$k][$index] = mdate($dtf, mysql_to_unix($d));
					break;

					case 'requirement_currency':
						$cur = $this->currencies->get();
						$result[$k][$index] = $cur[$data[$k]->requirement_currency]['currencycode'].' '. $cur[$data[$k]->requirement_currency]['currencyname'];
					break;

					case 'quotation_price':
						$total = 0;
						$quot = $this->db->get_where('dtr_quotation_concepts', ['id_quotation' => $data[$k]->id_quotation]);
						foreach ($quot->result() as $q)
						{
							$total += (int) $q->concept_value;
						}
						$result[$k][$index] = $total;
					break;

					case 'requirement_name_formatted':
						$title = $this->lang->line('text-show-requirement');
						$result[$k][$index] = "
						<a role=\"button\" class=\"btn btn-link show-requirement\" title=\"{$title}\">
						{$data[$k]->requirement_name}
						</a> 
						";
					break;

					case 'quotation_status_formatted':
						$status = $data[$k]->quotation_status;
						$statusFomatted = $this->lang->line('dtr-quotation-status')[$status];
						$result[$k][$index] = $statusFomatted;
					break;

					case 'product_description_formatted':
						$product = $this->getproducts->get($data[$k]->id_product);
						$result[$k][$index] = $this->lang->line('product')[$product->product_description];
					break;

					case 'assoc_ranking':
						$this->load->model('ranking');
						$rnk = $this->config->item('dtr-ranking');
						$ranking = $this->ranking->getTotal($data[$k]->id_assoc);
						$ranking = $ranking .' - '. round($ranking/$rnk['max']*100, 2).'%';
						$result[$k][$index] = $ranking;
					break;

					case 'quotation_buttons':
						$btns = [];
						$btns[] ="<div class=\"btn-group\" role=\"group\">";
						switch($data[$k]->quotation_status)
						{
							case 'active':
							case 'visit-accepted':
								$btns[] = "<a role=\"button\" class=\"mr-4 cancel-quotation text-danger\" title=\"{$this->lang->line('text-cancel-quotation')}\"><i class=\"fas fa-minus-square fa-lg\"></i></a>";
							break;
							case 'closed':
								$btns[] = "<a role=\"button\" class=\"mr-4 cancel-quotation text-danger\" title=\"{$this->lang->line('text-cancel-quotation')}\"><i class=\"fas fa-minus-square fa-lg\"></i></a>";
							break;
							case 'finish':
								if($data[$k]->requirement_rank_by_assoc == 0)
								{
									$btns[] = "<a role=\"button\" class=\"mr-4 rank-user text-primary\" title=\"{$this->lang->line('text-rank-user')}\"><i class=\"far fa-thumbs-up fa-lg\"></i></a>";
								}
							break;

							case 'nosent':
								$btns[] = "<a role=\"button\" class=\"mr-4 send-quotation text-primary\" title=\"{$this->lang->line('text-send')}\"><i class=\"fas fa-envelope fa-lg\"></i></a>";
								$btns[] = "<a role=\"button\" class=\"mr-4 delete-quotation text-danger\" title=\"{$this->lang->line('text-delete-quotation')}\"><i class=\"fas fa-trash-alt fa-lg\"></i></a>";
							break;
						}
						$btns[] = "<a role=\"button\" class=\"mr-1 resume-quotation\" title=\"{$this->lang->line('text-show-quotation')}\"><i class=\"far fa-eye fa-lg\"></i></a>";
						$btns[] = "</div>";
						$result[$k][$index] = implode('', $btns);
					break;

					case 'company_name':
						$this->db->join('dtr_users', 'dtr_users.id_user = dtr_quotations.id_assoc', 'inner');
						$this->db->join('dtr_companies', 'dtr_users.id_company = dtr_companies.id_company', 'inner');
						$this->db->where('dtr_quotations.id_quotation', $data[$k]->id_quotation);
						$quot = $this->db->get('dtr_quotations');
						$quot = $quot->row();

						$result[$k][$index] = $quot->company_name;
					break;

					case 'requirement_pending_buttons':
						$cargoDetails = $this->db->get_where('dtr_requirements_detail', ['id_requirement' => $data[$k]->id_requirement]);
						$cargoDetails = $cargoDetails->row();
						$btns = [];
						if($cargoDetails->cargo_product_type === 'visit-required')
						{
							$btns[] = "<a role=\"button\" class=\"mr-1 accept-visit\" title=\"{$this->lang->line('text-accept-visit')}\"><i class=\"far fa-thumbs-up fa-lg\"></i></a>";
						}
						else
						{
							$url = $base_url . "Quotations/Add/index/{$data[$k]->id_requirement}";
							$btns[] = "<a role=\"button\" href=\"{$url}\" class=\"mr-1 quot-requirement\" title=\"{$this->lang->line('text-quot')}\"><i class=\"fas fa-file-invoice-dollar fa-lg\"></i></a>";
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