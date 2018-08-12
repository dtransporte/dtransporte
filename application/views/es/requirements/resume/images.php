<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina resumen imagenes solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements/resume
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : images.php
|--------------------------------------------------------------------------
|
*/
?>
<?php if(isset($images)):?>
	<div class="alert alert-dark rounded">
		<h5>Im&aacute;genes</h5>
		<div class="d-flex justify-content-start">
			<?php foreach($images as $img):?>
				<img src="<?=$img?>" class="rounded ml-2" style="width: 100px; height: 100px">
			<?php endforeach?>
		</div>
	</div>
<?php endif?>