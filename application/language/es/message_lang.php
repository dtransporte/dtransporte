<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Archivo de mensajes comunes a la aplicacion (Espanol)
|--------------------------------------------------------------------------
| Ubicacion: application/language/es
| 
|
*/

/*
	Mensaje de eliminacion de registros
*/
$lang['dtr-message-delete-ok'] = [
	'cls' => 'success',
	'message' => 'El registro ha sido exitosamente eliminado.'
];

$lang['dtr-message-delete-error'] = [
	'cls' => 'danger',
	'message' => 'ERROR !!!<br>El registro no ha podido ser eliminado.'
];

/*
	Mensaje de actualizacion de registros
*/
$lang['dtr-message-update-ok'] = [
	'cls' => 'success',
	'message' => 'El registro ha sido exitosamente actualizado.'
];

$lang['dtr-message-update-error'] = [
	'cls' => 'danger',
	'message' => 'ERROR !!!<br>El registro no ha podido ser actualizado.'
];

/*
	Mensaje de insercion de registros
*/
$lang['dtr-insert-ok'] = [
	'cls' => 'success',
	'message' => '<p>El registro ha sido exitosamente agregados.</p>',
	'duration' => 5000
];

$lang['dtr-insert-error'] = [
	'cls' => 'danger',
	'message' => '<p>ERROR !!!</p><p>El registro no ha podido ser agregado.</p>',
	'duration' => 5000
];

/*
	Mensaje de envio de correo electronico
*/
$lang['dtr-message-email-send-ok'] = [
	'cls' => 'success',
	'message' => 'El correo ha sido enviado a sus destinatarios.'
];

$lang['dtr-message-email-send-error'] = [
	'cls' => 'danger',
	'message' => 'ERROR !!!<br>El correo no ha podido ser enviado.'
];

$lang['dtr-message-email-send-debug'] = [
	'cls' => 'warning',
	'message' => '%debug%'
];

/*
	Mensajes de alerta de geolocalizacion
*/
$lang['dtr-message-geolocation-alert'] = [
	'cls' => 'warning',
	'message' => 'ATENCI&Oacute;N !!!<br>Debe tener la opci&oacute;n <b>Geo localizaci&oacute;n</b> habilitada en su navegador para un correcto funcionamiento de la aplicaci&oacute;n.'
];

$lang['dtr-message-geolocation-noservice'] = [
	'cls' => 'warning',
	'message' => '<b>ATENCI&Oacute;N !!!<br>El servicio de geolocalizaci&oacute;n de Google no est&aacute; disponible.</b><p>C&oacute;digo Error: %errorcode%</p><p>Mensaje: %message%</p>'
];

/*
	Mensaje de alerta de ausencia de cookies
*/
$lang['dtr-message-cookie-alert'] = [
	'cls' => 'warning',
	'message' => 'Esta aplicaci&oacute;n utiliza <b>cookies</b><br>Debe tener habilitadas las <b>cookies</b> en su navegador para un correcto funcionamiento de la aplicaci&oacute;n.<hr>
	<a href="#" id="more-about-cookies" class="text-danger float-right">Saber m&aacute;s</a>
	'
];

/*
	Mensajes de registro de usuarios
*/
$lang['dtr-message-registration-error'] = [
	'cls' => 'danger',
	'message' => 'ERROR !!!<br>El usuario no ha podido ser registrado.',
	'duration' => 5000,
	'href' => ''
];

$lang['dtr-message-registration-ok'] = [
	'cls' => 'success',
	'message' => '<p><b>Bievenid@ a dTransporte.</b></p><p>Sus datos han sido satisfactoriamente registrados.</p><p><small>Un mensaje ha sido enviado a su direcci&oacute;n de email.<br>Usted tendr&aacute; 24 horas para validar sus datos. Pasado ese per&iacute;odo deber&aacute; volver a registrarse.</small></p>',
	'duration' => 5000,
	'href' => ''
];

