<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| ARCHIVO DE TEMPLATES DE CORREOS
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/language/es
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : mail-tpl_lang.php
|--------------------------------------------------------------------------
|
*/

$lang['tpl-altBody'] = '<p><small><i>Este es un correo electr&oacute;nico generado autom&aacute;ticamente.<br>Por favor no responda el mismo.</i></small></p>';

$lang['tpl-contact-form'] = [
	'tplHeader' => '<h3>Correo desde p&aacute;gina de contacto.</h3>',
	'tplContent' => '
		<p>Nombre: %name%</p>
		<p>Email: %email%</p>
		<p>Mensaje: %message%</p>
	'
];

$lang['tpl-registration-form'] = [
	'tplHeader' => '<h3>Estimado usuario. Bienvenido a dTransporte.</h3>',
	'tplContent' => '
		<p><b>Deseamos que su experiencia en el uso de nuestra aplicaci&oacute;n sea de su entera conformidad y que replique la misma sumando nuevos usuarios.</b></p>
		<p>Su ID de usuario es: %username%</p>
		<p>
			Su contrase&ntilde;a: %userpwd%.<br>
			<small>Le sugerimos cambie la misma una vez inicie sesi&oacute;n en la aplicaci&oacute;n.</small>
		</p>
		<h3>
			Haga click en el siguiente link a los efectos de validar sus datos.<br>
			<a href="%baseurl%index.php/Registration/Validation/index/%userid%/%userhash%" target="_blank"><b>Validar Datos</b></a>
		</h3>
	',
	'tplSignature' => 'El equipo de dTransporte.'
];

$lang['tpl-fpwd-form'] = [
	'subject' => 'dTransporte - Reseteo de contrasenia',
	'tplHeader' => '<h3>Estimado %fullname%. Su contrase&ntilde;a ha sido reseteada.</h3>',
	'tplContent' => '
		<p>Haga click en el siguiente link para cambiar su contrase&ntilde;a: <a href="%baseurl%index.php/Users/Fpwd/validatePwd/%userid%/%userhash%" target="_blank">Cambiar Contrase&ntilde;a</a></p>
		<p>
			<small>Le sugerimos cambie la misma una vez inicie sesi&oacute;n en la aplicaci&oacute;n.</small>
		</p>
	',
	'tplSignature' => 'El equipo de dTransporte.'
];

/*
	Recordatorio de pago
*/
$lang['tpl-reminder-payment'] = [
	'subject' => 'dTransporte - Recordatorio de Pago',
	'tplHeader' => '<h3>Estimado Usuario.</h3>',
	'tplContent' => '
		<p>Le recordamos que el pago de su suscripci&oacute;n a dTransporte es para el d&iacute;a %payment-day%</p>
		<p>El monto de su importe es de %payment-amount% d&oacute;lares americanos.</p>
		<p>Puede ver las formas de pago en nuestra p&aacute;gina web o pagar en l&iacute;nea ingresando a nuestra aplicaci&oacute;n</p>
	',
	'tplSignature' => 'El equipo de dTransporte.'
];

/*
	Envio de nueva solicitud
*/
$lang['tpl-send-requirement'] = [
	'subject' => 'dTransporte - Nueva Solicitud',
	'tplHeader' => '<h3>Estimado %fullname%. Una nueva solicitud ha sido agregada.</h3>',
	'tplContent' => '
		<p>Sevicio: %product-description%</p>
		<p>Categor&iacute;a: %product-category%</p>
		<p>Fecha de Expiraci&oacute;n: %expiration-date%</p>
		<p>Lo invitamos a ingresar a nuestra <a href="%base_url%" target="_blank">aplicaci&oacute;n</a> a los efectos de cotizar.</p>
	',
	'tplSignature' => 'El equipo de dTransporte.'
];

/*
	Reenvio de nueva solicitud por cancelacion de cotizacion cerrada
*/
$lang['tpl-resend-requirement'] = [
	'subject' => 'dTransporte - Nueva Solicitud',
	'tplHeader' => '<h3>Estimado %fullname%.</h3>',
	'tplContent' => '
		<h3>Esta solicitud est&aacute; nuevamente disponible para su cotizaci&oacute;n.</h3>
		<p>Sevicio: %product-description%</p>
		<p>Categor&iacute;a: %product-category%</p>
		<p>Fecha de Expiraci&oacute;n: %expiration-date%</p>
		<p>Lo invitamos a ingresar a nuestra <a href="%base_url%" target="_blank">aplicaci&oacute;n</a> a los efectos de cotizar.</p>
	',
	'tplSignature' => 'El equipo de dTransporte.'
];

