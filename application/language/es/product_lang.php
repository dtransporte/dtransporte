<?php
/*
|--------------------------------------------------------------------------
| Traducciones de categorias y productos
|--------------------------------------------------------------------------
|
|
| Location: ./application/language/es
| Archivo: product_lang.php
|
*/

$lang['product-attribute']['visit-required'] = [
	'title' => 'Requiere Visita',
	'message' => 'Seleccione esta opci&oacute;n si su servicio requiere previa visita.'
];
$lang['product-attribute']['no-visit-required'] = [
	'title' => 'No Requiere Visita',
	'message' => 'Seleccione esta opci&oacute;n si su servicio no requiere previa visita.<br> En ese caso Ud. mismo deber&aacute; agregar los items que desea mudar.'
];

$lang['product-attribute']['fcl'] = [
	'title' => 'Carga Completa',
	'message' => 'Seleccione esta opci&oacute;n si se trata de contenedor o cami&oacute;n completo.'
];
$lang['product-attribute']['lcl'] = [
	'title' => 'Carga Consolidada',
	'message' => 'Seleccione esta opci&oacute;n si se trata de carga consolidada.'
];

$lang['category']['text-local-transport'] = 'Transporte Local';
$lang['category']['text-intl-transport'] = 'Transporte Internacional';
$lang['category']['text-rent'] = 'Alquiler';
$lang['category']['text-services'] = 'Servicios';
$lang['category']['text-passenger-transport'] = 'Transporte Pasajeros';
$lang['category']['text-special-load'] = 'Cargas Especiales';

$lang['product']['text-light-load'] = 'Carga Liviana';
$lang['product']['text-light-load-alt'] = 'Carga menor a 5000 Kgs y/o 20 M3';

$lang['product']['text-heavy-load'] = 'Carga Pesada';
$lang['product']['text-heavy-load-alt'] = 'Carga superior a 5000 Kgs y/o 20 M3';

$lang['product']['text-freight-express'] = 'Flete Express';
$lang['product']['text-freight-express-alt'] = 'Movilice peque&ntilde;as cargas r&aacute;pridamente';

$lang['product']['text-school-transport'] = 'Escolares';
$lang['product']['text-school-transport-alt'] = 'Transporte de Escolares';

$lang['product']['text-message-transport'] = 'Mensajer&iacute;a';
$lang['product']['text-message-transport-alt'] = 'Mensajer&iacute;a y Cadeter&iacute;a';

$lang['product']['text-movings'] = 'Mudanzas';
$lang['product']['text-movings-alt'] = 'Mudanzas';

$lang['product']['text-bus-company'] = 'Pasajeros';
$lang['product']['text-bus-company-alt'] = 'Servicio de Buses';

$lang['product']['text-remise'] = 'Remiser&iacute;a';
$lang['product']['text-remise-alt'] = 'Servicio de Remises';

$lang['product']['text-air-transport'] = 'A&eacute;reo Internacional';
$lang['product']['text-air-transport-alt'] = 'Transporte A&eacute;reo';

$lang['product']['text-sea-transport'] = 'Mar&iacute;timo Internacional';
$lang['product']['text-sea-transport-alt'] = 'Transporte Mar&iacute;timo';

$lang['product']['text-inland-transport'] = 'Terrestre Internacional';
$lang['product']['text-inland-transport-alt'] = 'Transporte Terrestre';

$lang['product']['text-forklifts'] = 'Autoelevadores';
$lang['product']['text-forklifts-alt'] = 'Alquiler de Autoelevadores';

$lang['product']['text-cranes'] = 'Gr&uacute;as';
$lang['product']['text-cranes-alt'] = 'Alquiler de Gr&uacute;as';

$lang['product']['text-warehousing'] = 'Almacenaje';
$lang['product']['text-warehousing-alt'] = 'Servicio de Almacenaje y Dep&oacute;sito';

