<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| ARCHIVO DE CONFIGURACION DE TABLAS (FANCY GRID)
|--------------------------------------------------------------------------
| Ubicacion: application/config
| 
|
*/

/*
	Muestra direcciones a ser usadas en el formulario Agregar Solicitud
*/
$lang['dtr-grid-user-address'] = [
	'renderTo' => 'tbl-use-address',
	'theme' => 'bootstrap',
	'title' => 'Usar Direcciones',
	'trackOver' => TRUE,
	'subTitle' => [
		'text' => 'Doble click en cualquier l&iacute;nea para seleccionar.',
		'style' => [
			'font-size' => '0.9em',
			'font-style' => 'italic',
			'background' => 'white'
		]
	],
	'height' => 300,
	'paging'=> [
		'pageSize'=> 10,
		'pageSizeData'=> [5, 10, 20, 50]
	],
	'tbar'=> [
		[
			'type'=> 'search',
			'width'=> 350,
			'emptyText'=> 'Buscar',
			'paramsMenu'=> TRUE,
			'paramsText'=> 'Parametros'
		]
	],
	'columns' => [
		[
			'index' => 'address',
			'title' => 'Direcci&oacute;n',    
			'type' => 'string',
			'sortable' => TRUE,
			'flex' => 1
		]
	]
];

/*
	Muestra codigos arancelarios a ser usados en el formulario Agregar Solicitud
*/
$lang['dtr-grid-hs-codes'] = [
	'renderTo' => 'grid-hs-codes',
	'theme' => 'bootstrap',
	'title' => 'Doble click en cualquier l&iacute;nea para seleccionar.',
	'height' => 'fit',
	'paging'=> [
		'pageSize'=> 10,
		'pageSizeData'=> [5, 10, 20, 50]
	],
	'trackOver' => TRUE,
	'selModel' => 'row',
	'tbar'=> [
		[
			'type'=> 'search',
			'width'=> 350,
			'emptyText'=> 'Buscar',
			'paramsMenu'=> TRUE,
			'paramsText'=> 'Parametros'
		]
	],
	'columns' => [
		[
			'index' => 'code',
			'title' => 'C&oacute;digo',    
			'type' => 'string',
			'sortable' => TRUE,
			'flex' => 1
		],
		[
			'index' => 'description',
			'title' => 'Descripci&oacute;n',    
			'type' => 'string',
			'sortable' => TRUE,
			'flex' => 1
		]
	]
];

/*
	Muestra las solicitudes del usuario en pagina home
*/
$lang['dtr-tbl-user-requirements'] = [
	'classes'=> 'table table-hover table-no-bordered table-sm',
	'striped'=> TRUE,
	'iconsPrefix'=> 'fa',
	'search' => TRUE,
	'pagination' => TRUE,
	'export' => TRUE,
	'showExport' => TRUE,
	'iconSize' => 'sm',
	'columns' => [
		[
			'field' => 'id_requirement',
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'requirement_name',
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'requirement_status',
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'product_description_formatted',
			'title' => 'Servicio',
			'sortable' => TRUE,
			'align' => 'left',
			'class' => 'text-no-wrap',
		],
		[
			'field' => 'requirement_name_formatted',
			'title' => 'Nombre',
			'sortable' => TRUE,
			'align' => 'left',
			'class' => 'text-no-wrap',
			'events' => '_showRequirement'
		],
		[
			'field' => 'requirement_status_formatted',
			'title' => 'Estado',
			'align' => 'left',
			'sortable' => TRUE,
			'events' => '_showProgramationEvents'
		],
		[
			'field' => 'requirement_expiration',
			'title' => 'Expiraci&oacute;n',
			'align' => 'left',
			'sortable' => TRUE
		],
		[
			'field' => 'requirement_schedule',
			'title' => 'Presentaci&oacute;n',
			'align' => 'left',
			'sortable' => TRUE
		],
		[
			'field' => 'requirement_buttons',
			'title' => '*',
			'align' => 'right',
			'events' => '_eventsRequirement'
		]
	]
];

