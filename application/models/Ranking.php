<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE GESTION RANKING DE USUARIOS
|--------------------------------------------------------------------------
| 
|
*/
class Ranking extends CI_Model
{
	public $concepts = [];
	private $defRanking = NULL;

	function __construct()
	{
		parent::__construct();
		$this->load->model('faults');
		$this->config->load('config.ranking');
		$this->defRanking = $this->config->item('dtr-ranking');
	}

	public function get($id_user)
	{
		$result = [];
		$this->db->where('dtr_ranking.id_user', $id_user);
		$this->db->order_by('dtr_ranking.rank_date');
		$this->db->distinct();
		$this->db->select('dtr_ranking.ranked_by, dtr_ranking.id_ranking');
		$data = $this->db->get('dtr_ranking');
		//$result = $data->result_array();
		foreach ($data->result_array() as $value)
		{
			$ranked_by = $this->getusers->get($value['ranked_by']);
			$ranked_by_formatted = isset($ranked_by->company_name) ? $ranked_by->company_name : $ranked_by->user_first_name.' '.$ranked_by->user_last_name;
			$result[] = [
				'id_user' => $id_user,
				'id_ranking' => $value['id_ranking'],
				'ranked_by' =>  $value['ranked_by'],
				'ranked_by_formatted' => $ranked_by_formatted,
				'total_ranking' => round($this->getTotal($this->init->activeUser->id_user, $value['id_ranking']), 2)
			];
		}
		return $result;
	}

