<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina detalles de carga solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : cargo-details.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
$isFCL = 0;
// if(
// 	(isset($requirementsViews['attributes']['views']['show-containers']) AND $requirementsViews['attributes']['views']['show-containers'] == 1))
// {
// 	$isFCL = 1;
// }
$isFCL = (
	(!isset($requirementsViews['attributes']['views']['fcl']) AND !isset($requirementsViews['attributes']['views']['lcl']))
	 OR 
	 (isset($requirementsViews['attributes']['views']['fcl']) AND $requirementsViews['attributes']['views']['fcl'] == 1)
	) ? 1 : 0;
?>
<div id="cargo-details" class="alert alert-light">
	<div class="row">
		<?php if($isFCL === 1):?>
		<div class="col-md-4">
			<p><i class="fas fa-sort-numeric-up"></i> Unidades Requeridas</p>
			<div class="md-form mb-4">
				<input type="number" class="form-control w-100 text-primary" name="cargo_units_qty" id="cargo_units_qty" min="1" value="1">
			</div>
		</div>
		<?php endif?>
		<div class="col-md-4">
			<p><i class="fas fa-balance-scale"></i> Peso Estimado (KGS)</p>
			<div class="md-form mb-4">
				<input type="number" class="form-control w-100 text-primary" name="cargo_weight" id="cargo_weight" value="1" min="1">
			</div>
		</div>

		<div class="col-md-4">
			<p><i class="fas fa-boxes"></i> Volumen Estimado (M3)</p>
			<div class="md-form mb-4">
				<input type="number" class="form-control w-100 text-primary" name="cargo_volume" id="cargo_volume" value="1" min="1" step="0.25">
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
</div>