/*
	Muestra las cotizaciones del usuario asociadas a una solicitud en pagina home
	CAMBIAR
*/
$lang['dtr-tbl-user-requirements-quotations'] = [
	'classes'=> 'table table-hover table-bordered table-sm',
	'cache' => FALSE,
	'striped'=> TRUE,
	'export' => TRUE,
	'showExport' => TRUE,
	'iconsPrefix'=> 'fa',
	'search' => TRUE,
	'pagination' => TRUE,
	'iconSize' => 'sm',
	'columns' => [
		[
			'field' => 'id_requirement',
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'requirement_name',
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'requirement_status',
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'product_description_formatted',
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'requirement_status_formatted',
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'id_quotation',
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'quotation_status',
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'quotation_code',
			'title' => 'ID',
			'align' => 'left',
			'sortable' => TRUE
		],
		[
			'field' => 'company_name',
			'title' => 'Empresa',
			'align' => 'left',
			'sortable' => TRUE
		],
		[
			'field' => 'quotation_status_formatted',
			'title' => 'Estado',
			'align' => 'left',
			'sortable' => TRUE
		],
		[
			'field' => 'quotation_price',
			'title' => 'Precio Cotizado',
			'align' => 'left',
			'sortable' => TRUE
		],
		[
			'field' => 'assoc_ranking',
			'title' => 'Ranking',
			'align' => 'left',
			'sortable' => TRUE
		]
	]
];






/*
	Muestra las cotizaciones del assoc en pagina home
*/
$lang['dtr-tbl-user-quotations'] = [
	'classes'=> 'table table-hover table-no-bordered table-sm',
	'striped'=> TRUE,
	'iconsPrefix'=> 'glyphicon',
	'search' => TRUE,
	'pagination' => TRUE,
	'pageSize' => 10,
	'pageList' => [5, 10, 25, 50, 100],
	'export' => TRUE,
	'showExport' => TRUE,
	'iconSize' => 'sm',
	'columns' => [
		[
			'field' => 'id_quotation', //ok
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'id_requirement', //ok
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'requirement_name', //ok
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'quotation_status', //ok
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'quotation_code', //ok
			'title' => 'ID',
			'sortable' => TRUE,
			'align' => 'left',
			'class' => 'text-no-wrap',
		],
		[
			'field' => 'product_description_formatted', //ok
			'title' => 'Servicio',
			'sortable' => TRUE,
			'align' => 'left',
			'class' => 'text-no-wrap',
		],
		[
			'field' => 'requirement_name_formatted', //ok
			'title' => 'Solicitud',
			'sortable' => TRUE,
			'align' => 'left',
			'class' => 'text-no-wrap',
			'events' => '_showRequirement'
		],
		[
			'field' => 'quotation_status_formatted', //ok
			'title' => 'Estado',
			'align' => 'left',
			'sortable' => TRUE
		],
		[
			'field' => 'quotation_entered', 
			'title' => 'Alta',
			'align' => 'left',
			'sortable' => TRUE
		],
		[
			'field' => 'requirement_currency', 
			'title' => 'Moneda',
			'align' => 'left',
			'sortable' => TRUE
		],
		[
			'field' => 'quotation_price', 
			'title' => 'Precio',
			'align' => 'left',
			'sortable' => TRUE
		],
		[
			'field' => 'quotation_buttons', //ok
			'title' => '*',
			'align' => 'right',
			'events' => '_quotationEvents'
		]
	]
];

