<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina detalles de carga de autoelevadores solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : cargo-details-forklift.php
|--------------------------------------------------------------------------
|
*/
$forkliftType = $this->lang->line('dtr-forklift-type');
?>
<div id="cargo-details-forklift" class="alert alert-light">
	<div class="row">
		<div class="col-md-4">
			<p><i class="fas fa-truck-moving"></i> Unidades Requeridas</p>
			<div class="md-form mb-4">
				<input type="number" class="form-control w-100 text-primary" name="cargo_units_qty" id="cargo_units_qty" min="1" value="1">
			</div>
		</div>
		<div class="col-md-4">
			<p><i class="fas fa-balance-scale"></i> Peso Estimado (KGS)</p>
			<div class="md-form mb-4">
				<input type="number" class="form-control w-100 text-primary" name="cargo_weight" id="cargo_weight" value="1" min="1">
			</div>
		</div>
	</div>

	<br>
	<h5><i class="fas fa-pencil-alt"></i> Notas</h5>
	<p><i>Agregue observaciones que permitan una mejor identificaci&oacute;n de su carga. M&aacute;x 100 caracteres.</i></p>
	<div class="md-form form-lg mb-4">
		<i class="fas fa-pencil-alt prefix"></i>
		<textarea class="form-control md-textarea" id="cargo_notes" name="cargo_notes" maxlength="100"></textarea>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<h5>Tipo Autoelevador</h5>
				<select class="selectpicker show-menu-arrow" name="cargo_forklift_type" data-width="100%">
				<?php foreach($forkliftType as $k=>$f):?>
					<option value="<?=$k?>" ><?= $f?></option>
				<?php endforeach?>
				</select>
			</div>
			<div class="checkbox">
				<input type="checkbox" id="cargo_forklift_driver" name="cargo_forklift_driver">
				<label for="cargo_forklift_driver">Requiere Chofer?</label>
			</div>
		</div>
		<div class="col-md-8">
			
		</div>
	</div>
</div>