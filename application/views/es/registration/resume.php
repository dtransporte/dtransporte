<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| resume - Vista resumen registro de usuario
| -------------------------------------------------------------------------
|
| -------------------------------------------------------------------------
| Ubicacion
|	application/views/es/registration
| -------------------------------------------------------------------------
*/
//var_dump($userData);
$textUserRole = $userData['user_role'] === 'user' ? 'Ud. se ha registrado como <b>usuario solicitante de servicios.</b>' : 'Ud. se ha registrado como <b>empresa oferente de servicios.</b>'
?>
<h2 class="text-center">Lea atentamente los datos ingresados antes de enviar el registro.</h2>
<hr>
<h3 class="text-center text-primary"><?=$textUserRole?></h3>
<ul class="list-group">
	<li class="list-group-item list-group-item-primary">ID Usuario: <?=$userData['user_name']?></li>
	<?php if(!empty(trim($userData['company_name']))):?>
		<li class="list-group-item list-group-item-primary">Empresa: <?=$userData['company_name']?></li>
	<?php endif?>
	<li class="list-group-item list-group-item-primary">Pa&iacute;s: <?=$userData['extendedCountry']->country?></li>
	<li class="list-group-item list-group-item-primary">Direcci&oacute;n: <?=$userData['address']?></li>
	<li class="list-group-item list-group-item-primary">Tel&eacute;fono: <?=$userData['phone_prefix']?> - <?=$userData['phone_number']?></li>
</ul>
<hr>
<h4 class="text-center">
	Si todos los datos son correctos haga click en <u>Enviar Registro</u>.<br>
	<small>De lo contrario haga click en <u>Cancelar</u> y corrija sus datos en el formulario.</small>
</h4>
<p class="text-center">Aseg&uacute;rese de haber le&iacute;do nuestra Pol&iacute;tica de Privacidad y T&eacute;rminos de Uso.</p>

<h2 class="text-center"><i class="fa fa-check fa-4x animated rotateIn mb-4"></i></h2>

<form>
	<?php unset($userData['extendedCountry'])?>
	<?php foreach($userData as $key => $data):?>
		<input type="hidden" name="<?=$key?>" value="<?=$data?>">
	<?php endforeach?>
</form>