/*
	Muestra las solicitudes del assoc pendientes de cotizar en pagina home
*/
$lang['dtr-tbl-assoc-requirements-pending'] = [
	'classes'=> 'table table-hover table-no-bordered table-sm',
	'striped'=> TRUE,
	'iconsPrefix'=> 'fa',
	'search' => TRUE,
	'pagination' => TRUE,
	'iconSize' => 'sm',
	'columns' => [
		[
			'field' => 'id_requirement',
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'requirement_name',
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'product_description_formatted',
			'title' => 'Servicio',
			'sortable' => TRUE,
			'align' => 'left',
			'class' => 'text-no-wrap',
		],
		[
			'field' => 'requirement_name_formatted',
			'title' => 'Solicitud',
			'sortable' => TRUE,
			'align' => 'left',
			'class' => 'text-no-wrap',
			'events' => '_showRequirement'
		],
		[
			'field' => 'requirement_expiration',
			'title' => 'Expiraci&oacute;n',
			'align' => 'left',
			'sortable' => TRUE
		],
		[
			'field' => 'requirement_pending_buttons',
			'title' => '*',
			'align' => 'left',
			'class' => 'text-no-wrap',
			'events' => '_pendingRequirement'
		]
	]
];

/*
	Muestra ranking de usuarios
*/
$lang['dtr-tbl-users-ranking'] = [
	'classes'=> 'table table-hover table-no-bordered table-sm',
	'striped'=> TRUE,
	'iconsPrefix'=> 'fa',
	'search' => TRUE,
	'pagination' => TRUE,
	'iconSize' => 'sm',
	'detailView' => TRUE,
	'columns' => [
		[
			'field' => 'id_ranking',
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'id_user',
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'ranked_by',
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'ranked_by_formatted',
			'title' => 'Rankeado por',
			'align' => 'left',
			'sortable' => TRUE
		],
		[
			'field' => 'total_ranking',
			'title' => 'Ranking',
			'align' => 'left',
			'sortable' => TRUE
		]
	]
];

$lang['dtr-subtbl-users-ranking'] = [
	'classes'=> 'table table-hover table-no-bordered table-sm',
	'striped'=> TRUE,
	'iconsPrefix'=> 'fa',
	'search' => TRUE,
	'pagination' => TRUE,
	'iconSize' => 'sm',
	'columns' => [
		[
			'field' => 'id_ranking',
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'id_user',
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'id_requirement',
			'title' => '',
			'visible' => FALSE
		],
		[
			'field' => 'requirement_name',
			'title' => 'Solicitud',
			'align' => 'left',
			'sortable' => TRUE
		],
		[
			'field' => 'rank_date',
			'title' => 'Fecha',
			'align' => 'left',
			'sortable' => TRUE
		],
		[
			'field' => 'ranking',
			'title' => 'Ranking',
			'align' => 'left',
			'sortable' => TRUE
		],
		[
			'field' => 'rank_post',
			'title' => 'Comentario',
			'align' => 'left',
			'sortable' => TRUE
		]
	]
];







/*$lang['dtr-grid-user-requirements'] = [
	'renderTo' => 'grid-user-requirements',
	//'theme' => 'bootstrap',
	'title' => 'Listado de Solicitudes.',
	'height' => 'fit',
	'paging'=> [
		'pageSize'=> 10,
		'pageSizeData'=> [5, 10, 20, 50]
	],
	'trackOver' => TRUE,
	'selModel' => 'row',
	'tbar'=> [
		[
			'type'=> 'search',
			'width'=> 350,
			'emptyText'=> 'Buscar',
			'paramsMenu'=> TRUE,
			'paramsText'=> 'Parametros'
		]
	],
	'columns' => [
		[
			'index' => 'requirement_name',
			'title' => 'Nombre',    
			'type' => 'string',
			'sortable' => TRUE,
			'flex' => TRUE
		],
		[
			'index' => 'requirement_status',
			'title' => 'Estado',    
			'type' => 'string',
			'sortable' => TRUE,
			'flex' => TRUE
		],
		[
			'index' => 'requirement_expiration',
			'title' => 'Expiraci&oacute;n',    
			'type' => 'string',
			'sortable' => TRUE,
			'flex' => TRUE
		],
		[
			'index' => 'requirement_schedule',
			'title' => 'Presentaci&oacute;n',    
			'type' => 'string',
			'sortable' => TRUE,
			'flex' => TRUE
		],
		[
			'index' => 'id_requirement',
			'title' => 'ID',    
			'type' => 'string',
			'sortable' => FALSE,
			//'hidden' => TRUE,
			'flex' => TRUE
		]
	]
];*/