<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina resumen detalles de carga fcl solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements/resume
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : cargo-details-container.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
$containers = $this->lang->line('dtr-containers')[$resume['cargo_containers']];
$imgSrc = base_url().'imgs/containers/'.$containers['image'];
?>
<div class="alert alert-dark rounded">
	<h5>Tipo Contenedor</h5>
	<div class="media">
		<img class="mr-3 rounded" src="<?=$imgSrc?>" style="max-width: 200px">
		<div class="media-body">
			<h5 class="mt-0 font-weight-bold"><?= $containers['name']?></h5>
		</div>
	</div>
</div>