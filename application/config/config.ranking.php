<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| config.ranking - Archivo de configuracion de ranking de usuario
| -------------------------------------------------------------------------
|
| -------------------------------------------------------------------------
| Ubicacion
|	application/config
| -------------------------------------------------------------------------
*/

/*
	Ranking de usuarios
*/
$config['dtr-user-ranking-concepts'] = [
	'concept_behavior' => 'text-behavior',
	'concept_pay_respect'	=> 'text-pay-respect',
	'concept_price_respect' => 'text-price-respect',
];


/*
	Ranking de empresas
*/
$config['dtr-assoc-ranking-concepts'] = [
	'concept_behavior' => 'text-behavior',
	'concept_pay_respect'	=> 'text-pay-respect',
	'concept_price_respect' => 'text-price-respect',
	'concept_punctuality' => 'text-punctuality',
	'concept_service' => 'text-service'
];

/*
	Numero maximo de comentarios que se mostraran
	0 (cero) muestra todos
*/
$config['dtr-max-posts'] = [0 => 5, 1 => 10 , 2 => 15, 'all' => 0];


/*
	Numero maximo de segundos que se puede esperar para rankear un usuario o empresa, luego de haber finalizado la transaccion.
	Por defecto es una semana
*/
$config['dtr-ranking-maxdate'] = 7 * 24 * 60 * 60;

/*
	Fecha maxima de la penalizacion una solicitud/cotizacion.
	Pasado ese periodo sera eliminado.
	Por defecto son 2 meses
*/
$config['dtr-maxdate-fault'] = 2 * 30 * 24 * 60 * 60;

/*
	Numero de dias en que la penalizacion no se tomara en cuenta expresada en segundos.
	Se cuenta desde el momento del alta del usuario,
	Default: 30 dias

	IMPORTANTE: CAMBIAR EL DISPARADOR addCancelExpiration DE LA TABLA dtr_faults SI SE MODIFICA
				ESTA VARIABLE
*/
$config['dtr-max-no-faults'] = 30*24*60*60;

/*
	Configuracion de ranking
*/
$config['dtr-ranking'] = [
	'min'	=> 1,
	'step'	=> .1,
	'max'	=> 5
];

/*
	Penalizaciones por cancelacion de solicitud
*/
$config['dtr-user-faults'] = [
	'min' => 1/100,
	'step' => .75/100,
	'max' => 5/100
];

$config['dtr-assoc-faults'] = [
	'min' => 2.5/100,
	'max' => 5/100
];