/*
	Aviso al propietario de la solicitud por cancelacion de cotizacion cerrada
*/
$lang['tpl-notice-user-cancel-quotation'] = [
	'subject' => 'dTransporte - Cancelacion de Cotizacion',
	'tplHeader' => '<h3>Estimado %fullname%.</h3>',
	'tplContent' => '
		<h3>Su solicitud %requirement_name% est&aacute; nuevamente activa y disponible para su cotizaci&oacute;n.</h3>
		<h3>Motivo: La empresa %company-name% ha cancelado la cotizaci&oacute;n %quotation_code%</h3>
		<p>Fecha de Expiraci&oacute;n: %expiration-date%</p>
		<p>Lo invitamos a ingresar a nuestra <a href="%base_url%" target="_blank">aplicaci&oacute;n</a> a los efectos de chequear las nuevas cotizaciones.</p>
	',
	'tplSignature' => 'El equipo de dTransporte.'
];

/*
	Cancelacion de solicitud
*/
$lang['tpl-cancel-requirement'] = [
	'subject' => 'dTransporte - Cancelacion de Solicitud',
	'tplHeader' => '<h3>Estimado %fullname%. La solicitud %requirement_name% ha sido cancelada.</h3>',
	'tplContent' => '
		<p>La solicitud %requirement_name% ha sido cancelada por su propietario y la misma ya no estar&aacute; disponible para su cotizaci&oacute;n.</p>
		<p>Lo invitamos a ingresar a nuestra <a href="%base_url%" target="_blank">aplicaci&oacute;n</a> a los efectos de chequear las solicitudes activas.</p>
	',
	'tplSignature' => 'El equipo de dTransporte.'
];

$lang['tpl-send-quotation'] = [
	'subject' => 'dTransporte - Nueva Cotizacion',
	'tplHeader' => '<h3>Estimado %fullname%. Ha recibido una nueva cotizaci&oacute;n referente a su solicitud %requirement_name%.</h3>',
	'tplContent' => '
		<p>Tipo servicio: %product-description%.</p>
		<p>Empresa: %company-name%</p>
		<p>Lo invitamos a ingresar a nuestra <a href="%base_url%" target="_blank">aplicaci&oacute;n</a> a los efectos de chequear las cotizaciones activas.</p>
	',
	'tplSignature' => 'El equipo de dTransporte.'
];

$lang['tpl-cancel-quotation'] = [
	'subject' => 'dTransporte - Cancelacion de Cotizacion',
	'tplHeader' => '<h3>Estimado %fullname%. La cotizaci&oacute;n %quotation_code% referente a su solicitud %requirement_name% ha sido cancelada por su propietario.</h3>',
	'tplContent' => '
		<p>Empresa: %company-name%</p>
		<p>Lo invitamos a ingresar a nuestra <a href="%base_url%" target="_blank">aplicaci&oacute;n</a> a los efectos de chequear las cotizaciones activas.</p>
	',
	'tplSignature' => 'El equipo de dTransporte.'
];

/*
	Cierre de solicitud
*/
$lang['tpl-send-close-requirement-user'] = [
	'subject' => 'dTransporte - Cierre de Cotizacion',
	'tplHeader' => '<h3>Estimado %fullname%. Su solicitud %requirement_name% ha sido cerrada.</h3>',
	'tplContent' => '
		<h4>C&oacute;digo Cotizaci&oacute;n: <b>%quotation_code%</b></h4>
		<h4><u>Datos de Empresa</u></h4>
		<p>Empresa: %company-name%</p>
		<p>Tel&eacute;fono: %company-phone%</p>
		<p>Contacto: %person-name%</p>
		<p>Lo invitamos a ingresar a nuestra <a href="%base_url%" target="_blank">aplicaci&oacute;n</a>.</p>
	',
	'tplSignature' => 'El equipo de dTransporte.'
];

