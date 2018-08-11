<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| MODELO DE GESTION DE ACTIVIDADES DE USUARIO - LOG
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/models
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : Codeqr.php
|--------------------------------------------------------------------------
|
*/
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;

class Codeqr extends CI_Model
{
	public $qrcode;
	public $qrText;
	private $strLen = 30;

	function __construct()
	{
		parent::__construct();
	}

	function get()
	{
		$this->_set();
	}

	function _set()
	{
		$this->load->helper('string');
		$this->qrText = random_string('alnum', $this->strLen);
		$path = $this->init->activeUser->userPath.'/';
		$this->qrcode = new QrCode($this->qrText);
		$this->qrcode->setSize(300);
		$this->qrcode->setMargin(2);

		$this->qrcode->setWriterByName('png');
		
		
		$this->qrcode->setEncoding('UTF-8');
		$this->qrcode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH);
		$this->qrcode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0]);
		$this->qrcode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255]);
		$this->qrcode->setLogoWidth(150);
		$this->qrcode->setValidateResult(false);
		$this->qrcode->writeFile($path.'qrcode.png');
	}
}