<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| ARCHIVO DE CONFIGURACION DE VISTAS
| -------------------------------------------------------------------
| Este archivo especifica las vistas que seran cargadas/
|
*/

/*
| -------------------------------------------------------------------
|  Globales
| -------------------------------------------------------------------
| Archivos que se cargaran globalmente
|
*/
$config['dtr-global-files'] = [
	'js' => [
		'application/vendor/components/jquery/jquery.min.js',
		'js/mdb.min.js',
		'application/vendor/components/jqueryui/jquery-ui.min.js',
		'js/popper.min.js',
		'application/vendor/twbs/bootstrap/dist/js/bootstrap.min.js',
		'application/vendor/moment/moment/min/moment.min.js',
		'application/vendor/moment/moment/min/moment-with-locales.min.js',
		'js/bootstrap-select.min.js',
		'js/i18n/defaults-es_ES.js',
		'js/interface.js',
		'js/user.js',
		'js/ajax.js',
		'js/message.js',
		'js/loading-bar.js',
		'js/checker.js'
	],
	'css' => [
		'application/vendor/components/jqueryui/themes/smoothness/jquery-ui.min.css',
		'application/vendor/twbs/bootstrap/dist/css/bootstrap.min.css',
		'css/mdb.min.css',
		'css/bootstrap-select.min.css',
		'css/common.css'
	]
];

/*
| -------------------------------------------------------------------
|  Vistas publicas
| -------------------------------------------------------------------
| Vistas que se mostraran en la pagina publica
|
*/
$config['dtr-public-files'] = [
	'idPage' => 'public',
	'views' => [
		'navbar-public',
		'%lang%/jumbotron',
		'%lang%/public-home',
		'%lang%/public-register',
		'%lang%/public-faq',
		'%lang%/public-contact',
		// 'social-bar'
	],
	'js' => [
		'js/address.js',
		'js/jquery.easing.min.js',
		'js/scrolling-nav.js',
		'js/validatr.min.js',
		'js/captcha.js',
		'js/form-validator.js',
		'js/location/autocomplete.js',
		'js/location/fill-address.js',
		'js/location/gmap.js',
		'js/location/geolocation.js'
	],
	'css' => [
		'css/public.css'
	],
	'fns' => [
		" $(function(){ $(document.body).Interface({}, 'public')});"
	],
	'require-bs3' => FALSE
];

/*
| -------------------------------------------------------------------
|  Vistas rol usuario First Time
| -------------------------------------------------------------------
| Vistas que se mostraran en la pagina home First/User
|
*/
$config['dtr-first-user-files'] = [
	'idPage' => 'home-first-user',
	'views' => [
		'navbar-first-time',
		'%lang%/first-time-user-home',
	],
	'js' => [
		'application/vendor/moxiecode/plupload/js/plupload.full.min.js',
		//'application/vendor/moxiecode/plupload/js/jquery.ui.plupload/jquery.ui.plupload.min.js',
		'application/vendor/moxiecode/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js',
		'application/vendor/moxiecode/plupload/js/i18n/%lang%.js',
		'js/password.js',
		'js/form-validator.js',
		'js/validatr.min.js',
		'js/location/autocomplete.js',
		'js/location/fill-address.js',
		'js/location/gmap.js',
		'js/location/geolocation.js',
		'js/location/restore-address.js',
		'js/upload.js'
	],
	'css' => [
		//'application/vendor/moxiecode/plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css',
		'application/vendor/moxiecode/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css',
		'css/user.css'
	],
	'fns' => [
		" $(function(){ $(document.body).Interface({}, 'firstUser')});"
	]
];

/*
| -------------------------------------------------------------------
|  Vistas rol assoc First Time
| -------------------------------------------------------------------
| Vistas que se mostraran en la pagina home First/Assoc
|
*/
$config['dtr-first-assoc-files'] = [
	'idPage' => 'home-first-assoc',
	'views' => [
		'navbar-first-time',
		'%lang%/first-time-assoc-home',
	],
	'js' => [
		'application/vendor/moxiecode/plupload/js/plupload.full.min.js',
		//'application/vendor/moxiecode/plupload/js/jquery.ui.plupload/jquery.ui.plupload.min.js',
		'application/vendor/moxiecode/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js',
		'application/vendor/moxiecode/plupload/js/i18n/%lang%.js',
		'js/password.js',
		'js/form-validator.js',
		'js/validatr.min.js',
		'js/location/autocomplete.js',
		'js/location/fill-address.js',
		'js/location/gmap.js',
		'js/location/geolocation.js',
		'js/location/restore-address.js',
		'js/upload.js',
		'js/product.js'
	],
	'css' => [
		//'application/vendor/moxiecode/plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css',
		'application/vendor/moxiecode/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css',
		'css/user.css'
	],
	'fns' => [
		" $(function(){ $(document.body).Interface({}, 'firstAssoc')});"
	]
];

