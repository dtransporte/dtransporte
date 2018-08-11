<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina programacion solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : modal-prog-confirm.php
|--------------------------------------------------------------------------
|
*/
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);
?>
<form>
	<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" >
	<input type="hidden" name="id_requirement" value="<?=$id_requirement?>">
	<input type="hidden" name="requirement_programation">
	<div class="form-group text-center alert alert-info d-flex justify-content-between">
		<div><i class="far fa-clock fa-4x animated rotateIn"></i></div>
		<div>
			<p>La solicitud <u><?=$requirement_name?></u> ser&aacute; enviada a la fecha y hora por usted programada.</p>
			<small>Seleccionar Fecha</small>
			<div class="md-form form-lg mb-4">
				<input type="text" class="form-control" id="programation_date" data-expiration="<?=$requirement_expiration?>">
			</div>
		</div>
	</div>
</form>