$lang['product']['text-custom-clearance'] = 'Despachos Aduaneros';
$lang['product']['text-custom-clearance-alt'] = 'Despachos Aduaneros';

$lang['product']['text-logistic-assistance'] = 'Aesor&iacute;a Log&iacute;stica';
$lang['product']['text-logistic-assistance-alt'] = 'Aesor&iacute;a Log&iacute;stica';

$lang['product']['text-hazard'] = 'Mercader&iacute;a Peligrosa';
$lang['product']['text-hazard-alt'] = 'Traslado de Combustible, qu&iacute;micos, explosivos, etc';

$lang['product']['text-live-load'] = 'Cargas Vivas';
$lang['product']['text-live-load-alt'] = 'Traslado de animales y plantas';

$lang['product']['text-vehicles-load'] = 'Traslado de Veh&iacute;culos';
$lang['product']['text-vehicles-load-alt'] = 'Traslado de todo tipo de veh&iacute;culos';

$lang['product']['text-frozen-load'] = 'Carga Refrigerada';
$lang['product']['text-frozen-load-alt'] = 'Carga Refrigerada';

/*
	Tipos de productos
*/
$lang['product-type'] = [
	'general' => 'Mercader&iacute;as no peligrosas',
	'frozen' => 'Mercader&iacute;as que requieren cadena de fr&iacute;o',
	'hazard' => 'Mercader&iacute;as peligrosas'
];

/*
	Link sitio oficial
*/
$lang['imo-official-link'] = 'http://www.imo.org/en/Publications/Documents/TheIMOBookshelf/carriageonboard.pdf';

