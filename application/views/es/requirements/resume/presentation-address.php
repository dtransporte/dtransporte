<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina resumen direccion presentacion solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements/resume
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : presentation-address.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
?>
<div class="alert alert-dark rounded">
	<h5>Direcci&oacute;n de Presentaci&oacute;n</h5>

	<p>Pa&iacute;s: <span class="font-weight-bold"><?= $resume['country']->country?></span></p>
	<p>Direcci&oacute;n: <span class="font-weight-bold"><?= $resume['address']?></span></p>
	<p>Notas: <span class="font-weight-bold"><?= $resume['address_notes']?></span></p>
</div>
