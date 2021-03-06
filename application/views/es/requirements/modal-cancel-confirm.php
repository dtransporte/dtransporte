<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina confirmacion elimiminacion solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : modal-delete-confirm.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
$faults = $this->config->item('dtr-user-faults');
?>

<div>
	<h5 class="text-center text-warning">Esta acci&oacute;n afectar&aacute; su ranking.</h5>
	<div class="text-center alert alert-warning d-flex justify-content-between">
		<div><i class="fas fa-ban fa-4x animated rotateIn"></i></div>
		<div>
			<p>Confirma que desea cancelar la solicitud <b><?=$requirement_name?></b> ?</p>
		</div>
	</div>
	<p class="text-center text-danger">
		<?php if($fault == 0):?>
			<?php $limitDate = mysql_to_unix($user->user_entered)+ $this->config->item('dtr-max-no-faults')?>
			Ud. no ser&aacute; penalizado hasta el <?= mdate($user->user_dformat, $limitDate)?>
		<?php else:?>
			Su penalizaci&oacute;n ser&aacute; de <?=$fault*100?>%
		<?php endif?>
	</p>
	<small>
		<a role="button" class="text-center text-dark" id="view-more-about-faults">
			Saber m&aacute;s sobre penalizaciones. <i class="fas fa-angle-double-down"></i>
		</a>
	</small>
	<div class="d-none" id="show-about-faults">
	<br>
	<small>
	<ul class="list-group">
		<li class="list-group-item list-group-item-info">Las penalizaciones se asignan a un usuario cuando este cancela una solicitud.</li>
		<li class="list-group-item list-group-item-info">Las penalizaciones comienzan a regir despu&eacute;s de <?=$this->config->item('dtr-max-no-faults')/(24 * 60 * 60)?> d&iacute;as a partir de la fecha de registro del usuario.</li>
		<li class="list-group-item list-group-item-info">Las penalizaciones tienen un m&iacute;nimo de <?=$faults['min']*100 ?>% increment&aacute;dose a raz&oacute;n de <?=$faults['step']*100 ?>% por cada cotizaci&oacute;n que la solicitud tenga asociada, con un m&aacute;ximo de <?=$faults['max']*100 ?>%.</li>
		<li class="list-group-item list-group-item-info">Las penalizaciones se eliminar&aacute;n de su registro una vez transcurridos <?=$this->config->item('dtr-maxdate-fault')/(24 * 60 * 60) ?> d&iacute;as.</li>
	</ul>
	</small>
	<p class="text-danger">Nota: Si la solicitud ya ha sido cerrada, se aplicar&aacute; la penalizaci&oacute;n m&aacute;xima.</p>
</div>
</div>
