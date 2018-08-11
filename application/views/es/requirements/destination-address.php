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
| Nombre : destination-address.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
$showOrigin = (isset($requirementsViews['attributes']['views']['show-destination']) AND $requirementsViews['attributes']['views']['show-destination'] == 1) ? 1 : 0;
$mirrorAddress = $requirementsViews['attributes']['views']['mirror-address'] == 1 ? 1 : 0;
?>
<div id="destination-address" class="float-md-left alert w-50">
	<input type="hidden" id="mirror-address" value="<?=$mirrorAddress?>">
	<input type="hidden" fill-location name="d-phone_prefix">
	<input type="hidden" fill-location name="d-latitude">
	<input type="hidden" fill-location name="d-longitude">
	<input type="hidden" fill-location name="d-place_id" required>
	<input type="hidden" fill-location name="d-postal_code">
	<input type="hidden" fill-location name="d-locality">
	<input type="hidden" fill-location name="d-user_timezone">
	<input type="hidden" fill-location name="d-user_tz_offset">

	<h4><i class="fas fa-map-marker"></i> Direcci&oacute;n de Destino</h4>
	<div class="btn-toolbar" role="toolbar">
		<div class="btn-group mr-2 mb-3 rounded" role="group">
			<?php if($mirrorAddress === 0):?>
				<!-- BOTON GEOLOCALIZACION -->
				<button class="btn btn-light btn-locateme z-depth-0" data-toggle="tooltip" data-placement="bottom" title="Geolocalizarme"><i class="fa fa-globe"></i></button>

				<!-- BOTON RESTAURAR DIRECCION -->
				<button class="btn btn-light btn-restore-address z-depth-0" data-toggle="tooltip" data-placement="bottom" title="Restaurar Direcci&oacute;n"><i class="fas fa-sync-alt"></i></button>

				<!-- BOTON USAR DIRECCION -->
				<button class="btn btn-light btn-use-address z-depth-0" data-toggle="tooltip" data-placement="bottom" title="Usar Direcci&oacute;n"><i class="fas fa-location-arrow"></i></button>
			<?php endif?>

			<?php if($showOrigin === 1):?>
				<!-- BOTON MOSTRAR DIRECCION -->
				<button class="btn btn-light btn-show-address z-depth-0" data-toggle="tooltip" data-placement="bottom" title="Mostrar Direcci&oacute;n"><i class="fas fa-home"></i></button>
			<?php endif?>

		</div>
	</div>
	
	<?php if($mirrorAddress === 0):?>
		<!-- SELECTOR DE PAISES -->
		<div class="form-group">
			<h5><u>Pa&iacute;s</u></h5>
			<select class="selectpicker show-menu-arrow country" fill-location name="d-country" data-live-search="true" data-size="10" title="Seleccione Pa&iacute;s" data-width="100%" required data-message="<?=$this->lang->line('dtr-error-no-country')?>">
			<?php foreach($countries as $c):?>
				<?php $selected = $c->iso === $user->country ? 'selected="selected"' : ''?>
				<option data-phone-prefix="<?=$c->phone?>" data-tokens="<?=$c->iso?>" value="<?=$c->iso?>" <?=$selected?>><?= $c->country?></option>
			<?php endforeach?>
			</select>
		</div>
	<?php else:?>
		<input type="hidden" name="d-country" value="<?=$user->country?>">
		<h5>Pa&iacute;s Destino</h5>
		<br>
		<h5 id="d-country"><?=$myCountry->country?></h5>
		<br>
	<?php endif?>

	<!-- INPUT DIRECCION DE USUARIO -->
	<fieldset><legend><u>Direcci&oacute;n</u></legend>
		<p class="font-italic"><small><i class="fas fa-info-circle"></i> Seleccione la direcci&oacute;n del listado que se despliega al escribir la misma.</small></p>
		<div class="form-group">
			<div class="md-form form-lg mb-4">
				<input type="text" class="form-control autocomplete w-100 text-primary" fill-location id="d-address" name="d-address" required data-checkAddress data-message="<?=$this->lang->line('dtr-error-address')?>">
			</div>
		</div>
	</fieldset>
	<br>
	<fieldset><legend><u>Notas</u></legend>
		<p><i>Agregue observaciones que permitan una mejor identificaci&oacute;n de su direcci&oacute;n. M&aacute;x 100 caracteres.</i></p>
		<div class="md-form form-lg mb-4">
			<i class="fas fa-pencil-alt prefix"></i>
			<textarea class="form-control md-textarea" name="d-address_notes" maxlength="100"></textarea>
		</div>
	</fieldset>
</div>