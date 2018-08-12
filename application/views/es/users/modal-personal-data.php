<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina datos personales (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/users
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : modal-personal-data.php
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
	<div class="d-flex justify-content-between">
		<div class="w-50 mr-1">
			<?php $this->load->view('es/users/personal-data')?>
		</div>
		<div class="w-50 ml-1">
			<?php $this->load->view('es/users/company-data')?>
		</div>
	</div>
	<button class="btn btn-primary btn-block" id="btn-save"><i class="fas fa-check"></i> Actualizar</button>
</form>