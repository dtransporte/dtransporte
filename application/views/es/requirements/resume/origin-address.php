<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina resumen direccion origen solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements/resume
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : origin-address.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
?>
<div class="d-flex alert alert-dark rounded justify-content-between">
	<div class="alert">
		<h5>Direcci&oacute;n de Origen</h5>

		<p>Pa&iacute;s: <span class="font-weight-bold"><?= $resume['o-country']->country?></span></p>
		<p>Direcci&oacute;n: <span class="font-weight-bold"><?= $resume['o-address']?></span></p>
		<p>Notas: <span class="font-weight-bold"><?= $resume['o-address_notes']?></span></p>
	</div>
<!-- EL DIV CIERRA EN EL ARCHIVO application/views/public/es/requirements/resume/destination-address.php -->