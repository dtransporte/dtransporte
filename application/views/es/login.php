<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina publica formulario de acceso (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : login.php
|--------------------------------------------------------------------------
|
*/
$csrf_login = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);
?>
<div id="popover-content" class="d-none">
	<div class="container-fluid">
	<p>Acceso Usuarios</p>
	<form id="frm-login" role="form" method="post">
		<input type="hidden" name="<?=$csrf_login['name'];?>" value="<?=$csrf_login['hash'];?>">

		<small>Correo Electr&oacute;nico</small>
		<div class="md-form mb-4 mt-0">
			<i class="fas fa-user prefix"></i>
			<input type="text" class="form-control form-control-sm" id="username" name="user_name" style="height: 20px">
			<!-- <label for="user_name">Correo Electr&oacute;nico</label> -->
		</div>
		
		<small>Contrase&ntilde;a</small>
		<div class="md-form mb-4 mt-0">
			<i class="fas fa-key prefix"></i>
			<input type="password" class="form-control form-control-sm" id="userpwd" name="user_pwd" style="height: 20px">
			<!-- <label for="user_pwd">Contrase&ntilde;a</label> -->
		</div>
		<hr>
		
		<div class="btn-group" role="group" aria-label="Registro Usuarios">
			<button type="submit" class="btn btn-primary btn-sm p-2" id="btn-login">Acceder</button>
			<a role="button" class="btn btn-sm btn-link text-primary" id="btn-fpwd">Olvid&eacute; contrase&ntilde;a</a>
		</div>
	</form>
	</div>
</div>