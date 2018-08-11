<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Archivo de configuracion de correo
|--------------------------------------------------------------------------
| Ubicacion: application/config
*/
$config['protocol'] = 'sendmail';
$config['smtp_crypto'] = 'ssl/tls';
$config['charset'] = 'utf-8';
$config['wordwrap'] = TRUE;
$config['smtp_host'] = 'https://pacer.websitewelcome.com:2080';
$config['smtp_port'] = 465;
$config['smtp_pass'] = '9PVaBQZHJ.';
$config['smtp_user'] = 'dtransporte@dtransporte.com';
$config['mailtype'] = 'html';
$config['dsn'] = TRUE;
$config['bcc_batch_mode'] = TRUE;
$config['bcc_batch_size'] = 200;
$config['priority'] = 1;