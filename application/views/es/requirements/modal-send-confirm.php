<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina confirmacion envio solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : modal-send-confirm.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
?>
<div class="text-center alert alert-primary d-flex justify-content-between">
	<div><i class="fas fa-envelope fa-4x animated rotateIn"></i></div>
	<div><p>Confirma que desea enviar la solicitud <b><?=$requirement_name?></b> ?</p></div>
</div>