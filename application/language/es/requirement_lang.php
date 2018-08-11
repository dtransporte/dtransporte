<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Archivo de textos de solicitudes (Espanol)
|--------------------------------------------------------------------------
| Ubicacion: application/language/es
| 
|
*/

$lang['tab']['info'] = 'General';
$lang['tab']['dates'] = 'Fechas';
$lang['tab']['operation-type'] = 'Operaci&oacute;n';
$lang['tab']['address'] = 'Direcciones';
$lang['tab']['cargo'] = 'Carga';
$lang['tab']['pay-terms'] = 'Pago';
$lang['tab']['images'] = 'Im&aacute;genes';
$lang['tab']['notes'] = 'Notas';

$lang['tab-icon']['info'] = 'fas fa-home';
$lang['tab-icon']['dates'] = 'far fa-calendar-alt';
$lang['tab-icon']['operation-type'] = 'fas fa-file-import';
$lang['tab-icon']['address'] = 'fas fa-map-marker-alt';
$lang['tab-icon']['cargo'] = 'fas fa-people-carry';
$lang['tab-icon']['pay-terms'] = 'fas fa-dollar-sign';
$lang['tab-icon']['images'] = 'fas fa-image';
$lang['tab-icon']['notes'] = 'fas fa-pen';

/*
	Estados de una solicitud
*/
$lang['dtr-requirement-status'] = [
	'active' => 'Activo',
	'closed' => 'Cerrado',
	'finish' => 'Finalizado',
	'nosent' => 'No enviado',
	'prog'	=> 'Envio Programado',
	'cancel' => 'Cancelado',
	'expired' => 'Expirado'
];

/*
	Requerimientos adicionales de una solicitud
*/
$lang['dtr-requirements-additionals'] = [
	'forklift' => 'Autoelevador',
	'crane' => 'Gr&uacute;a',
	'workers' => 'Peones',
	'others' => 'Otros'
];

/*
	Detalles tipo de autoelevadores
*/
$lang['dtr-forklift-type'] = [
	'any'	=> 'Indistinto',
	'nafta'	=> 'Nafta',
	'gasoil'=> 'Gasoil',
	'gas'	=> 'Gas',
	'electric' => 'El&eacute;ctrico'
];