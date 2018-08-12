<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina resumen direccion destino solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements/resume
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : destination-address.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
?>
<!-- EL DIV COMIENZA EN EL ARCHIVO application/views/public/es/requirements/resume/origin-address.php -->
	<div class="alert">
		<h5>Direcci&oacute;n de Destino</h5>

		<p>Pa&iacute;s: <span class="font-weight-bold"><?= $resume['d-country']->country?></span></p>
		<p>Direcci&oacute;n: <span class="font-weight-bold"><?= $resume['d-address']?></span></p>
		<p>Notas: <span class="font-weight-bold"><?= $resume['d-address_notes']?></span></p>
	</div>
</div>