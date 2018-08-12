<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina notas solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : notes.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
?>
<h5 class="alert alert-light">
	Agregue las observaciones que entienda pertinentes referentes a su solicitud.<br>
	<small><i>M&aacute;ximo 100 caracteres.</i></small>
</h5>

<div class="alert alert-light">
	<h5><i class="fas fa-pencil-alt"></i> <u>Notas/Observaciones</u></h5>
	<div class="md-form form-lg mb-4">
		<i class="fas fa-pencil-alt prefix"></i>
		<textarea class="form-control md-textarea" name="requirement_notes" maxlength="100"></textarea>
	</div>
</div>