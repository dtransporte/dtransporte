<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina resumen detalles de carga de autoelevadores solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements/resume
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : cargo-details-forklift.php
|--------------------------------------------------------------------------
|
*/
$forkliftType = $this->lang->line('dtr-forklift-type');
?>
<div class="alert alert-dark rounded">
	<h5>Detalles de Carga</h5>
	<div class="d-flex justify-content-start">
		<p class="mr-5">Unidades Requeridas: <span class="font-weight-bold"><?=$resume['cargo_units_qty']?></span></p>
		<p>Peso Estimado: <span class="font-weight-bold"><?=$resume['cargo_weight']?> KGS</span></p>
	</div>
	<p>Notas: <span class="font-weight-bold"><?=$resume['cargo_notes']?></span></p>

	<h5>Detalles de Equipo</h5>
	<div class="d-flex justify-content-start">
		<p class="mr-5">Tipo: <span class="font-weight-bold"><?=$forkliftType[$resume['cargo_forklift_type']]?> KGS</span></p>
		<p>Requiere Chofer?: <span class="font-weight-bold"><?=isset($resume['cargo_forklift_driver']) ? 'SI' : 'NO'?></span></p>
	</div>
</div>