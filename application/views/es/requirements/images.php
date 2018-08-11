<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina imagenes solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : images.php
|--------------------------------------------------------------------------
|
*/
$numImgs = $this->config->item('dtr-requirements-max-files');
$imgExt = $imagesCfg['filters']['mime_types'][0]['extensions'];
$imgMaxSize = $imagesCfg['filters']['max_file_size'];
//var_dump($imagesCfg)
?>
<div class="alert alert-light">
	<h5>Levante im&aacute;genes asociadas a su carga.</h5>
	<div class="d-flex justify-content-start alert alert-info">
		<p class="font-italic"><small><i class="fas fa-info-circle"></i> Podr&aacute; levantar hasta <?= $numImgs ?> im&aacute;genes. <i class="fas fa-angle-right"></i> </small></p> 
		<p class="font-italic"><small><i class="fas fa-info-circle"></i> Los formatos aceptados son <?= $imgExt ?>. <i class="fas fa-angle-right"></i> </small></p> 
		<p class="font-italic"><small><i class="fas fa-info-circle"></i> Tama&ntilde;o m&aacute;ximo por im&aacute;gen <?= $imgMaxSize ?>.</small></p>
	</div>
</div>

<div class="alert alert-light" id="requirement-images">
	<div id="uploader" data-img-config='<?=json_encode($imagesCfg)?>'>
		<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
	</div>
</div>

<div class="alert alert-light d-flex justify-content-around" id="images-requirements-preview"></div>