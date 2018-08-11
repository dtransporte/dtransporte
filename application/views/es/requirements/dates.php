<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina home fechas solicitud (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : dates.php
|--------------------------------------------------------------------------
|
*/
$scheduleLabel = ($product->id_product == 9 OR $product->id_product == 10 OR $product->id_product == 16) ? 'ETD / ETA' : 'Fecha Presentaci&oacute;n';
$scheduleInfo = ($product->id_product == 9 OR $product->id_product == 10 OR $product->id_product == 16) ? 'Ingrese fechas de partida o arribo.' : 'Ingrese la fecha y hora en la que el servicio debe presentarse en la direcci&oacute;n por usted indicada';
?>
<div class="container-fluid" id="requirement-dates">
	<input type="hidden" name="requirement_expiration" id="requirement_expiration">
	<input type="hidden" name="requirement_schedule" id="requirement_schedule">
	<div class="row">
		<div class="col-sm-6">
			<div class="md-form form-lg">
				<input type="text" class="form-control" id="expiration_date">
				<label for="expiration_date">Fecha Expiraci&oacute;n</label>
			</div>
			<p class="font-italic"><small><i class="fas fa-info-circle"></i> Ingrese la fecha y hora de expiraci&oacute;n de solicitud. Pasada la misma ya no recibir&aacute; cotizaciones de las empresas registradas.</small></p>
		</div>

		<div class="col-sm-6">
			<div class="md-form form-lg">
				<input type="text" class="form-control" id="schedule_date">
				<label for="schedule_date"><?= $scheduleLabel ?></label>
			</div>
			<p class="font-italic"><small><i class="fas fa-info-circle"></i> <?= $scheduleInfo ?>.</small></p>
		</div>
	</div>
</div>