<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina publica home (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : home.php
|--------------------------------------------------------------------------
|
*/
$icon = $this->lang->line('dtr-public-menu')['home']['icon'];
?>
<hr>
<div class="container" id="public-home">
	<h1 class="display-4 d-none d-sm-block"><span class="<?=$icon?>"></span> dTransporte</h1>
	<h1 class="d-md-none"><span class="<?=$icon?>"></span> dTransporte</h1>
		<p><mark>dTransporte.com</mark> es un portal uruguayo que facilita el v&iacute;nculo entre usuarios (solicitantes de transporte) y empresas registradas (oferentes de transporte y/u otros servicios).</p>

		<p>Nuestro objetivo es brindar un servicio eficiente, de respuesta inmediata y al mejor precio tanto para personas f&iacute;sicas como para empresas que as&iacute; lo requieran, sin necesidad de moverse de su casa u oficina.</p>

		<p>Podr&aacute; ver, evaluar y finalmente contratar aquellas empresas que estime las m&aacute;s eficientes, aseg&uacute;randose de esa forma el precio y el servicio convenidos.</p>

		<p class="font-weight-bold p-1">Todas las empresas registradas se obligan a garantizar el precio y servicios pactados.</p>
</div>
<hr>