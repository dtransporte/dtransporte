<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina mostrar agentes (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/es
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : agents.php
|--------------------------------------------------------------------------
|
*/
?>
<div class="container-fluid">
	<small class="text-muted">Click en el nombre del navegador para recibir soporte.</small>
	<h5>Navegador: <a href="<?=$http?>" target="_blank"><?=$agent?></a></h5>
	<p>Versi&oacute;n: <?=$version?></p>
	<p>Plataforma: <?=$platform?></p>
</div>