$lang['tpl-send-close-requirement-assoc'] = [
	'subject' => 'dTransporte - Cierre de Cotizacion',
	'tplHeader' => '<h3>Estimado %fullname%. La cotizaci&oacute;n referente a la solicitud %requirement_name% ha sido asignada a su empresa.</h3>',
	'tplContent' => '
		<h4>C&oacute;digo Cotizaci&oacute;n: <b>%quotation_code%</b></h4>
		<h4><u>Datos de Usuario</u></h4>
		<p>Empresa: %company-name%</p>
		<p>Tel&eacute;fono: %company-phone%</p>
		<p>Contacto: %person-name%</p>
		<p>Lo invitamos a ingresar a nuestra <a href="%base_url%" target="_blank">aplicaci&oacute;n</a>.</p>
	',
	'tplSignature' => 'El equipo de dTransporte.'
];

/*
	Aceptacion solicitud visita requerida
*/
$lang['tpl-send-visit-accept-user'] = [
	'subject' => 'dTransporte - Aceptacion de Visita',
	'tplHeader' => '<h3>Estimado usuario. La visita referente a su solicitud %requirement_name% ha sido aceptada.</h3>',
	'tplContent' => '
		<h4><u>Datos de Empresa</u></h4>
		<p>Empresa: %company-name%</p>
		<p>Direcci&oacute;n: %company-address%</p>
		<p>Tel&eacute;fono: %company-phone%</p>
		<p>Contacto: %person-name%</p>
		<p>Lo invitamos a ingresar a nuestra <a href="%base_url%" target="_blank">aplicaci&oacute;n</a>.</p>
		<h5>
			<b>Nota:</b><br>
			<u>Una vez finalizado el servicio con la empresa seleeccionada lo invitamos a ingresar a la aplicaci&oacute;n a los efectos de cerrar la solicitud y rankear a la empresa.</u>
		</h5>
	',
	'tplSignature' => 'El equipo de dTransporte.'
];

$lang['tpl-send-visit-accept-assoc'] = [
	'subject' => 'dTransporte - Aceptacion de Visita',
	'tplHeader' => '<h3>Estimado usuario. La cotizaci&oacute;n referente a la solicitud %requirement_name% ha enviada.</h3>',
	'tplContent' => '
		<h4><u>Datos de Usuario</u></h4>
		<p>Empresa: %company-name%</p>
		<p>Tel&eacute;fono: %company-phone%</p>
		<p>Contacto: %person-name%</p>
		<p>Lo invitamos a ingresar a nuestra <a href="%base_url%" target="_blank">aplicaci&oacute;n</a>.</p>
		<h5>
			<b>Nota:</b><br>
			<u>Una vez finalizado el servicio lo invitamos a ingresar a la aplicaci&oacute;n a los efectos de rankear al usuario.</u>
		</h5>
	',
	'tplSignature' => 'El equipo de dTransporte.'
];

$lang['tpl-unblock-user-form'] = [
	'subject' => 'dTransporte - Alerta. Cuenta Bloqueada',
	'tplHeader' => '<h3>Estimado %fullname%.</h3>',
	'tplContent' => '
		<h3>Su cuenta ha sido bloqueada tras varios intentos de desbloquear su sesi&oacute;n activa.</h3>
		<hr>
		<h4>Los motivos pueden ser:</h4>
		<ul>
			<li>Has olvidado tu contrase&ntilde;a.</li>
			<li>Otra persona o un bot ha intentado restaurar su sesi&oacute;n.</li>
		</ul>
		
		<hr>
		<h4>Sugerencias de seguridad:</h4>
		<ul>
			<li>No comparta su contrase&ntilde;a.</li>
			<li>Mantenga la misma en un lugar seguro.</li>
			<li>No permita que su navegador recuerde su contrase&ntilde;a.</li>
		</ul>
		<hr>
		<h3>
			Haga click en el siguiente link a los efectos de cambiar su contrase&ntilde;a.<br>
			<a href="%baseurl%index.php/blockScr/loadPage/%userid%/%userhash%" target="_blank"><b>Cambiar Contrase&ntilde;a</b></a>
		</h3>
	',
	'tplSignature' => 'El equipo de dTransporte.'
];