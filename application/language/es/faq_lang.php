<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| ARCHIVO DE IDIOMAS - PREGUNTAS FRECUENTES
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/language/es
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : faq_lang.php
|--------------------------------------------------------------------------
|
*/
$lang['dtr-faq'] = [
	'about' =>[
		'title'	=> '&#191;Qu&eacute; es dTransporte?',
		'content'	=> '
			<div class="alert alert-info">
			<p>dTransporte es una plataforma que vincula a solicitantes de transporte (usuarios) con empresas oferentes del servicio (empresas asociadas).</p>
			<p>A trav&eacute;s de nuestra aplicaci&oacute;n cualquier usuario registrado podr&aacute; solicitar servicio de transporte en sus distintas modalidades y recibir de forma transparente cotizaciones de las empresas asociadas.</p>
			<p>Los usuarios podr&aacute;n evaluar, seleccionar y finalmente contratar aquella opci&oacute;n que le resulte m&aacute;s conveniente.</p>
			<p>Una vez finalizado el servicio tanto usuarios como empresas asociadas podr&aacute;n rankear sus contrapartes a los efectos de agregar valor al servicio efectuado y de esa forma ayudar al resto de la comunidad en la toma de decisiones.</p>
			</div>
		'
	],
	'register-user' => [
		'title'	=> 'Registrarse como usuario',
		'content'	=> '
			<div class="alert alert-info">
			<p>Si es una persona f&iacute;sica seleccione el radio bot&oacute;n <b>Soy Usuario</b>.</p>
			<p>Complete los campos del formulario. <small>Los campos Empresa y RUT son opcionales.</small></p>
			<p>Una vez completado haga click en el bot&oacute;n <b>Registrarse</b>.</p>
			<p>Le ser&aacute; enviada una contrase&ntilde;a generada aleatoriamente a su direcci&oacute;n de email.</p>
			<p>Ud. tendr&aacute; 24 horas para validar sus datos.</p>
			<p>Pasado ese per&iacute;odo su contrase&ntilde;a caducar&aacute; y deber&aacute; volver a registrase.</p>
			</div>
		'
	],
	'register-assoc' => [
		'title'	=> 'Registrarse como empresa asociada',
		'content'	=> '
			<div class="alert alert-info">
			<p>Si Ud. desea ofrecer sus servicios, seleccione el radio bot&oacute;n <b>Soy empresa asociada</b>.</p>
			<p>Complete los campos del formulario. <small>Los campos Empresa y RUT son obligatorios.</small></p>
			<p>Una vez completado haga click en el bot&oacute;n <b>Registrarse</b>.</p>
			<p>Le ser&aacute; enviada una contrase&ntilde;a generada aleatoriamente a su direcci&oacute;n de email.</p>
			<p>Ud. tendr&aacute; 24 horas para validar sus datos.</p>
			<p>Pasado ese per&iacute;odo su contrase&ntilde;a caducar&aacute; y deber&aacute; volver a registrase.</p>
			<p>
				<small>
					<i>Nota importante: </i>dTransporte no controla los datos por Ud. ingresados. Es importante que lea y entienda los <b><a class="pointer terms-of-use"></span> T&eacute;rminos de uso</a>.</b>
				</small>
			</p>
			</div>
		'
	],
	'why-us' => [
		'title'	=> '&#191;Porque dTransporte es la mejor opci&oacute;n?',
		'content'	=> '
			<div class="alert alert-info">
			<p>Promevemos una competencia leal y profesional entre todas las empresas de tal forma de facilitar el acceso de los usuarios a los servicios ofrecidos de una forma transparente.</p>
			<p>Los usuarios no solo podr&aacute;n elegir el mejor precio, sino tambi&eacute;n el mejor servicio asociado a sus cotizaciones. </p>
			</div>
			'
	],
	[
		'title'	=> '&#191;Qu&eacute; servicios puedo solicitar?',
		'content'	=> '
			<div class="alert alert-info">
			<ul>
				<li>Fletes expres (movilizar peque&ntilde;as cargas)</li>
				<li>Cargas livianas (menores a 5000 kgs)</li>
				<li>Cargas pesadas (camiones completos)</li>
				<li>Mercader&iacute;as peligrosas</li>
				<li>Transporte terrestre, mar&iacute;timo y a&eacute;reo internacional</li>
				<li>Solicitud de alquiler de autoelevadores y gr&uacute;as</li>
			</ul>
			</div>
			'
	],
	'privacity' => [
		'title'	=> 'Privacidad de mis solicitudes/cotizaciones',
		'content'	=> '
			<div class="alert alert-info">
			<p>Las solicitudes hechas por un usuario s&oacute;lo podr&aacute;n ser visualizadas por las empresas cotizantes cuyos servicios conincidan con los requerimientos del usuario.</p>
			<p>De la misma forma, las cotizaciones realizadas por las empresas solo podr&aacute;n ser vistas por el usuario que las solicit&oacute;</p>
			<p>De esta forma se garantiza la transparencia y privacidad de todos sus requerimientos.</p>
			</div>
			'
	],
	'payment' => [
		'title'	=> '&#191;Debo pagar para registrarme en dTransporte?',
		'content'	=> '
			<div class="alert alert-info">
			<p>Solo si se registra como empresa asociada, deber&aacute; abonar una anualidad.<br>Todas las empresas asociadas que se registren tendr&aacute;n %paymentdays% d&iacute;as corridos de uso de la aplicaci&oacute;n sin costo desde el momento de su registro.</p>
			</div>
			'
	],
	'where-to-pay' => [
		'title'	=> '&#191;Donde debo abonar la anualidad?',
		'content'	=> '
		<div class="alert alert-info">
		<p>En cualquier <b>Abitab o RedPagos</b> del pa&iacute;s.<br>Los datos de la cuenta le ser&aacute;n enviados al momento del registro.<br><small><i>Importante: </i>Ud. tendr&aacute; 5 d&iacute;as corridos (contando a partir de la fecha de vencimiento) para hacer su pago. Pasado ese per&iacute;odo su cuenta ser&aacute; desactivada.</small></p>
		</div>'
	]
];