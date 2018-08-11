<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina resumen terminos de pago solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements/resume
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : pay-terms.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
?>
<div class="alert alert-dark rounded">
	<h5>T&eacute;rminos de Pago</h5>
	<p>Moneda: <span class="font-weight-bold"><?= $currencies[$resume['requirement_currency']]['currencyname']?> -- <?= $currencies[$resume['requirement_currency']]['currencycode']?></span></p>
	<p>Forma de Pago: <span class="font-weight-bold"><?= !empty(trim($resume['requirement_pay_terms'])) ? $resume['requirement_pay_terms'] : 'Contado'?></span></p>
</div>