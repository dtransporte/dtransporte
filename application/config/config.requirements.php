<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| ARCHIVO DE CONFIGURACION DE SOLICITUDES
| Vistas que se mostraran en funcion del producto seleccionado y sus
| atributos
| -------------------------------------------------------------------
|
*/
$config['dtr-requirements-views'] = [
	'info' 						=> ['%lang%/%dir%/info'],
	'dates' 					=> ['%lang%/%dir%/dates'],
	'operation-type' 			=> ['%lang%/%dir%/operation-type'],
	'address' => [
		'origin-address' 		=> '%lang%/%dir%/origin-address',
		'destination-address' 	=> '%lang%/%dir%/destination-address',
		'presentation-address' 	=> '%lang%/%dir%/presentation-address',
		'waypoints-address' 	=> '%lang%/%dir%/waypoints-address',
	],
	'cargo' => [
		'cargo-details' 			=> '%lang%/%dir%/cargo-details',
		'cargo-specials' 			=> '%lang%/%dir%/cargo-specials',
		'cargo-moving' 				=> '%lang%/%dir%/cargo-moving',
		'cargo-moving-details' 		=> '%lang%/%dir%/cargo-moving-details',
		'cargo-details-container' 	=> '%lang%/%dir%/cargo-details-container',
		'cargo-details-hazard' 		=> '%lang%/%dir%/cargo-details-hazard',
		'cargo-details-warehousing' => '%lang%/%dir%/cargo-details-warehousing',
		'cargo-details-forklift' 	=> '%lang%/%dir%/cargo-details-forklift'
	],
	'images' 					=> ['%lang%/%dir%/images'],
	'pay-terms' 				=> ['%lang%/%dir%/pay-terms'],
	'notes' 					=> ['%lang%/%dir%/notes']
];

/*
	Diferencia minima entre la fecha de expiracion y de presentacion en horas
*/
$config['dtr-dif-exp-sch'] = 8;

/*
	Diferencia minima entre la fecha de programacion y de expiracion en horas
*/
$config['dtr-dif-progamation'] = 8;


/*
	Cantidad maxima de imagenes a levantar por solicitud
*/
$config['dtr-requirements-max-files'] = 5;