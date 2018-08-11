<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina cambio contrasenia usuarios (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/users
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : modal-change-pwd.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
?>
<p>Suba su im&aacute;gen o el logo de su empresa.</p>
<div id="uploader" data-img-config='<?=json_encode($imgCfg)?>'>
	<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
</div>
