<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| ARCHIVO DE IDIOMAS - MENUS
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/language/es
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : menu_lang.php
|--------------------------------------------------------------------------
|
*/

/*
	Estilos Menu usuario logueado
*/
$lang['dtr-menu-style'] = [
	'navbar-light bg-white' => 'Claro',
	'navbar-dark bg-dark' => 'Oscuro',
	'navbar-dark bg-primary' => 'Azul',
	'navbar-dark bg-danger' => 'Rojo',
	'navbar-dark bg-success' => 'Verde'
];

/*
	Menu Publico
*/
$lang['dtr-public-menu'] = [
	//'navbar-text' => '',
	'home'	=> [
		'id'	=> 'dtr-home',
		'name' 	=> 'Inicio',
		'icon' 	=> 'fas fa-road',
		'url' => '#public-home'
	],
	'register'	=> [
		'id'	=> 'dtr-register',
		'name' 	=> 'Registrarse',
		'icon' 	=> 'fas fa-sign-in-alt',
		'url' => '#public-register'
	],
	'faq'	=> [
		'id'	=> 'dtr-faq',
		'name' 	=> 'Faq',
		'icon' 	=> 'fas fa-book',
		'url' => '#public-faq'
	],
	'contact'	=> [
		'id'	=> 'dtr-contact',
		'name' 	=> 'Contacto',
		'icon' 	=> 'fas fa-envelope',
		'url' => '#public-contact'
	],
	'access'	=> [
		'id'	=> 'dtr-access',
		'name' 	=> 'Acceder',
		'icon' 	=> 'fas fa-user',
		'url' => '#'
	]
];

/*
	Menu Usuarios
*/
$lang['dtr-user-menu'] = [
	'nav' => [
		'user-alerts'	=> [
			'id'	=> 'dtr-alerts',
			'name' 	=> '',
			'icon' 	=> 'fas fa-bell fa-2x',
			'url'	=> '#',
			'submenu' => []
		],
		'user-options'	=> [
			'id'	=> 'dtr-options',
			'name' 	=> '',
			'icon' 	=> 'fas fa-users-cog fa-2x',
			'url'	=> '#',
			'submenu' => [
				'user-data' => [
					'id'	=> 'dtr-userdata',
					'name' 	=> 'Datos Personales',
					'icon' 	=> 'fas fa-id-card',
					'url'	=> '#',
				],
				'user-location' => [
					'id'	=> 'dtr-userlocation',
					'name' 	=> 'Ubicaci&oacute;n',
					'icon' 	=> 'fas fa-globe',
					'url'	=> '#',
				],
				'user-pwd' => [
					'id'	=> 'dtr-userpwd',
					'name' 	=> 'Cambiar Contrase&ntilde;a',
					'icon' 	=> 'fas fa-key',
					'url'	=> '#',
				],
				'user-image' => [
					'id'	=> 'dtr-userimage',
					'name' 	=> 'Cambiar Im&aacute;gen',
					'icon' 	=> 'far fa-image',
					'url'	=> '#',
				],
				'user-settings' => [
					'id'	=> 'dtr-usersettings',
					'name' 	=> 'Opciones',
					'icon' 	=> 'fas fa-cogs',
					'url'	=> '#',
				],
				'user-products' => [
					'id'	=> 'dtr-userproducts',
					'name' 	=> 'Servicios',
					'icon' 	=> 'fas fa-align-justify',
					'url'	=> '%base_url%index.php/Place/Products',
				]
			]
		]
	],
	'global' => [
		'block-scr'	=> [
			'id'	=> 'dtr-block-scr',
			'name' 	=> 'Bloquear Pantalla',
			'icon' 	=> 'fas fa-lock',
			'url'	=> '#'
		],
		'logout'	=> [
			'id'	=> 'dtr-logout',
			'name' 	=> 'Cerrar Sesi&oacute;n',
			'icon' 	=> 'fas fa-sign-out-alt',
			'url'	=> '%base_url%index.php/logout'
		]
	]
];

/*
	Menu Empresas
*/
$lang['dtr-assoc-menu'] = [
	'block-scr'	=> [
		'id'	=> 'dtr-block-scr',
		'name' 	=> 'Bloquear Pantalla',
		'icon' 	=> 'fas fa-lock',
		'url'	=> '#'
	],
	'logout'	=> [
		'id'	=> 'dtr-logout',
		'name' 	=> 'Cerrar Sesi&oacute;n',
		'icon' 	=> 'fas fa-sign-out-alt',
		'url'	=> '%base_url%index.php/logout'
	],
];

/*
	Menu Primera vez
*/
$lang['dtr-first-time-menu'] = [
	'logout'	=> [
		'id'	=> 'dtr-logout',
		'name' 	=> 'Cerrar Sesi&oacute;n',
		'icon' 	=> 'fas fa-sign-out-alt',
		'url'	=> '%base_url%index.php/logout'
	]
];

/*
	Menu administrador
*/
$lang['dtr-admin-menu'] =[
	'navbar-text' => '<img src="%src%" class="%img-class% d-inline-block align-top" style="height: %height%" data-toggle="tooltip" data-placement="bottom" title="%tooltip-text%">',
	'home-admin'	=> [
		'id'	=> 'dtr-home',
		'name' 	=> 'Escritorio',
		'icon' 	=> 'fa fa-desktop',
		'url'	=> '%base_url%index.php/Admin/home'
	],
	'visitors'	=> [
		'id'	=> 'dtr-visitors',
		'name' 	=> 'Visitantes',
		'icon' 	=> 'fa fa-desktop',
		'url'	=> '%base_url%index.php/Admin/home'
	],
	'block-scr'	=> [
		'id'	=> 'dtr-block-scr',
		'name' 	=> '',
		'icon' 	=> 'fa fa-lock',
		'tooltip' => 'Bloquear Pantalla',
		'url'	=> '#'
	],
	'logout'	=> [
		'id'	=> 'dtr-logout',
		'name' 	=> 'Cerrar Sesi&oacute;n',
		'icon' 	=> 'fa fa-sign-out',
		'url'	=> '%base_url%index.php/validate/logout'
	],
];