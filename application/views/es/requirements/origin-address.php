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
| Nombre : origin-address.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
$showOrigin = (isset($requirementsViews['attributes']['views']['show-origin']) AND $requirementsViews['attributes']['views']['show-origin'] == 1) ? 1 : 0;
$showRoute = (isset($requirementsViews['attributes']['views']['show-route']) AND $requirementsViews['attributes']['views']['show-route'] == 1) ? 1 : 0;
$showWp = (isset($requirementsViews['attributes']['views']['show-waypoints']) AND $requirementsViews['attributes']['views']['show-waypoints'] == 1) ? 1 : 0;
?>
<div id="origin-address" class="float-md-left alert w-50">
	<input type="hidden" fill-location name="o-phone_prefix" value="<?=$user->phone_prefix?>">
	<input type="hidden" fill-location name="o-latitude" value="<?=$user->latitude?>">
	<input type="hidden" fill-location name="o-longitude" value="<?=$user->longitude?>">
	<input type="hidden" fill-location name="o-place_id" value="<?=$user->place_id?>" required>
	<input type="hidden" fill-location name="o-postal_code" value="<?=$user->postal_code?>">
	<input type="hidden" fill-location name="o-locality" value="<?=$user->locality?>">
	<input type="hidden" fill-location name="o-user_timezone" value="<?=$user->user_timezone?>">
	<input type="hidden" fill-location name="o-user_tz_offset" value="<?=$user->user_tz_offset?>">

	<h4><i class="fas fa-map-marker"></i> Direcci&oacute;n de Origen</h4>
	<div class="btn-toolbar justify-content-between" role="toolbar">
		<div class="btn-group mr-2 mb-3 rounded" role="group">
			<!-- BOTON GEOLOCALIZACION -->
			<button class="btn btn-light btn-locateme z-depth-0" data-toggle="tooltip" data-placement="bottom" title="Geolocalizarme"><i class="fa fa-globe"></i></button>

			<!-- BOTON RESTAURAR DIRECCION -->
			<button class="btn btn-light btn-restore-address z-depth-0" data-toggle="tooltip" data-placement="bottom" title="Restaurar Direcci&oacute;n"><i class="fas fa-sync-alt"></i></button>

			<!-- BOTON USAR DIRECCION -->
			<button class="btn btn-light btn-use-address z-depth-0" data-toggle="tooltip" data-placement="bottom" title="Usar Direcci&oacute;n"><i class="fas fa-location-arrow"></i></button>

			<?php if($showOrigin == 1):?>
				<!-- BOTON MOSTRAR DIRECCION -->
				<button class="btn btn-light btn-show-address z-depth-0" data-toggle="tooltip" data-placement="bottom" title="Mostrar Direcci&oacute;n"><i class="fas fa-home"></i></button>
			<?php endif?>

		</div>

		<div class="btn-group mr-2 mb-3 rounded" role="group">
			<div class="btn-group mr-2 mb-3" role="group">
				<?php if($showRoute == 1):?>
					<!-- BOTON MOSTRAR RUTA -->
					<button class="btn btn-sm btn-secondary btn-show-route" data-toggle="tooltip" data-placement="bottom" title="Mostrar Ruta"><i class="fas fa-road"></i></button>
				<?php endif?>
			</div>
			<div class="btn-group mr-2 mb-3" role="group">
				<?php if($showWp == 1):?>
					<!-- BOTON PARADAS INTERMEDIAS -->
					<a role="button" class="btn btn-default btn-sm" href="#waypoints-address" data-toggle="tooltip" data-placement="bottom" title="Paradas Intermedias"><i class="far fa-hand-paper"></i></a>
				<?php endif?>
			</div>
		</div>
	</div>

	<!-- SELECTOR DE PAISES -->
	<div class="form-group">
		<h5><u>Pa&iacute;s</u></h5>
		<select class="selectpicker show-menu-arrow country" fill-location name="o-country" data-live-search="true" data-size="10" title="Seleccione Pa&iacute;s" data-width="100%" required data-message="<?=$this->lang->line('dtr-error-no-country')?>">
		<?php foreach($countries as $c):?>
			<?php $selected = $c->iso === $user->country ? 'selected="selected"' : ''?>
			<option data-phone-prefix="<?=$c->phone?>" data-tokens="<?=$c->iso?>" value="<?=$c->iso?>" <?=$selected?>><?= $c->country?></option>
		<?php endforeach?>
		</select> 
	</div>

	<!-- INPUT DIRECCION DE USUARIO -->
	<fieldset><legend><u>Direcci&oacute;n</u></legend>
		<p class="font-italic"><small><i class="fas fa-info-circle"></i> Seleccione la direcci&oacute;n del listado que se despliega al escribir la misma.</small></p>
		<div class="form-group">
			<div class="md-form form-lg mb-4">
				<input type="text" class="form-control autocomplete w-100 text-primary" fill-location id="o-address" name="o-address" required data-checkAddress data-message="<?=$this->lang->line('dtr-error-address')?>" value="<?=$user->address?>">
			</div>
		</div>
	</fieldset>
	<br>
	<fieldset><legend><u>Notas</u></legend>
		<p><i>Agregue observaciones que permitan una mejor identificaci&oacute;n de su direcci&oacute;n. M&aacute;x 100 caracteres.</i></p>
		<div class="md-form form-lg mb-4 shadow-textarea">
			<i class="fas fa-pencil-alt prefix"></i>
			<textarea class="form-control md-textarea" name="o-address_notes" maxlength="100"></textarea>
		</div>
	</fieldset>
</div>