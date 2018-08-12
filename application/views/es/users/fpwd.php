<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina publica formulario de envio de nueva contrasenia (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/users
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : fpwd.php
|--------------------------------------------------------------------------
|
*/
$csrf_pwd = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);
?>
<form id="frm-fpwd" role="form" method="post">
	<input type="hidden" name="<?=$csrf_pwd['name'];?>" value="<?=$csrf_pwd['hash'];?>" >
	<div class="form-group">
		<label for="user_fpwd">Correo Electr&oacute;nico</label>
		<input type="email" 
		class="form-control form-control-lg" 
		id="user_fpwd" 
		name="user_fpwd" 
		placeholder="Campo Requerido" 
		required 
		>
	</div>

	<div class="form-group">
		<button type="submit" class="btn btn-primary"><span class="fa fa-envelope-o"></span> Enviar</button>
	</div>
</form>