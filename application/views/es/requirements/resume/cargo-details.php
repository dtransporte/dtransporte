<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina resumen detalles de carga solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements/resume
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : cargo-details.php
|--------------------------------------------------------------------------
|
*/
?>
<div class="alert alert-dark rounded">
	<h5>Detalles Carga</h5>
	<div class="d-flex justify-content-start">
		<?php if(isset($resume['cargo_units_qty'])):?>
			<p class="mr-5">Unidades Requeridas: <span class="font-weight-bold"><?= $resume['cargo_units_qty']?></span></p>
		<?php endif?>
		<p class="mr-5">Peso Estimado: <span class="font-weight-bold"><?= $resume['cargo_weight']?> KGS</span></p>
		<p>Volumen Estimado: <span class="font-weight-bold"><?= $resume['cargo_volume']?> M3</span></p>
	</div>
	<p>Notas: <span class="font-weight-bold"><?= $resume['cargo_notes']?></span></p>
</div>