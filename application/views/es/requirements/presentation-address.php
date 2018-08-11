<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina direccion presentacion solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : presentation-address.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
$showOrigin = (isset($requirementsViews['attributes']['views']['show-origin']) AND $requirementsViews['attributes']['views']['show-origin'] == 1) ? 1 : 0;
?>
<div id="presentation-address" class="z-depth-1 alert alert-light">
	<input type="hidden" fill-location name="phone_prefix" value="<?=$user->phone_prefix?>">
	<input type="hidden" fill-location name="latitude" value="<?=$user->latitude?>">
	<input type="hidden" fill-location name="longitude" value="<?=$user->longitude?>">
	<input type="hidden" fill-location name="place_id" value="<?=$user->place_id?>" required>
	<input type="hidden" fill-location name="postal_code" value="<?=$user->postal_code?>">
	<input type="hidden" fill-location name="locality" value="<?=$user->locality?>">
	<input type="hidden" fill-location name="user_timezone" value="<?=$user->user_timezone?>">
	<input type="hidden" fill-location name="user_tz_offset" value="<?=$user->user_tz_offset?>">

	<h4><i class="fas fa-home"></i> Direcci&oacute;n de Presentaci&oacute;n</h4>
	<!-- SELECTOR DE PAISES -->
	<h5>Seleccione Pa&iacute;s</h5>
	<div class="btn-toolbar justify-content-between" role="toolbar">
		<select class="selectpicker show-menu-arrow country" fill-location name="country" data-live-search="true" data-size="10" title="Seleccione Pa&iacute;s" data-width="75%" required data-message="<?=$this->lang->line('dtr-error-no-country')?>">
		<?php foreach($countries as $c):?>
			<?php $selected = $c->iso === $user->country ? 'selected="selected"' : ''?>
			<option data-phone-prefix="<?=$c->phone?>" data-tokens="<?=$c->iso?>" value="<?=$c->iso?>" <?=$selected?>><?= $c->country?></option>
		<?php endforeach?>
		</select> 
	
		<div class="btn-group mr-2 mt-1 rounded" role="group">
			<!-- BOTON GEOLOCALIZACION -->
			<span><button class="btn btn-light z-depth-0 btn-locateme" data-toggle="tooltip" data-placement="bottom" title="Geolocalizarme"><i class="fa fa-globe"></i></button></span>

			<!-- BOTON RESTAURAR DIRECCION -->
			<span><button class="btn btn-light z-depth-0 btn-restore-address" data-toggle="tooltip" data-placement="bottom" title="Restaurar Direcci&oacute;n"><i class="fas fa-sync-alt"></i></button></span>

			<?php if($showOrigin === 1):?>
				<span><button class="btn btn-light z-depth-0 btn-show-address" data-toggle="tooltip" data-placement="bottom" title="Mostrar Direcci&oacute;n"><i class="fas fa-home"></i></button></span>
			<?php endif?>

			<!-- BOTON USAR DIRECCION -->
			<span><button class="btn btn-light z-depth-0 btn-use-address" data-toggle="tooltip" data-placement="bottom" title="Usar Direcci&oacute;n"><i class="fas fa-location-arrow"></i></button></span>
		</div>
	</div>
	<br>

	<!-- INPUT DIRECCION DE USUARIO -->
	<fieldset><legend><i class="fas fa-map-marker-alt"></i> <u>Direcci&oacute;n</u></legend>
		<p class="font-italic"><small><i class="fas fa-info-circle"></i> Seleccione la direcci&oacute;n del listado que se despliega al escribir la misma.</small></p>
		<div class="md-form form-lg mb-4">
			<input type="text" class="form-control autocomplete w-100 text-primary" fill-location id="address" name="address" required data-checkAddress data-message="<?=$this->lang->line('dtr-error-address')?>" value="<?=$user->address?>">
		</div>
		<br>
	</fieldset>
	<fieldset><legend><i class="fas fa-pencil-alt"></i> <u>Notas</u></legend>
		<p><i>Agregue observaciones que permitan una mejor identificaci&oacute;n de su direcci&oacute;n. M&aacute;x 100 caracteres.</i></p>
		<div class="md-form form-lg mb-4">
			<i class="fas fa-pencil-alt prefix"></i>
			<textarea class="form-control md-textarea" name="address_notes" maxlength="100"></textarea>
		</div>
	</fieldset>
</div>