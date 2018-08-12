<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Archivo de idiomoa incoterms (Espanol)
|--------------------------------------------------------------------------
| Ubicacion: application/language/es
| 
|
*/
$lang['dtr-operation-type'] = [
	'impo'		=> 'Importaci&oacute;n',
	'expo'		=> 'Exportaci&oacute;n',
	'transit'	=> 'Tr&aacute;nsito',
	'at'		=> 'Adimisi&oacute;n Temporaria',
];

$lang['dtr-incoterms'] = [
	'exw'		=> [
		'name'	=> 'EXW - EX WORKS',
		'description'	=> '"Ex Works" significa que el vendedor entrega cuando pone la mercanc&iacute;a a disposici&oacute;n del comprador en el establecimiento del vendedor o en otro lugar convenido (es decir, las obras, f&aacute;brica, almac&eacute;n, etc.). El vendedor no tiene que cargar la mercanc&iacute;a en un veh&iacute;culo receptor, ni necesita de despachar las mercanc&iacute;as para la exportaci&oacute;n, en donde dicha autorizaci&oacute;n es aplicable.'
	],
	'fca' => [
		'name'	=> 'FCA - FREE CARRIER',
		'description'	=> '"Free Carrier" significa que el vendedor entrega la mercanc&iacute;a al transportista oa otra persona designada por el comprador en el establecimiento del vendedor o en otro lugar convenido. Las partes est&aacute;n bien asesorados para especificar lo m&aacute;s claramente posible el punto dentro del lugar de entrega, ya que el riesgo se transmitir&aacute; al comprador en ese punto.'
	],
	/*'cip' => [
		'name'	=> 'CIP - CARRIAGE AND INSURANCE PAID TO',
		'description'	=> '"Carriage And Insurance Paid To" significa que el vendedor entrega la mercanc&iacute;a al transportista o a otra persona designada por el vendedor en un lugar acordado (si tal lugar se acord&oacute; entre las partes) y que el vendedor debe contratar y pagar los costos de transporte necesario para llevar la mercanc&iacute;a al lugar de destino.
			El vendedor tambi&eacute;n tiene contratos para la cobertura de seguro contra el riesgo del comprador de p&eacute;rdida o da&ntilde;o de la mercanc&iacute;a durante el transporte. El comprador ha de observar que, bajo el CIP el vendedor est&aacute; obligado a conseguir un seguro s&oacute;lo con cobertura m&iacute;nima. Si el deseo del comprador para tener m&aacute;s protecci&oacute;n de seguro, necesitar&aacute; ya sea para acordarlo expresamente con el vendedor o hacer sus propios arreglos de seguros adicionales.'
	],*/
	'dat' => [
		'name'	=> 'DAT - DELIVERED AT TERMINAL',
		'description'	=> '"Delivered At Terminal" significa que el vendedor realiza la entrega cuando la mercanc&iacute;a es puesta a disposici&oacute;n del comprador sobre los medios de transporte disponibles para descarga en el lugar de destino. El vendedor asume todos los riesgos involucrados en llevar la mercader&iacute;a hasta el lugar convenido.'
	],
	'dap' => [
		'name'	=> 'DAP - DELIVERED AT PLACE',
		'description'	=> '"Delivered At Place" significa que el vendedor realiza la entrega cuando la mercanc&iacute;a es puesta a disposici&oacute;n del comprador sobre los medios de transporte disponibles para descarga en el lugar de destino. El vendedor asume todos los riesgos involucrados en llevar la mercader&iacute;a hasta el lugar convenido.'
	],
	'ddp' => [
		'name'	=> 'DDP - DELIVERED DUTY PAID',
		'description'	=> '"Delivered Duty Paid" significa que el vendedor entrega la mercanc&iacute;a cuando la mercanc&iacute;a es puesta a disposici&oacute;n del comprador, despachada para la importaci&oacute;n de los medios de transporte disponibles para descarga en el lugar de destino. El vendedor asume todos los costes y riesgos contra&iacute;dos al llevar la mercanc&iacute;a al lugar de destino y tiene la obligaci&oacute;n de despachar las mercanc&iacute;as no s&oacute;lo para la exportaci&oacute;n, sino tambi&eacute;n para la importaci&oacute;n, a pagar cualquier derecho, tanto para la exportaci&oacute;n e importaci&oacute;n y para llevar a cabo todas las costumbres formalidades.'
	],
	'fas' => [
		'name'	=> 'FAS - FREE ALONG SIDE SHIP',
		'description'	=> '"Free Alongside Ship" significa que el vendedor realiza la entrega cuando la mercanc&iacute;a es colocada al costado del buque (por ejemplo, en un muelle o una barcaza) nombrado por el comprador en el puerto de embarque convenido. El riesgo de p&eacute;rdida o da&ntilde;o de la mercanc&iacute;a se transfiere cuando los bienes est&aacute;n al costado del buque, y el comprador asume todos los costos de ese momento en adelante.'
	],
	'fob' => [
		'name'	=> 'FOB - FREE ON BOARD',
		'description'	=> '"Free On Board" significa que el vendedor entrega la mercanc&iacute;a a bordo del buque designado por el comprador en el puerto de embarque. El riesgo de p&eacute;rdida o da&ntilde;o de la mercanc&iacute;a se transfiere cuando las mercanc&iacute;as se encuentran a bordo del buque, y el comprador asume todos los costos de ese momento en adelante.'
	],
	/*'cfr' => [
		'name'	=> 'CFR - COST AND FREIGHT',
		'description'	=> '"Cost and Freight" significa que el vendedor entrega la mercanc&iacute;a a bordo del buque o promueva la mercanc&iacute;a ya tan entregados. El riesgo de p&eacute;rdida o da&ntilde;o de la mercanc&iacute;a se transfiere cuando las mercanc&iacute;as se encuentran a bordo del buque. el vendedor debe contratar y pagar los costos y el flete necesarios para llevar la mercanc&iacute;a al puerto de destino convenido.'
	],
	'cif' => [
		'name'	=> 'CIF - COST INSURANCE AND FREIGHT',
		'description'	=> '"Cost, Insurance and Freight" significa que el vendedor entrega la mercanc&iacute;a a bordo del buque. El riesgo de p&eacute;rdida o da&ntilde;o de la mercanc&iacute;a se transfiere cuando las mercanc&iacute;as se encuentran a bordo del buque. El vendedor debe contratar y pagar los costos y el flete necesarios para llevar la mercanc&iacute;a al puerto de destino convenido.
			El vendedor tambi&eacute;n tiene contratos para la cobertura de seguro contra el riesgo del comprador de p&eacute;rdida o da&ntilde;o de la mercanc&iacute;a durante el transporte. El comprador ha de observar que, bajo CIF el vendedor est&aacute; obligado a conseguir un seguro s&oacute;lo con cobertura m&iacute;nima. Si el deseo del comprador para tener m&aacute;s protecci&oacute;n de seguro, necesitar&aacute; ya sea para acordarlo expresamente con el vendedor o hacer sus propios arreglos de seguros adicionales.'
	],*/
];