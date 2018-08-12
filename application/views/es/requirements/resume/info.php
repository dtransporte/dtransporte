<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina informacion resumen solicitud role user (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/es/requirements/resume
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
if(isset(($resume['cargo_product_type'])))
{
	$subText = $this->lang->line('product-attribute')[$resume['cargo_product_type']]['title'];
}
$name = !empty($resume['requirement_name']) ? $resume['requirement_name'] : 'La apicaci&oacute;n asignar&aacute; un nombre autom&aacute;ticamente';
?>
<div class="media p-1 mb-3">
	<img class="mr-3" src="<?=$qrImageSrc?>" style="width: 150px; height: 150px">
	<div class="media-body">
		<h5>Servicio: <?= $product_description ?><br> 
			Descripci&oacute;n: <small><?= $product_description_alt ?> <i class="text-danger"><?=$subText?></i></small>
		</h5>
		<p>C&oacute;digo QR: <?= $qrText ?></p>
		<h5>Nombre de la solicitud: <span class="font-weight-bold"><?= $name ?></span></h5>
	</div>
</div>