$lang['dtr-message-registration-user-exists'] = [
	'cls' => 'danger',
	'message' => '<p>ERROR !!!</p><p>Ya existe un usuario registrado con ese email.</p>',
	'duration' => 5000,
	'href' => ''
];

/*
	Mensajes de usuarios
*/
$lang['dtr-message-user-no-exists'] = [
	'cls' => 'danger',
	'message' => '<p>ERROR !!!</p><p>No existe ning&uacute;n usuario registrado con ese email.</p>'
];

$lang['dtr-message-user-no-validated'] = [
	'cls' => 'warning',
	'message' => '<p>ALERTA !!!</p><p>Usted se ha registrado pero no ha validado a&uacute;n sus datos.</p><p>Por favor chequee su correo electr&oacute;nico a los efectos de validar sus datos.</p>'
];

$lang['dtr-message-user-no-active'] = [
	'cls' => 'warning',
	'message' => '<p>ALERTA !!!</p><p>El usuario ha sido desactivado y no puede acceder a la aplicaci&oacute;n.</p>'
];

$lang['dtr-message-login-error'] = [
	'cls' => 'danger',
	'message' => '<p>ERROR DE VALIDACI&Oacute;N !!!</p><p>Chequee nombre de usuario y contrase&ntilde;a.</p>',
	'duration' => 3000,
	'href' => ''
];

$lang['dtr-message-access-granted'] = [
	'cls' => 'success',
	'message' => '<p>Iniciando sesi&oacute;n.</p><p>Por favor espere.</p>',
	'duration' => 3000,
	'href' => ''
];

$lang['dtr-message-loggeduser-update-error'] = [
	'cls' => 'danger',
	'message' => '<p>ERROR !!!</p><p>Sus datos no han podido ser actualizados.</p>'
];

$lang['dtr-message-loggeduser-update-ok'] = [
	'cls' => 'success',
	'message' => '<p>Sus datos han sido exitosamente actualizados.</p>'
];

$lang['dtr-message-no-user-fullname'] = [
	'cls' => 'danger',
	'message' => '<p>Los campos <b>Nombre</b> y <b>Apellido</b> son obligatorios.</p>',
	
];

$lang['dtr-message-no-user-phone'] = [
	'cls' => 'danger',
	'message' => '<p>El campo <b>Tel&eacute;fono</b> es obligatorio.</p>',
	
];

$lang['dtr-message-starting-session'] = [
	'cls' => 'success',
	'message' => '<p>Iniciando sesi&oacute;n en dTransporte.</p><p>Por favor espere.</p>',
	'duration' => 3000,
	'href' => ''
];

/*
	Mensajes de contrasenias
*/
$lang['dtr-messager-curpwd-nomatch'] = [
	'cls' => 'danger',
	'message' => '<p>ERROR !!!</p><p>Sus contrase&ntilde;a actual no coincide.</p>'
];

$lang['dtr-message-user-account-validated'] = [
	'cls' => 'success',
	'message' => '<p>Sus cuenta ha sido exitosamente validada.</p>'
];

/*
	Mensajes de subidas de archivos
*/
$lang['dtr-upload-ok'] = [
	'cls' => 'success',
	'message' => '<p>Los archivos han sido exitosamente subidos al servidor.</p>'
];

$lang['dtr-upload-error'] = [
	'cls' => 'danger',
	'message' => '<p>ERROR !!!</p><p>Los archivos no han podido ser subidos al servidor.</p>'
];

$lang['dtr-upload-max-files-error'] = [
	'cls' => 'danger',
	'message' => '<p>ERROR !!!</p><p>Se ha superado el n&uacute;mero m&aacute;ximo de archivos permitidos.<br>Elimine algunos de los archivos ya subidos.</p>'
];

/*
	Mensajes de productos
*/
$lang['dtr-product-noselect'] = [
	'cls' => 'danger',
	'message' => '<p>Debe seleccionar al menos 1 servicio.</p>',
	'duration' => 5000
];

$lang['dtr-product-insert-ok'] = [
	'cls' => 'success',
	'message' => '<p>Sus servicios han sido exitosamente agregados.</p>',
	'duration' => 5000
];