/*
| -------------------------------------------------------------------
|  Vistas rol user logueado
| -------------------------------------------------------------------
| Vistas que se mostraran en la pagina Place/User
|
*/
$config['dtr-user-files'] = [
	'idPage' => 'home-user',
	'views' => [
		'navbar-user',
		'%lang%/users/user-home',
	],
	'js' => [
		'application/vendor/moxiecode/plupload/js/plupload.full.min.js',
		'application/vendor/moxiecode/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js',
		'application/vendor/moxiecode/plupload/js/i18n/%lang%.js',
		'js/jquery-print/dist/jQuery.print.min.js',
		'application/vendor/eonasdan/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
		'application/vendor/nnnick/chartjs/dist/Chart.min.js',
		'js/bootstrap-table/dist/bootstrap-table.min.js',
		'js/bootstrap-table/dist/bootstrap-table-locale-all.min.js',
		'js/bootstrap-table/dist/locale/bootstrap-table-es-ES.min.js',
		'js/bootstrap-table/src/extensions/export/bootstrap-table-export.js',
		'js/bootstrap-table/bst-events.js',
		'js/tableExport/tableExport.js',
		'js/tableExport/jspdf/jspdf.js',
		'js/tableExport/jspdf/libs/sprintf.js',
		'js/tableExport/jspdf/libs/base64.js',
		'js/tableExport/jquery.base64.js',
		'js/requirements/requirements.js',
		'js/location/autocomplete.js',
		'js/location/fill-address.js',
		'js/location/gmap.js',
		'js/location/geolocation.js',
		'js/location/restore-address.js',
		'js/password.js',
		'js/quotations.js',
		'js/dates.js',
		'js/countdown.js',
		'js/quotations.js',
		'js/dates.js',
		'js/product.js',
		'js/charts.js',
		'js/form-validator.js',
		'js/validatr.min.js',
		'js/upload.js',
		'js/block-scr.js',
		'js/ranking.js'
		
	],
	'css' => [
		'application/vendor/moxiecode/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css',
		'application/vendor/eonasdan/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
		'css/bootstrap-table.min.css',
		'css/user.css'
	],
	'fns' => [
		" $(function(){ $(document.body).Interface({}, 'user')});"
	]
];

/*
| -------------------------------------------------------------------
|  Vistas agregar solicitud rol user logueado
| -------------------------------------------------------------------
| Vistas que se mostraran en la pagina Requirements/Add
|
*/
$config['dtr-requirements-add-files'] = [
	'idPage' => 'user-requirement',
	'views' => [
		'navbar-user',
		'%lang%/requirements/add'
	],
	'js' => [
		'js/jquery-print/dist/jQuery.print.min.js',
		'application/vendor/moxiecode/plupload/js/plupload.full.min.js',
		'application/vendor/moxiecode/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js',
		'application/vendor/moxiecode/plupload/js/i18n/%lang%.js',
		'js/dates.js',
		'application/vendor/eonasdan/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
		'js/FancyGrid/client/fancy.full.js',
		'js/product.js',
		'js/requirements/requirements.js',
		'js/requirements/cargo-specials.js',
		'js/requirements/hs-codes.js',
		'js/requirements/hazard-products.js',
		'js/form-validator.js',
		'js/validatr.min.js',
		'js/location/autocomplete.js',
		'js/location/fill-address.js',
		'js/location/gmap.js',
		'js/location/geolocation.js',
		'js/location/restore-address.js',
		'js/location/waypoints.js',
		'js/upload.js',
		'js/block-scr.js'
		
	],
	'css' => [
		'application/vendor/moxiecode/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css',
		'application/vendor/eonasdan/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
		'css/fancy.min.css',
		'css/user.css'
	],
	'fns' => [
		" $(function(){ $(document.body).Interface({}, 'user')});"
	]
];

