<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina publica home (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : first-time-user-home.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);
?>
<div class="container-fluid" id="container">
	<h3 class="text-center alert alert-info">
		Bienvenid@ a dTransporte
	</h3>
	<div class="text-center">
		<!-- BOTON INICIO SESION -->
		<button type="button" class="btn btn-lg btn-default btn-block rounded" id="btn-start-sesion">
			<h4><i class="fas fa-universal-access"></i> Iniciar Sesi&oacute;n en dTransporte</h4>
		</button>
	</div>
	<br>
	<!-- PESTANIAS -->
	<div id="first-tabs" class="ui-tabs-vertical ui-helper-clearfix">
		<ul>
			<li class="text-center" data-toggle="tooltip" data-placement="right" title="Inicio">
				<a href="#user-welcome"><h1 class="fas fa-bell display-4 fa-fw"></h1></a><br>
				<span class="text-center float-left w-100">Inicio</span>
			</li>
			<li class="text-center" data-toggle="tooltip" data-placement="right" title="Datos Personales">
				<a href="#user-data"><h1 class="fas fa-id-card display-4 fa-fw"></h1></a><br>
				<span class="text-center float-left w-100">Personal</span>
			</li>
			<li class="text-center" data-toggle="tooltip" data-placement="right" title="Ubicaci&oacute;n">
				<a href="#user-address"><h1 class="fas fa-globe display-4 fa-fw"></h1></a>
				<br>
				<span class="text-center float-left w-100">Ubicaci&oacute;n</span>
			</li>
			<li class="text-center">
				<a href="#user-password" data-toggle="tooltip" data-placement="right" title="Cambiar Contrase&ntilde;a"><h1 class="fas fa-key display-4 fa-fw"></h1></a><br>
				<span class="text-center float-left w-100">Contrase&ntilde;a</span>
			</li>
			<li class="text-center">
				<a href="#user-image" data-toggle="tooltip" data-placement="right" title="Cambiar Im&aacute;gen"><h1 class="far fa-image display-4 fa-fw"></h1></a><br>
				<span class="text-center float-left w-100">Im&aacute;gen</span>
			</li>
			<li class="text-center">
				<a href="#user-settings" data-toggle="tooltip" data-placement="right" title="Opciones"><h1 class="fas fa-users-cog display-4 fa-fw"></h1></a><br>
				<span class="text-center float-left w-100">Opciones</span>
			</li>
		</ul>

		<!-- PANELES -->
		<div id="user-welcome">
			<div class="alert alert-info">
				<h2><i class="fas fa-bell"></i> Inicio</h2>
				<hr class="bg-dark dtr">
				<ul>
					<li>
						<h4>Por favor complete todos los campos de los formularios a los efectos de iniciar sesi&oacute;n en dTransporte.</h4>
					</li>
					<li>
						<h4>Aunque no es obligatorio, lo instamos a cambiar su contrase&ntilde;a.</h4>
					</li>
					<li>
						<h4>Una vez completados los datos requeridos haga click en el bot&oacute;n <u>Iniciar sesi&oacute;n en dTransporte</u> <i class="fas fa-arrow-alt-circle-up"></i>.</h4>
					</li>
				</ul>
			</div>
		</div>

		<div id="user-data">
			<div class="alert alert-light">
				<h2><i class="fas fa-user"></i> Datos Personales</h2>
				<hr class="bg-dark dtr">
				<form id="frm-personal-data" method="post">
					<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" >
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<?php $this->load->view('es/users/personal-data')?>
						</div>
						<div class="col-md-6 col-sm-12">
							<?php $this->load->view('es/users/company-data')?>
						</div>
					</div>
					<button type="submit" class="btn btn-primary btn-block" id="btn-save-personal-data">Actualizar</button>
				</form>
			</div>
		</div>

		<div id="user-address">
			<div class="alert alert-light">
				<h2><i class="fas fa-globe"></i> Datos de Ubicaci&oacute;n</h2>
				<hr class="bg-dark dtr">
				<form id="frm-location-data" method="post" action="#">
					<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" >
					<input type="hidden" fill-location name="phone_prefix" value="<?=$user->phone_prefix?>">
					<input type="hidden" fill-location name="latitude" value="<?=$user->latitude?>">
					<input type="hidden" fill-location name="longitude" value="<?=$user->longitude?>">
					<input type="hidden" fill-location name="place_id" value="<?=$user->place_id?>" required>
					<input type="hidden" fill-location name="postal_code" value="<?=$user->postal_code?>">
					<input type="hidden" fill-location name="locality" value="<?=$user->locality?>">
					<input type="hidden" fill-location name="user_timezone" value="<?=$user->user_timezone?>">
					<input type="hidden" fill-location name="user_tz_offset" value="<?=$user->user_tz_offset?>">
					<?php $this->load->view('es/users/location-data')?>
					<button type="submit" class="btn btn-primary btn-block" id="btn-save-location-data">Actualizar</button>
				</form>
			</div>
		</div>

		<div id="user-password">
			<div class="alert alert-light">
				<h2><i class="fas fa-key"></i> Cambiar Contrase&ntilde;a</h2>
				<hr class="bg-dark dtr">
				<form id="frm-change-pwd" method="post">
					<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" >
					<?php $this->load->view('es/users/change-pwd')?>
					<button type="submit" class="btn btn-primary btn-block" id="btn-save-password">Actualizar</button>
				</form>
			</div>
		</div>
		
		<div id="user-image">
			<div class="alert alert-light">
				<h2><i class="far fa-image"></i> Im&aacute;gen de Usuario</h2>
				<hr class="bg-dark dtr">
				<p>Suba su im&aacute;gen o el logo de su empresa.</p>
				<div id="uploader" data-img-config='<?=json_encode($imgCfg)?>'>
					<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
				</div>
			</div>
		</div>

		<div id="user-settings">
			<div class="alert alert-light">
				<h2><i class="fas fa-cogs"></i> Opciones</h2>
				<hr class="bg-dark dtr">
				<form id="frm-user-settings" method="post">
					<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" >
					<?php $this->load->view('es/users/settings-data')?>
					<br>
					<button type="submit" class="btn btn-primary btn-block" id="btn-save-settings">Actualizar</button>
				</form>
			</div>
		</div>

	</div>
</div>