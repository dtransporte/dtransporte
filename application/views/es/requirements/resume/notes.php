<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina resumen notas solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements/resume
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : notes.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
?>
<div class="alert alert-dark rounded">
	<h5>Notas y Observaciones</h5>
	<p class="font-weight-bold"><?=$resume['requirement_notes']?></p>
</div>