	public function getDetail($id_ranking, $ranked_by)
	{
		$this->db->join('dtr_ranking', 'dtr_ranking.id_ranking = dtr_ranking_concepts.id_ranking', 'inner');
		$this->db->where('dtr_ranking.id_ranking', $id_ranking);
		$this->db->where('dtr_ranking.ranked_by', $ranked_by);
		$this->db->where('dtr_ranking.id_user', $this->init->activeUser->id_user);

		$detail = $this->db->get('dtr_ranking_concepts');

		foreach ($detail->result_array() as $key => $value)
		{
			$result[][$key] = $value;
			
		}
		return $result[0];
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene el ranking global de un usuario
	|--------------------------------------------------------------------------
	|	@access public
	|	@params int, string
	|	@return int
	|--------------------------------------------------------------------------
	*/
	public function getTotal($id_user, $id_ranking=NULL)
	{
		$total = 0;
		$this->db->join('dtr_ranking_concepts', 'dtr_ranking_concepts.id_ranking = dtr_ranking.id_ranking', 'inner');

		$this->db->where('dtr_ranking.id_user', $id_user);
		if(isset($id_ranking))
		{
			$this->db->where('dtr_ranking.id_ranking', $id_ranking);
		}

		$result = $this->db->get('dtr_ranking');

		if($result->num_rows() > 0)
		{
			foreach ($result->result() as $v)
			{
				$total += $v->ranking_value;
			}
			$total /= $result->num_rows();
			$total -= $this->faults->getTotal($id_user) * $this->defRanking['max'];
		}
		return $total;
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene los conceptos de ranking un usuario
	|--------------------------------------------------------------------------
	|	@access public
	|	@params int,
	|	@return array
	|--------------------------------------------------------------------------
	*/
	public function getConcepts($id_user=NULL)
	{
		if(isset($id_user))
		{
			$user = $this->getusers->get($id_user);
			$role = $user->user_role;
		}
		else
		{
			$role = $this->init->activeUser->user_role;
		}
		return $role === 'user' ? $this->config->item('dtr-assoc-ranking-concepts') : $this->config->item('dtr-user-ranking-concepts');
	}

	/*
	|--------------------------------------------------------------------------
	|	Agrega un nuevo registro
	|--------------------------------------------------------------------------
	|	@access public
	|	@params array
	|	@return boolean
	|--------------------------------------------------------------------------
	*/
	public function insert($data)
	{
		$result['id_requirement'] = $data['id_requirement'];
		$result['ranked_by'] = $this->init->activeUser->id_user;
		$result['id_user'] = $this->_getUser($data['id_requirement']);
		$result['rank_date'] = mdate($this->config->item('dtr-datetime-db'), now($this->init->activeUser->user_timezone));
		$result['rank_post'] = $data['rank_post'];
		
		$this->db->trans_start();
			// Inserta los datos en dtr_ranking
			$this->db->insert('dtr_ranking', $result);
			$lastId = $this->db->insert_id();

			// Inserta los datos en dtr_ranking_concepts
			$concepts = $this->_setConcepts($data, $lastId);
			$this->db->insert_batch('dtr_ranking_concepts', $concepts);

			// Actualiza la tabla dtr_requirements
			$this->db->where('dtr_requirements.id_requirement', $data['id_requirement']);
			$field = $this->init->activeUser->user_role === 'user' ? 'requirement_rank_by_user' : 'requirement_rank_by_assoc';
			$d[$field] = 1;
			$this->db->update('dtr_requirements', $d);

		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	/*
	|--------------------------------------------------------------------------
	|	Establece los datos a ser insertados
	|--------------------------------------------------------------------------
	|	@access private
	|	@params array
	|	@return array
	|--------------------------------------------------------------------------
	*/
	private function _setConcepts($data, $id_ranking)
	{
		$concepts = $this->getConcepts();
		foreach ($data as $key => $c)
		{
			if(array_key_exists($key, $concepts))
			{	
				$result[] = [
					'id_ranking' => $id_ranking,
					'ranking_concept' => $concepts[$key],
					'ranking_value' => $c
				];
			}
		}
		return $result;
	}

	/*
	|--------------------------------------------------------------------------
	|	Obtiene el usuario a ser rankeado
	|--------------------------------------------------------------------------
	|	@access private
	|	@params array
	|	@return array
	|--------------------------------------------------------------------------
	*/
	private function _getUser($id_requirement)
	{
		// Si el rol es user => el usuario a rankear es assoc
		if($this->init->activeUser->user_role === 'user')
		{
			$this->db->join('dtr_requirements', 'dtr_quotations_requirements.id_requirement = dtr_requirements.id_requirement', 'inner');
			$this->db->join('dtr_quotations', 'dtr_quotations_requirements.id_quotation = dtr_quotations.id_quotation', 'inner');
			$this->db->where('dtr_quotations.quotation_status', 'finish');
			$this->db->where('dtr_requirements.id_requirement', $id_requirement);
			$quot = $this->db->get('dtr_quotations_requirements');
			$quot = $quot->row();
			return $quot->id_assoc;
		}
		else
		{
			$req = $this->db->get_where('dtr_requirements', ['id_requirement' => $id_requirement]);
			$req = $req->row();
			return $req->id_user;
		}
	}

	public function setTable($data, $columns)
	{
		$user = $this->init->activeUser;
		$result = [];

		for($k=0; $k < count($data); $k++)
		{
			foreach($columns as $c)
			{
				$index = $c['field'];
				$d = isset($data[$k][$index]) ? $data[$k][$index] : NULL;
				switch ($index)
				{
					case 'requirement_name':
						$this->db->join('dtr_requirements', 'dtr_requirements.id_requirement = dtr_ranking.id_requirement', 'inner');
						$this->db->where('dtr_ranking.id_ranking', $data[$k]['id_ranking']);
						$req = $this->db->get('dtr_ranking');
						$req = $req->row();
						$result[$k][$index] = $req->requirement_name;
					break;

					case 'rank_date':
						$dtf = $user->user_dformat;
						$result[$k][$index] = mdate($dtf, mysql_to_unix($data[$k]['rank_date']));
					break;

					case 'ranking':
						$this->db->where('dtr_ranking_concepts.id_ranking', $data[$k]['id_ranking']);
						$r = $this->db->get('dtr_ranking_concepts');

						$this->db->where('dtr_ranking_concepts.id_ranking', $data[$k]['id_ranking']);
						$this->db->select_sum('dtr_ranking_concepts.ranking_value');
						$ranking = $this->db->get('dtr_ranking_concepts');
						$ranking = $ranking->row();
						
						$result[$k][$index] = round($ranking->ranking_value / $r->num_rows(), 2);
					break;
					
					default:
						$result[$k][$index] = $d;
					break;
				}
			}
		}
		return $result;
	}
}
