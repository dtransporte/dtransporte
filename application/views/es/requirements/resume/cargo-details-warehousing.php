<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina resumen detalles de carga almacenamiento usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements.resume
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : cargo-details-warehousing.php
|--------------------------------------------------------------------------
|
*/
?>
<div class="alert alert-dark rounded">
	<h5>Detalles de Mercader&iacute;a</h5>
	<div class="d-flex justify-content-start">
		<p class="mr-5">Peso Estimado: <span class="font-weight-bold"><?= $resume['cargo_weight']?> KGS</span></p>
		<p class="mr-5">Superficie Estimada: <span class="font-weight-bold"><?= $resume['cargo_m2']?> M2</span></p>
		<p class="mr-5">Volumen Estimado: <span class="font-weight-bold"><?= $resume['cargo_volume']?> M3</span></p>
	</div>
	<p>Notas: <span class="font-weight-bold"><?= $resume['cargo_notes']?></span></p>

	<h5>Especificaciones</h5>
	<p>Requiere Cadena Fr&iacute;o: <span class="font-weight-bold"><?= (isset($resume['cargo_frozen_chain']) AND $resume['cargo_frozen_chain'] == 1) ? 'SI' : 'NO'?></span></p>
	<p>Mercader&iacute;a Peligrosa: <span class="font-weight-bold"><?= (isset($resume['cargo_hazard_product']) AND $resume['cargo_hazard_product'] == 1) ? 'SI' : 'NO'?></span></p>

	<?php if(isset($resume['cargo_hazard_product']) AND $resume['cargo_hazard_product'] == 1):?>
		<?php $this->load->view('es/requirements/resume/cargo-details-hazard')?>
	<?php endif?>
</div>
