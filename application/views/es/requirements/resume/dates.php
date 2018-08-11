<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina fechas resumen solicitud (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements/resume
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : dates.php
|--------------------------------------------------------------------------
|
*/
$dtf = str_replace(':%s', '', $this->init->activeUser->dtf);
$expiration = (int) str_replace(['-', ' ', ':'], '', $resume['requirement_expiration'].':00');
$schedule = (int) str_replace(['-', ' ', ':'], '', $resume['requirement_schedule'].':00');
$scheduleLabel = ($product->id_product == 9 OR $product->id_product == 10 OR $product->id_product == 16) ? 'ETD / ETA' : 'Fecha Presentaci&oacute;n';
?>
<div class="alert alert-dark rounded">
	<div class="d-flex justify-content-between">
		<h5>Fecha de Expiraci&oacute;n: <span class="font-weight-bold"><?= mdate($dtf, mysql_to_unix($expiration))?></span></h5>
		<h5><?= $scheduleLabel ?>: <span class="font-weight-bold"><?= mdate($dtf, mysql_to_unix($schedule))?></span></h5>
	</div>
</div>