/*
	Listado mercaderias peligrosas
*/
$lang['products-hazard-clasification'] = [
	1 => [
		'name' => 'Explosivos',
		'1.1' => [
			'description' => 'Objetos con riesgo de explosi&oacute;n de toda la masa',
			'image' => 'imgs/hazard-products/1.png'
		],
		'1.2' => [
			'description' => 'Representan riesgo de proyecci&oacute;n, pero no de explosi&oacute;n de toda la masa',
			'image' => 'imgs/hazard-products/1.png'
		],
		'1.3' => [
			'description' => 'Representan riesgo de incendio y pueden producir efectos de onda de choque',
			'image' => 'imgs/hazard-products/1.png'
		],
		'1.4' => [
			'description' => 'No representan un riesgo considerable',
			'image' => 'imgs/hazard-products/1-4.png'
		],
		'1.5' => [
			'description' => 'Poco sensibles que implican riesgo de explosi&oacute;n en masa',
			'image' => 'imgs/hazard-products/1-5.png'
		],
		'1.6' => [
			'description' => 'Son extremadamente poco sensibles y no representan riesgo de explosi&oacute;n en toda la masa',
			'image' => 'imgs/hazard-products/1-6.png'
		]
	],
	2 => [
		'name' => 'Gases',
		'2.1' => [
			'description' => 'Gases inflamables. Pueden inflamarse al contacto con una fuente de calor',
			'image' => 'imgs/hazard-products/2-1.png'
		],
		'2.2' => [
			'description' => 'Gases no inflamables, no t&oacute;xicos. Desplazan el ox&iacute;geno provocando asfixia',
			'image' => 'imgs/hazard-products/2-2.png'
		],
		'2.3' => [
			'description' => 'Gases t&oacute;xicos. Su inhalaci&oacute;n puede causar efectos agudos o incluso la muerte. Pueden ser inflamables, corrosivos o comburentes',
			'image' => 'imgs/hazard-products/2-3.png'
		]
	],
	3 => [
		'name' => 'L&iacute;quidos inflamables',
		'3' => [
			'description' => 'Esta clasificaci&oacute;n comprende l&iacute;quidos inflamables y explosivos l&iacute;quidos insensibles',
			'image' => 'imgs/hazard-products/3.png'
		]
	],
	4 => [
		'name' => 'S&oacute;lidos inflamables',
		'4.1' => [
			'description' => 'Materias s&oacute;lidas inflamables, autorreactivas o explosivas desensibilizadas. Estas pueden reaccionar espont&aacute;neamente',
			'image' => 'imgs/hazard-products/4-1.png'
		],
		'4.2' => [
			'description' => 'Sustancias espont&aacute;neamente inflamables. Pueden inflamarse al calentarse espont&aacute;neamente, cuando entran en contacto con el aire o mientras se transportan',
			'image' => 'imgs/hazard-products/4-2.png'
		],
		'4.3' => [
			'description' => 'Sustancias que al contacto con el agua desprenden gases inflamables',
			'image' => 'imgs/hazard-products/4-3.png'
		]
	],
	5 => [
		'name' => 'Comburentes y per&oacute;xidos org&aacute;nicos',
		'5.1' => [
			'description' => 'Comburentes. L&iacute;quidos o s&oacute;lidos que favorecen la combusti&oacute;n, pueden favorecer el desarrollo de incendios',
			'image' => 'imgs/hazard-products/5-1.png'
		],
		'5.2' => [
			'description' => 'Per&oacute;xidos org&aacute;nicos. Se derivan del per&oacute;xido de hidr&oacute;geno. Estas sustancias, por ser sumamente peligrosas, solo se pueden cargar en una unidad de carga en determinadas cantidades',
			'image' => 'imgs/hazard-products/5-2.png'
		]
	],
	6 => [
		'name' => 'T&oacute;xicos',
		'6.1' => [
			'description' => 'Sustancias t&oacute;xicas. Pueden causar la muerte por inhalaci&oacute;n, absorci&oacute;n cut&aacute;nea o ingesti&oacute;n',
			'image' => 'imgs/hazard-products/6-1.png'
		],
		'6.2' => [
			'description' => 'Sustancias infecciosas. Contienen agentes pat&oacute;genos (microorganismos) que pueden provocar enfermedades',
			'image' => 'imgs/hazard-products/6-2.png'
		]
	],
	7 => [
		'name' => 'Material Radioactivo',
		'Categoria I' => [
			'description' => 'Para bultos con un m&aacute;ximo nivel de radiaci&oacute;n en la superficie de 0.5 milirem/h o para contenedores que no contengan bultos con categor&iacute;as m&aacute;s altas',
			'image' => 'imgs/hazard-products/7-1.png'
		],
		'Categoria II' => [
			'description' => 'Para bultos con un nivel de radiaci&oacute;n en la superficie mayor a 0.5 milirem/h, sin exceder los 50 milirem/h. El &iacute;ndice de transporte no debe exceder de 1.0, o para contenedores donde el &iacute;ndice de transporte no exceda a 1.0 y no contenga bultos visibles de categor&iacute;a III',
			'image' => 'imgs/hazard-products/7-2.png'
		],
		'Categoria III' => [
			'description' => 'Para bultos con un nivel m&aacute;ximo de radiaci&oacute;n en superficie de 200 milirem/h, o para contenedores cuyo &iacute;ndice de transporte sea menor o igual que 1.0 y que transporte bultos visibles de categor&iacute;a III',
			'image' => 'imgs/hazard-products/7-3.png'
		],
		'Categoria IV' => [
			'description' => 'Materiales fisionables',
			'image' => 'imgs/hazard-products/7-4.png'
		]
	],
	8 => [
		'name' => 'Corrosivos',
		'8' => [
			'description' => 'Estas sustancias son de efecto destructivo al contacto, es decir, da&ntilde;an el tejido de la piel',
			'image' => 'imgs/hazard-products/8.png'
		]
	],
	9 => [
		'name' => 'Objetos peligrosos diversos',
		'9' => [
			'description' => 'Estos suponen alg&uacute;n tipo peligro no contemplado en los anteriores, como pude ser el caso de dioxinas, pilas de litio, hielo seco, etc',
			'image' => 'imgs/hazard-products/9.png'
		]
	]
];
?>