<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina ubicacion usuarios (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : location-data.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
?>
<!-- SELECTOR DE PAISES -->
<h5>Seleccione Pa&iacute;s</h5>
<select class="selectpicker show-menu-arrow country" name="country" data-live-search="true" data-size="10" title="Seleccione Pa&iacute;s" data-width="75%" required data-message="<?=$this->lang->line('dtr-error-no-country')?>">
<?php foreach($countries as $c):?>
	<?php $selected = $c->iso === $user->country ? 'selected="selected"' : ''?>
	<option data-phone-prefix="<?=$c->phone?>" data-tokens="<?=$c->iso?>" value="<?=$c->iso?>" <?=$selected?>><?= $c->country?></option>
<?php endforeach?>
</select> 
<!-- BOTON GEOLOCALIZACION -->
<span class="float-right"><button class="btn btn-info" id="btn-locateme" data-toggle="tooltip" data-placement="bottom" title="Geolocalizarme"><i class="fa fa-globe"></i></button></span>
<br>
<hr>

<!-- INPUT DIRECCION DE USUARIO -->
<div class="md-form form-lg mb-4">
	<input type="text" class="form-control autocomplete w-100 text-primary" id="address" name="address" required data-checkAddress data-message="<?=$this->lang->line('dtr-error-address')?>" value="<?=$user->address?>">
	<label for="address">Direcci&oacute;n</label>
</div>

<br>
<div id="map" class="z-depth-1" style="max-height: 80%; height: 350px"></div>
<br>