<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador de datos de graficos
|--------------------------------------------------------------------------
| Ubicacion: application/controllers
| 
|
*/
class DataChart extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']) OR $this->init->activeUser->user_first_time == 1)
		{
			$this->init->redirectTo();
		}
		$this->load->model('chart');
            }
            
            function getUserRequiredServices()
            {
                    if($this->input->is_ajax_request())
                    {
                        $data = $this->chart->getUserRequiredServices();
                        echo json_encode($data);
                    }
            }

            function getUserRequirementsByStatus()
            {
                if($this->input->is_ajax_request())
                {
                    $data = $this->chart->getUserRequirementsByStatus($this->init->activeUser->id_user);
                    echo json_encode($data);
                }
            }

            function requirementsFinishedByAssoc()
            {
                if($this->input->is_ajax_request())
                {
                    $data = $this->chart->requirementsFinishedByAssoc();
                    echo json_encode($data);
                }
            }

            function requirementsFinishedByUser()
            {
                if($this->input->is_ajax_request())
                {
                    $data = $this->chart->requirementsFinishedByUser();
                    echo json_encode($data);
                }
            }
}