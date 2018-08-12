<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina publica registro de usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : public-register.php
|--------------------------------------------------------------------------
|
*/
$csrf_reg = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);
$icon = $this->lang->line('dtr-public-menu')['register']['icon'];
$action = base_url().'index.php/registration';
$userTypes = [
	'user' => $this->lang->line('text-user-type-user'),
	'assoc' => $this->lang->line('text-user-type-assoc')
];
?>
<div class="container" id="public-register">
	<h1 class="display-4 d-none d-sm-block" style="padding: 5px"><span class="<?=$icon?>"></span> Registrarse</h1>
	<h1 class="d-md-none"><span class="<?=$icon?>"></span> Registrarse</h1>
	<br>
	<div class="row shadow bg-white">
		<!-- INFO REGISTRO USUARIOS. OCULTADO SOLO EN DISPOSITIVOS XS -->
		<div class="col-6 alert alert-light d-none d-sm-block">
			<div id="register-info-user">
				<h3 class="text-center"><u>Registro de Usuario</u></h3>
				<p><b>Como usuario de <b>dTransporte</b> usted podr&aacute;:</b></p>
				<ul>
					<li>Solicitar cotizaciones de fletes y/o servicios.</li>
					<li>Seleccionar aquellas que se ajustan a sus requerimientos.</li>
					<li>Contratar de una forma eficiente y transparente asegur&aacute;ndose el precio y servicio pactado.</li>
					<li>Rankear el servicio ofrecido a los efectos de agregar valor a los requerimientos de otros usuarios.</li>
				</ul>
				<p>Complete los campos del formulario.</p>
				<p>El campo <b>Empresa</b> es opcional.</p>
				<p><b>Su correo electr&oacute;nico ser&aacute; su ID de usuario con el cu&aacute;l podr&aacute; acceder a la aplicaci&oacute;n.</b></p>
				<p>Una vez registrado se le enviar&aacute; una contrase&ntilde;a generada autom&aacute;ticamente a su direcci&oacute;n de email.</p>
				<p>Usted tendr&aacute; 24 horas para validar sus datos.</p>
				<p>Una vez expirado ese per&iacute;odo deber&aacute; volver a registrarse.</p>
			</div>

			<div class="d-none" id="register-assoc-info">
				<h3 class="text-center"><u>Registro de Empresa</u></h3>
				<p><b>Como empresa registrada en <b>dTransporte</b> usted podr&aacute;:</b></p>
				<ul>
					<li>Cotizar todos aquellos requerimientos de los usuarios que coinciden con sus competencias.</li>
					<li>Seleccionar aquellos requerimientos que entienda convenientes.</li>
					<li>Contratar de una forma eficiente y transparente asegur&aacute;ndose el precio y servicio pactado.</li>
					<li>Rankear al usuario a los efectos de agregar valor a las cotizaciones de otras empresas registradas.</li>
				</ul>
				<p>Complete los campos del formulario.</p>
				<p><b>Su correo electr&oacute;nico ser&aacute; su ID de usuario con el cu&aacute;l podr&aacute; acceder a la aplicaci&oacute;n.</b></p>
				<p>Una vez registrado se le enviar&aacute; una contrase&ntilde;a generada autom&aacute;ticamente a su direcci&oacute;n de email.</p>
				<p>Usted tendr&aacute; 24 horas para validar sus datos.</p>
				<p>Una vez expirado ese per&iacute;odo deber&aacute; volver a registrarse.</p>
			</div>
			<hr>
			<a class="float-right btn btn-info btn-block btn-view-policy text-dark" role="button">Mostrar Pol&iacute;tica de Privacidad y T&eacute;rminos de Uso</a>
		</div>

		<!-- FORMULARIO REGISTRO USUARIOS -->
		<div class="col-md-6 col-xs-12">
			<form class="alert alert-light" id="frm-register" method="post">
				<input type="hidden" id="csrf_reg" name="<?=$csrf_reg['name'];?>" value="<?=$csrf_reg['hash'];?>" >
				<input type="hidden" fill-location name="phone_prefix">
				<input type="hidden" fill-location name="latitude">
				<input type="hidden" fill-location name="longitude">
				<input type="hidden" fill-location name="place_id">
				<input type="hidden" fill-location name="postal_code">
				<input type="hidden" fill-location name="locality">
				<input type="hidden" fill-location name="user_timezone" >
				<input type="hidden" fill-location name="user_tz_offset" >
				<input type="hidden" id="captcha-word" value="<?= $captcha['word']?>">

				<!-- SELECCION TIPO USUARIO -->
				<h5>Seleccione Tipo Usuario</h5>
				<div class="radio">
					<input type="radio" id="iamuser" checked="checked" name="user_role" value="user">
					<label for="iamuser" data-toggle="tooltip" data-placement="bottom" title="Seleccione esta opci&oacute;n si usted es un usuario que requiere servicios.">Soy Usuario</label>
				
					<input type="radio" id="iamcompany" name="user_role" value="assoc">
					<label for="iamcompany" data-toggle="tooltip" data-placement="bottom" title="Seleccione esta opci&oacute;n si usted es una empresa que ofrece servicios.">Soy Empresa</label>

					<p id="user-type" class="float-right text-danger" style="padding: 5px" data-user-type='<?=json_encode($userTypes)?>'><b><span>Usuario</span></b></p>
				</div>
				<br>
				<!-- SELECTOR DE PAISES -->
				<h5>Seleccione Pa&iacute;s</h5>
				<select class="selectpicker show-menu-arrow country" fill-location name="country" data-live-search="true" data-size="10" title="Seleccione Pa&iacute;s" data-width="75%" required data-message="<?=$this->lang->line('dtr-error-no-country')?>">
				<?php foreach($countries as $c):?>
					<option data-phone-prefix="<?=$c->phone?>" data-tokens="<?=$c->iso?>" value="<?=$c->iso?>"><?= $c->country?></option>
				<?php endforeach?>
				</select> 
				<!-- BOTON GEOLOCALIZACION -->
				<span class="float-right"><button class="btn btn-info btn-locateme" data-toggle="tooltip" data-placement="bottom" title="Geolocalizarme"><i class="fa fa-globe"></i></button></span>
				<br>
				<!-- INPUT DE NOMBRE EMPRESA -->
				<div class="md-form form-lg mb-4">
					<i class="fa fa-home prefix"></i>
					<input type="text" class="form-control" id="company_name" name="company_name">
					<label for="company_name">Empresa</label>
				</div>
				<br>
				<!-- INPUT ID DE USUARIO -->
				<div class="md-form form-lg mb-4">
					<i class="fa fa-envelope prefix"></i>
					<input type="email" class="form-control" id="user_name" name="user_name" required >
					<label for="user_name">Correo Electr&oacute;nico</label>
				</div>
				<br>
				<!-- INPUT TELEFONO DE USUARIO -->
				<div class="md-form form-lg mb-4">
					<i class="fa fa-phone prefix"></i>
					<input type="text" class="form-control" id="phone_number" name="phone_number" required data-as="number" data-checkLength data-message="<?=$this->lang->line('dtr-error-phone-length')?>">
					<label for="phone_number">Tel&eacute;fono</label>
				</div>
				<br>
				<!-- INPUT DIRECCION DE USUARIO -->
				<div class="md-form form-lg mb-4">
					<i class="fa fa-user prefix"></i>
					<input type="text" class="form-control autocomplete formatted_address" fill-location id="address" name="address" placeholder="Direcci&oacute;n" required data-checkAddress data-message="<?=$this->lang->line('dtr-error-address')?>">
					<label for="address">Direcci&oacute;n</label>
				</div>
				<hr>
				<!-- ACEPTACION POLITICAS -->
				<div class="checkbox">
					<input type="checkbox" id="chk-cookies-policy" required>
					<label for="chk-cookies-policy">
						Acepto Pol&iacute;tica de Privacidad y T&eacute;rminos de Uso
					</label>
				</div>
				<?php if($this->init->isMobile == 1):?>
					<a class="float-right btn btn-info btn-sm btn-block btn-view-policy text-dark" role="button">Mostrar Pol&iacute;tica de Privacidad y T&eacute;rminos de Uso</a>
				<?php endif?>
				<hr>
				<?php $this->load->view('captcha')?>
				<hr>
				<br>
				
				<!-- BOTON SUBMIT -->
				<button type="submit" class="btn btn-primary btn-lg btn-block" id="btn-register">Registrarse</button>
			</form>
		</div>
	</div>
</div>