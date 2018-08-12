<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CONTROLADOR SUBIDA ARCHIVOS
| -------------------------------------------------------------------
| 
|
*/
class Upload extends CI_Controller
{
	private $data = [];

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['DTRANSPORTE-USER']))
		{
			$this->init->redirectTo();
		}
		$this->load->model('uploader');
	}

	function index()
	{
		$multipart_params = $this->input->post(NULL, TRUE);
		$this->uploader->setUploadPath($multipart_params['upload_path']);
		$this->uploader->isImage = $multipart_params['isImage'];
		$uploadable = TRUE;
		if($multipart_params['deleteFiles'] == 1)
		{
			delete_files($this->uploader->upload_path);
		}
		if($multipart_params['maxFilesUpload'] > 1)
		{
			$numfiles = count(get_filenames($this->uploader->upload_path));
			if($numfiles >= $multipart_params['maxFilesUpload'])
			{
				$uploadable = FALSE;
			}
		}
		if($uploadable == TRUE)
		{
			if($this->uploader->upload())
			{
				// Carga la configuracion de archivos para ser subidos al servidor
				// Elimino los filtros para archivos que no son imagenes
				$imgCfg = $this->config->item('dtr-upload-files');
				if($multipart_params['isImage'] == 1)
				{
					unset($imgCfg['filters']['mime_types'][1]);
				}
				$imgCfg['multipart_params'] = $multipart_params;
				$imgCfg['multipart_params'][$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
				$msg = $this->lang->line('dtr-upload-ok');
			}
			else
			{
				$imgCfg = NULL;
				$msg = [
					'message' => $this->uploader->message,
					'cls' => 'danger'
				];
			}
		}
		else
		{
			$imgCfg = $this->config->item('dtr-upload-files');
			if($multipart_params['isImage'] == 1)
			{
				unset($imgCfg['filters']['mime_types'][1]);
			}
			$imgCfg['multipart_params'] = $multipart_params;
			$imgCfg['multipart_params'][$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
			$msg = $this->lang->line('dtr-upload-max-files-error');
		}
		$response = [
			'message' => $msg,
			'data' => $imgCfg
		];
		echo json_encode($response);
	}
}