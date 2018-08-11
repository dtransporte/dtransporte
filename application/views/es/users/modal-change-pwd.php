<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina cambio contrasenia usuarios (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/users
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : modal-change-pwd.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);
?>
<form>
	<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" >
	<?php $this->load->view('es/users/change-pwd')?>
	<button class="btn btn-primary btn-block" id="btn-save"><i class="fas fa-check"></i> Actualizar</button>
</form>