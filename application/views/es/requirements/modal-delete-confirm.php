<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina confirmacion elimiminacion solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : modal-delete-confirm.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
?>

<div class="text-center alert alert-danger d-flex justify-content-between">
	<div><i class="fas fa-times fa-4x animated rotateIn"></i></div>
	<div><p>Confirma que desea eliminar la solicitud <b><?=$requirement_name?></b> ?</p></div>
</div>
