<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Uploader - Modelo de gestion de subida de archivos al servidor
| -------------------------------------------------------------------------
|
| -------------------------------------------------------------------------
| Ubicacion
|	application/models
| -------------------------------------------------------------------------
*/

class Uploader extends CI_Model{

	private $cfg = [];
	public $upload_path = NULL;
	public $max_size = 1000;
	public $message = NULL;
	public $isImage = 1; // image, file, both,
	public $data;
	public $overwrite = TRUE;

	function __construct()
	{
		parent::__construct();
		$this->load->library('upload');
	}

	public function upload()
	{
		$this->_setConfig();
		$this->upload->initialize($this->cfg);
		if($this->upload->do_upload('file'))
		{
			$this->message = 'ok';
			$this->data = $this->upload->data();
			return TRUE;
		}
		else{
			$this->message = $this->upload->display_errors();
			return FALSE;
		}
	}

	private function _setConfig()
	{
		$imgCfg = $this->config->item('dtr-upload-files');
		$fileTypes = $this->isImage == 1 ? $imgCfg['filters']['mime_types'][0]['extensions'] : $imgCfg['filters']['mime_types'][1]['extensions'];
		$this->cfg['upload_path'] = $this->upload_path;
		$this->cfg['max_size'] = $this->max_size;
		$this->cfg['overwrite'] = $this->overwrite;
		$this->cfg['allowed_types'] = implode('|', explode(',', $fileTypes));
		//$this->cfg['max_filename'] = $this->config->item('dtr-filename-len');
	}

	public function setUploadPath($path)
	{
		$this->upload_path = str_replace(
			['%user_path%', '%requirement_path%'],
			[$this->init->activeUser->userPath, ''],
			$path
		);
	}
}