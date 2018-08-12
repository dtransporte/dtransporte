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
| Nombre : personal-data.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
?>
<!-- INPUT PRIMER NOMBRE -->
<div class="md-form form-lg mb-4">
	<input type="text" class="form-control w-100" id="user_first_name" name="user_first_name" required value="<?=$user->user_first_name?>">
	<label for="user_first_name">Nombre</label>
</div>
<br>
<!-- INPUT APELLIDO -->
<div class="md-form form-lg mb-4">
	<input type="text" class="form-control w-100" id="user_last_name" name="user_last_name" required value="<?=$user->user_last_name?>">
	<label for="user_last_name">Apellido</label>
</div>
<br>
<!-- INPUT TELEFONO DE USUARIO -->
<div class="md-form form-lg mb-4">
	<input type="text" class="form-control w-100" id="phone_number" name="phone_number" required data-as="number" data-checkLength data-message="<?=$this->lang->line('dtr-error-phone-length')?>" value="<?=$user->phone_number?>">
	<label for="phone_number">Tel&eacute;fono</label>
</div>