<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina resumen detalles de mudanza solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements/resume
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : cargo-moving.php
|--------------------------------------------------------------------------
|
*/
$movingData = $this->lang->line('dtr-moving');
?>
<div class="alert alert-dark rounded">
	<h5>Detalles Mudanza</h5>
	<p>Tipo Mudanza: <span class="font-weight-bold"><?= $movingData[$resume['cargo_moving_type']]?></span></p>
	<p>Notas: <span class="font-weight-bold"><?= $resume['cargo_notes']?></span></p>
</div>