$lang['dtr-product-insert-error'] = [
	'cls' => 'danger',
	'message' => '<p>ERROR !!!</p><p>Sus servicios no han podido ser agregados.</p>',
	'duration' => 5000
];

/*
	Mensajes de solicitudes
*/
$lang['dtr-message-requirement-ok'] = [
	'cls' => 'success',
	'message' => 'La solicitud ha sido exitosamente agregada.',
	'duration' => 3000,
	'href' => 'index.php/Place/User'
];

$lang['dtr-message-requirement-error'] = [
	'cls' => 'danger',
	'message' => 'ERROR !!!<br>La solicitud no ha podido ser agregada.',
	'duration' => 5000
];

$lang['dtr-message-requirement-no-origin-address'] = [
	'cls' => 'danger',
	'message' => 'ERROR !!!<br>Debe ingresar una direcci&oacute;n de origen.'
];

$lang['dtr-message-requirement-no-destination-address'] = [
	'cls' => 'danger',
	'message' => 'ERROR !!!<br>Debe ingresar una direcci&oacute;n de destino.'
];

$lang['dtr-message-requirement-no-quotations'] = [
	'cls' => 'danger',
	'message' => 'La solicitud <b>requirementname</b> no tiene cotizaciones asociadas.',
	'duration' => 5000
];

$lang['dtr-message-requirement-prog-error'] = [
	'cls' => 'danger',
	'message' => 'La solicitud no ha podido ser programada.',
	'duration' => 2000,
	'href' => ''
];

$lang['dtr-message-requirement-prog-ok'] = [
	'cls' => 'success',
	'message' => 'La solicitud ha sido programada.',
	'duration' => 2000,
	'href' => ''
];

/*
	Mensajes de cotizaciones
*/
$lang['dtr-message-quotation-no-concept'] = [
	'cls' => 'danger',
	'message' => 'ERROR !!!<br>Debe agregar un concepto.',
	'duration' => 5000
];

$lang['dtr-message-quotation-error'] = [
	'cls' => 'danger',
	'message' => 'ERROR !!!<br>La cotizaci&oacute;n no ha podido ser agregada.',
	'duration' => 3500
];

$lang['dtr-message-quotation-ok'] = [
	'cls' => 'success',
	'message' => 'La cotizaci&oacute;n ha sido exitosamente agregada.',
	'duration' => 3000,
	'href' => 'Place/Assoc'
];


$lang['dtr-message-quotation-sent-ok'] = [
	'cls' => 'success',
	'message' => 'La cotizaci&oacute;n ha sido enviada a sus destinatarios.',
	'duration' => 3000,
	'href' => 'Place/Assoc'
];

$lang['dtr-message-quotation-sent-error'] = [
	'cls' => 'danger',
	'message' => 'La cotizaci&oacute;n no ha podido ser enviada.'
];

$lang['dtr-message-requirement-close-ok'] = [
	'cls' => 'success',
	'message' => 'La solicitud ha sido exitosamente cerrada.<br>Chequee su correo electr&oacute;nico a los efectos de ver los datos de la empresa prestadora de servicios.</b>',
	'duration' => 3000,
	'href' => 'Place/User'
];

$lang['dtr-message-requirement-close-error'] = [
	'cls' => 'danger',
	'message' => 'ERROR!!!<br>La solicitud no ha podido ser cerrada.'
];

$lang['dtr-message-requirement-delete-ok'] = [
	'cls' => 'success',
	'message' => 'La solicitud ha sido exitosamente eliminada.',
	'duration' => 3000,
	'href' => ''
];

$lang['dtr-message-requirement-delete-error'] = [
	'cls' => 'danger',
	'message' => 'ERROR!!!<br>La solicitud no ha podido ser eliminada.'
];

$lang['dtr-message-requirement-add-error'] = [
	'cls' => 'danger',
	'message' => 'ERROR!!!<br>La solicitud no ha podido ser salvada.'
];

$lang['dtr-message-requirement-add-ok'] = [
	'cls' => 'success',
	'message' => 'La solicitud ha sido exitosamente salvada.'
];

