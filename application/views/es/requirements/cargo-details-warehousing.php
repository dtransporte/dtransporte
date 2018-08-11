<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina detalles de carga almacenamiento usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : cargo-details-warehousing.php
|--------------------------------------------------------------------------
|
*/
?>
<div id="cargo-details-warehousing" class="alert alert-light">
	<div class="row">
		<div class="col-md-4">
			<p><i class="fas fa-balance-scale"></i> Peso Estimado (KGS)</p>
			<div class="md-form mb-4">
				<input type="number" class="form-control w-100 text-primary" name="cargo_weight" id="cargo_weight" value="1" min="1">
			</div>
		</div>
		<div class="col-md-4">
			<p><i class="fas fa-box"></i> Superficie Estimada (M2)</p>
			<div class="md-form mb-4">
				<input type="number" class="form-control w-100 text-primary" name="cargo_m2" id="cargo_m2" min="1" value="1">
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

	<div class="checkbox">
		<input type="checkbox" id="cargo_frozen_chain" name="cargo_frozen_chain" value="0">
		<label for="cargo_frozen_chain">Requiere Cadena Fr&iacute;o</label>

		<input type="checkbox" id="hazard-products" name="cargo_hazard_product" value="0">
		<label for="hazard-products">Mercader&iacute;a Peligrosa</label>
	</div>

	<div id="hazard-prods" class="d-none">
		<?php $this->load->view('es/requirements/cargo-details-hazard')?>
	</div>
</div>