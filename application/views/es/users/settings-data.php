<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina opciones de usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/users
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : settings-data.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
?>
<div class="row">
	<!-- SELECTOR DE IDIOMAS -->
	<div class="col-md-6">
		<fieldset><legend>Idiomas</legend>
			<select class="selectpicker show-menu-arrow w-100" name="user_lang" data-size="10" title="Seleccione Idioma">
			<?php foreach($languages as $k=>$lang):?>
				<?php $selected = $k === $user->user_lang ? 'selected="selected"' : ''?>
				<option data-tokens="<?=$k?>" value="<?=$k?>" <?=$selected?>><?= $lang?></option>
			<?php endforeach?>
			</select> 
		</fieldset>
	</div>

	<!-- SELECTOR DE MONEDA -->
	<div class="col-md-6">
		<fieldset><legend>Moneda</legend>
			<select class="selectpicker show-menu-arrow w-100" name="user_currrency" data-size="10" title="Seleccione Moneda">
			<?php foreach($currencies as $k=>$cur):?>
				<?php $selected = $k === $user->user_currrency ? 'selected="selected"' : ''?>
				<option data-tokens="<?=$k?>" value="<?=$k?>" <?=$selected?>><?= $cur['currencyname']?> -- <?= $cur['currencycode']?></option>
			<?php endforeach?>
			</select> 
		</fieldset>
	</div>
</div>
<br>

<div class="row">
	<!-- SELECTOR DE FORMATOS DE FECHA -->
	<div class="col-md-6">
		<fieldset><legend>Formato de Fecha</legend>
			<select class="selectpicker show-menu-arrow w-100" name="user_dformat" data-size="10" title="Formato de Fecha">
			<?php foreach($dateFormat as $k=>$date):?>
				<?php $selected = $k === $user->user_dformat ? 'selected="selected"' : ''?>
				<option data-tokens="<?=$k?>" value="<?=$k?>" <?=$selected?>><?= $date?></option>
			<?php endforeach?>
			</select> 
		</fieldset>
	</div>

	<!-- SELECTOR DE FORMATOS DE HORA -->
	<div class="col-md-6">
		<fieldset><legend>Formato de Hora</legend>
			<select class="selectpicker show-menu-arrow w-100" name="user_tformat" data-size="10" title="Formato de Hora">
			<?php foreach($timeFormat as $k=>$time):?>
				<?php $selected = $k === $user->user_tformat ? 'selected="selected"' : ''?>
				<option data-tokens="<?=$k?>" value="<?=$k?>" <?=$selected?>><?= $time?></option>
			<?php endforeach?>
			</select> 
		</fieldset>
	</div>
</div>
<br>

<div class="row">
	<!-- SELECTOR DE FUENTES -->
	<div class="col-md-6">
		<fieldset><legend>Tipo Fuente</legend>
			<select class="selectpicker show-menu-arrow w-100" name="user_font_family" data-size="10" title="Tipo Fuente">
			<?php foreach($fontFamily as $font):?>
				<?php $selected = $font === $user->user_font_family ? 'selected="selected"' : ''?>
				<option data-tokens="<?=$font?>" value="<?=$font?>" <?=$selected?>><?= $font?></option>
			<?php endforeach?>
			</select> 
		</fieldset>
	</div>

	<!-- SELECTOR DE TAMANIO DE FUENTE -->
	<div class="col-md-6">
		<fieldset><legend>Tama&ntilde;o Fuente</legend>
			<select class="selectpicker show-menu-arrow w-100" name="user_font_size" data-size="10" title="Tama&ntilde;o Fuente">
			<?php foreach($fontSize as $size):?>
				<?php $selected = $size === $user->user_font_size ? 'selected="selected"' : ''?>
				<option data-tokens="<?=$size?>" value="<?=$size?>" <?=$selected?>><?= $size?></option>
			<?php endforeach?>
			</select> 
		</fieldset>
	</div>
</div>
<br>

<div class="row">
	<!-- ESTILO DE MENU -->
	<div class="col-md-6">
		<fieldset><legend>Estilo Menu</legend>
			<select class="selectpicker show-menu-arrow w-100" name="user_menu_style" data-size="10" title="Estilo Menu">
			<?php foreach($menuStyle as $k => $menu):?>
				<?php $selected = $k === $user->user_menu_style ? 'selected="selected"' : ''?>
				<option data-tokens="<?=$k?>" value="<?=$k?>" <?=$selected?>><?= $menu?></option>
			<?php endforeach?>
			</select> 
		</fieldset>
	</div>

	<!-- SELECTOR DE DURACION DE BLOQUEO PANTALLA -->
	<div class="col-md-6">
		<fieldset><legend>Bloqueo de Pantalla</legend>
			<select class="selectpicker show-menu-arrow w-100" name="user_block_scr_duration" data-size="10" title="Bloqueo de Pantalla">
			<?php foreach($blockScrDuration as $duration):?>
				<?php $selected = $duration === $user->user_block_scr_duration ? 'selected="selected"' : ''?>
				<option data-tokens="<?=$duration?>" value="<?=$duration?>" <?=$selected?>><?= $duration?></option>
			<?php endforeach?>
			</select> 
		</fieldset>
	</div>
</div>
