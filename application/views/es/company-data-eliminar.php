<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina datos empresa (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : company-data.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
?>
<!-- INPUT NOMBRE EMPRESA -->
<div class="md-form form-lg mb-4">
	<input type="text" class="form-control" id="company_name" name="company_name" value="<?= isset($user->company_name) ? $user->company_name : ''?>">
	<label for="company_name">Empresa</label>
</div>
<br>
<!-- INPUT NOMBRE FANTASIA -->
<div class="md-form form-lg mb-4">
	<input type="text" class="form-control" id="company_alt_name" name="company_alt_name" value="<?= isset($user->company_name) ? $user->company_alt_name : ''?>">
	<label for="company_alt_name">Nombre Comercial</label>
</div>
<br>
<!-- INPUT RUT EMPRESA -->
<div class="md-form form-lg mb-4">
	<input type="text" class="form-control" id="company_rut" name="company_rut" value="<?= isset($user->company_name) ? $user->company_rut : ''?>">
	<label for="company_rut">RUT Empresa</label>
</div>