$lang['dtr-message-requirement-sent-ok'] = [
	'cls' => 'success',
	'message' => 'La solicitud ha sido enviada a sus destinatarios.'
];

$lang['dtr-message-prog-requirement-send-ok'] = [
    'cls' => 'success',
	'message' => 'La solicitud programada <u>%req-name%</u> ha sido enviada a sus destinatarios.'
];

$lang['dtr-message-requirement-cancel-error'] = [
	'cls' => 'danger',
	'message' => 'ERROR!!!<br>La solicitud no ha podido ser cancelada.'
];

$lang['dtr-message-requirement-cancel-ok'] = [
	'cls' => 'success',
	'message' => 'La solicitud ha sido exitosamente cancelada.',
	'duration' => 2500,
	'href' => ''
];

$lang['dtr-message-quotation-delete-ok'] = [
	'cls' => 'success',
	'message' => 'La cotizaci&oacute;n ha sido exitosamente eliminada.',
	'duration' => 2500,
	'href' => ''
];

$lang['dtr-message-quotation-delete-error'] = [
	'cls' => 'danger',
	'message' => 'ERROR!!!<br>La cotizaci&oacute;n no ha podido ser eliminada.'
];

$lang['dtr-message-quotation-validate-error'] = [
	'cls' => 'danger',
	'message' => 'ERROR!!!<br>Los campos <u>Concepto y Valor</u> son obligatorios.',
	'duration' => 3000
];

$lang['dtr-message-ranking-ok'] = [
	'cls' => 'success',
	'message' => 'El usuario ha sido exitosamente rankeado.',
	'duration' => 2500,
	'href' => ''
];

$lang['dtr-message-ranking-error'] = [
	'cls' => 'danger',
	'message' => 'ERROR!!!<br>El usuario no ha podido ser rankeado.'
];

$lang['dtr-message-quotation-cancel-ok'] = [
	'cls' => 'success',
	'message' => 'La cotizaci&oacute;n ha sido exitosamente cancelada.',
	'duration' => 2500,
	'href' => ''
];

$lang['dtr-message-quotation-cancel-error'] = [
	'cls' => 'danger',
	'message' => 'ERROR!!!<br>La cotizaci&oacute;n no ha podido ser cancelada.'
];

$lang['dtr-message-add-requirement-error'] = [
	'no-address' => [
		'cls' => 'danger',
		'message' => 'ERROR!!!<br>Las direcci&oacute;n de origen, destino o presentaci&oacute;n son requeridas.',
		'duration' => 10000
	],
	'no-date' => [
		'cls' => 'danger',
		'message' => 'ERROR!!!<br>La fecha de expirac&oacute;n y presentaci&oacute;n son requeridos.',
		'duration' => 10000
	],
	'no-hazard-product-selected' => [
		'cls' => 'danger',
		'message' => 'ERROR!!!<br>Debe seleccionar al menos un tipo de mercader&iacute;a peligrosa.',
		'duration' => 10000
	],
	/*'incorrect-destination-address' => [
		'cls' => 'danger',
		'message' => 'ERROR!!!<br>La direcci&oacute;n de destino no existe.'
	],*/
	'no-number' => [
		'cls' => 'danger',
		'message' => 'ERROR!!!<br>Ingrese un n&uacute;mero entero v&aacute;lido.',
		'duration' => 10000
	],
	'no-moving-selected' => [
		'cls' => 'danger',
		'message' => 'ERROR!!!<br>Debe seleccionar los items de su mudanza.',
		'duration' => 10000
	],
	'no-container-selected' => [
		'cls' => 'danger',
		'message' => 'ERROR!!!<br>Debe seleccionar un tipo de contenedor.',
		'duration' => 10000
	]
];

$lang['dtr-message-user-blocked-unlock-scr'] = [
	'cls' => 'danger',
	'message' => 'ALERTA!!!<br>Su cuenta ha sido bloqueada tras varios intentos fallidos de desbloqueo de pantalla.'
];