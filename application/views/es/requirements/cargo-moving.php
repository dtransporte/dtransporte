<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina detalles de mudanza solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : cargo-moving.php
|--------------------------------------------------------------------------
|
*/
$movingData = $this->lang->line('dtr-moving');
?>
<div id="cargo-moving" class="alert alert-light">
	<div class="d-flex justify-content-start">
		<h5 class="m-3">Que desea mudar?</h5> 
		<select class="selectpicker show-menu-arrow" name="cargo_moving_type" data-width="auto">
			<?php foreach($movingData as $k=>$m):?>
				<option value="<?=$k?>" ><?= $m?></option>
			<?php endforeach?>
		</select>
	</div>
	<br>
	<h5><i class="fas fa-pencil-alt"></i> Notas</h5>
	<p><i>Agregue observaciones que permitan una mejor identificaci&oacute;n de su mudanza. M&aacute;x 100 caracteres.</i></p>
	<div class="md-form form-lg mb-4">
		<i class="fas fa-pencil-alt prefix"></i>
		<textarea class="form-control md-textarea" id="cargo_notes" name="cargo_notes" maxlength="100"></textarea>
	</div>
</div>