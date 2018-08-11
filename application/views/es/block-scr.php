<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Vista de pagina bloqueo de pantalla
|--------------------------------------------------------------------------
| Ubicacion: application/views/es
| 
|
*/
?>
<div class="container-fluid">
	<h4>Ingrese su contrase&ntilde;a</h4>
	<h5 class="alert alert-warning">Tiene <span id="attempts-unlock"><?=$_SESSION['DTR-BLOCK-SCREEN']?></span> intentos antes de que su cuenta sea bloqueada.</h5>
	<form id="frm-unblock-scr">
		<div class="form-group">
			<input type="password" class="form-control form-control-lg" name="user_pwd">
		</div>
	</form>
</div>