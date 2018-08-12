<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina informacion solicitud role user (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : info.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
$product_description = $this->lang->line('product')[$product->product_description];
$product_description_alt = $this->lang->line('product')[$product->product_alt_description];
$subText = '';
if(isset(($requirementsViews['attributeTitle']['views'])))
{
	$subText = $requirementsViews['attributeTitle']['views'];
}
?>
<div class="media">
	<img class="mr-3" src="<?=$qrImageSrc?>" style="width: 150px; height: 150px">
	<div class="media-body">
		<h5>Servicio: <?= $product_description ?><br> 
			Descripci&oacute;n: <small><?= $product_description_alt ?> <i class="text-danger"><?=$subText?></i></small>
		</h5>
		<p>C&oacute;digo QR: <?= $qrText ?></p>

		<div class="alert alert-info">
			<p class="font-italic"><small><i class="fas fa-info-circle"></i> Ingrese un nombre para su solicitud. Si lo deja en blanco, la aplicaci&oacute;n le asignar&aacute; uno autom&aacute;ticamente. M&aacute;ximo 30 caracteres</small></p>
			<div class="md-form form-lg">
				<input type="text" class="form-control" id="requirement_name" name="requirement_name" maxlength="30">
				<label for="requirement_name">Nombre de la solicitud</label>
			</div>
		</div>
	</div>
</div>