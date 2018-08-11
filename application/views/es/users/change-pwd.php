<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina cambio contrasenia First Time (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/users
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : change-pwd.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
?>
<p class="alert alert-info">Tipee su nueva contrase&ntilde;a o haga click en el bot&oacute;n <u>Generear Contrase&ntilde;a</u> para que la aplicaci&oacute;n la genere autom&aacute;lticamente.</p>

<?php if(isset($showCurPwd) AND $showCurPwd === TRUE):?>
<div class="md-form form-lg mb-4">
	<input type="password" class="form-control w-100 password" id="cur-pwd" name="cur-pwd" required>
	<label for="cur-pwd">Contrase&ntilde;a Actual</label>
</div>
<br>
<?php endif?>

<div class="md-form form-lg mb-4">
	<input type="password" class="form-control w-100 password random-password" id="new-pwd" name="new-pwd" required>
	<label for="new-pwd">Nueva Contrase&ntilde;a</label>
</div>
<br>
<div class="md-form form-lg mb-4">
	<input type="password" class="form-control w-100 password random-password" id="r-new-pwd" name="r-new-pwd" data-match="new-pwd" data-message="<?=$minMaxPwd['msg']?>" data-min="<?=$minMaxPwd['min']?>" data-max="<?=$minMaxPwd['max']?>" required data-checkPwdLength>
	<label for="r-new-pwd">Reingrese Contrase&ntilde;a</label>
</div>
<br>
<!-- GENERAR CONTRASENIA CUSTOMIZADA -->
<div class="alert alert-dark">
	<div class="radio">
		<input type="radio" id="pwd-alfanum" checked="checked" name="pwd_type">
		<label for="pwd-alfanum">Alfnum&eacute;rica</label>

		<input type="radio" id="pwd-spchars" name="pwd_type">
		<label for="pwd-spchars">Caracteres Especiales</label>

		<select class="custom-select w-25" id="num-chars-pwd" data-toggle="tooltip" data-placement="right" title="Seleccione n&uacute;mero de caracteres">
			<?php for($i=$minMaxPwd['min']; $i<=$minMaxPwd['max']; $i++):?>
				<option value="<?=$i?>"><?=$i?></option>
			<?php endfor?>
		</select>
	</div>

	<div class="checkbox">
		<input type="checkbox" id="show-pwd">
		<label for="show-pwd">Mostrar/Ocultar</label>
	</div>

	<div class="form-group">
		<button type="button" class="btn btn-secondary" id="btn-random-pwd">Generear Contrase&ntilde;a</button> 
	</div>
</div>