/*
| -------------------------------------------------------------------
|  Vistas rol assoc logueado
| -------------------------------------------------------------------
| Vistas que se mostraran en la pagina Place/Assoc
|
*/
$config['dtr-assoc-files'] = [
	'idPage' => 'home-assoc',
	'views' => [
		'navbar-user',
		'%lang%/users/assoc-home',
	],
	'js' => [
		'application/vendor/moxiecode/plupload/js/plupload.full.min.js',
		'application/vendor/moxiecode/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js',
		'application/vendor/moxiecode/plupload/js/i18n/%lang%.js',
		'js/jquery-print/dist/jQuery.print.min.js',
		//'application/vendor/nnnick/chartjs/dist/Chart.min.js',
		'application/vendor/nnnick/chartjs/dist/Chart.bundle.min.js',
		'js/bootstrap-table/dist/bootstrap-table.min.js',
		'js/bootstrap-table/dist/bootstrap-table-locale-all.min.js',
		'js/bootstrap-table/dist/locale/bootstrap-table-es-ES.min.js',
		'js/bootstrap-table/dist/extensions/export/bootstrap-table-export.js',
		'js/bootstrap-table/bst-events.js',
		'js/tableExport/tableExport.js',
		'js/tableExport/jspdf/jspdf.js',
		'js/tableExport/jspdf/libs/sprintf.js',
		'js/tableExport/jspdf/libs/base64.js',
		'js/tableExport/jquery.base64.js',
		'js/requirements/requirements.js',
		'js/location/autocomplete.js',
		'js/location/fill-address.js',
		'js/location/gmap.js',
		'js/location/geolocation.js',
		'js/location/restore-address.js',
		'js/password.js',
		'js/quotations.js',
		'js/dates.js',
		'js/product.js',
		'js/charts.js',
		'js/form-validator.js',
		'js/validatr.min.js',
		'js/upload.js',
		'js/block-scr.js',
		'js/ranking.js'
	],
	'css' => [
		'application/vendor/moxiecode/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css',
		'css/bootstrap-table.min.css',
		'css/user.css'
	],
	'fns' => [
		" $(function(){ $(document.body).Interface({}, 'user')});"
	]
];

/*
| -------------------------------------------------------------------
|  Vistas rol assoc productos asociados
| -------------------------------------------------------------------
| Vistas que se mostraran en la pagina Place/Products
|
*/
$config['dtr-assoc-product-files'] = [
	'idPage' => 'assoc-products',
	'views' => [
		'navbar-user',
		'%lang%/users/assoc-products',
	],
	'js' => [
		'js/form-validator.js',
		'js/validatr.min.js',
		'js/product.js',
		'js/block-scr.js'
	],
	'css' => [
		'css/user.css'
	],
	'fns' => [
		" $(function(){ $(document.body).Interface({}, 'user')});"
	]
];

/*
| -------------------------------------------------------------------
|  Vistas agregar cotizacion rol assoc logueado
| -------------------------------------------------------------------
| Vistas que se mostraran en la pagina Quotations/Add
|
*/
$config['dtr-quotations-add-files'] = [
	'idPage' => 'user-quotation',
	'views' => [
		'navbar-user',
		'%lang%/quotations/add'
	],
	'js' => [
		'js/jquery-print/dist/jQuery.print.min.js',
		'application/vendor/eonasdan/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
		'js/bootstrap-table/dist/bootstrap-table.min.js',
		'js/bootstrap-table/dist/bootstrap-table-locale-all.min.js',
		'js/bootstrap-table/dist/locale/bootstrap-table-es-ES.min.js',
		'js/bootstrap-table/bst-events.js',
		'js/bootstrap-table/src/extensions/export/bootstrap-table-export.js',
		'js/tableExport/tableExport.js',
		'js/tableExport/jspdf/jspdf.js',
		'js/tableExport/jspdf/libs/base64.js',
		'js/tableExport/jquery.base64.js',
		'js/tableExport/jspdf/libs/sprintf.js',
		'js/requirements/requirements.js',
		'js/quotations.js',
		'js/dates.js',
		'js/location/gmap.js',
		'js/product.js',
		'js/charts.js',
		'js/block-scr.js'
		
	],
	'css' => [
		'application/vendor/eonasdan/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
		'css/bootstrap-table.min.css',
		'css/user.css'
	],
	'fns' => [
		" $(function(){ $(document.body).Interface({}, 'user')});"
	]
];