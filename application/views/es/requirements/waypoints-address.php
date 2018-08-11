<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina paradas intermedias solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : waypoints-address.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
?>

<div id="waypoints-address" class="float-md-left alert alert-danger z-depth-1 w-100">
	<h4>
		<i class="far fa-hand-paper"></i> Paradas Intermedias 
		<button type="button" class="btn btn-primary" id="btn-add-waypoint">Agregar Parada</button>
		<button type="button" class="btn btn-danger" id="btn-delete-all-waypoints">Eliminar Todas</button>
	</h4>
	<p class="d-none text-dark" id="drag-message"><i>Arrastre las filas para reordenar las paradas.</i></p>
	<div id="wp-cloned"></div>
</div>

<div id="hidden-waypoints" class="d-none">
	<div class="row mb-3">
		<div class="col-6">
			<div class="input-group rounded">
				<div class="input-group-prepend">
					<span class="input-group-text bg-info text-white">Direcci&oacute;n</span>
				</div>
				<input type="text" class="form-control autocomplete">
			</div>
		</div>

		<div class="col-6">
			<div class="input-group rounded">
				<div class="input-group-prepend">
					<span class="input-group-text bg-info text-white">Notas</span>
				</div>
				<input type="text" class="form-control wp-notes">
				<div class="input-group-append">
					<a class="btn btn-warning btn-sm m-0 btn-delete-waypoint-content" title="Eliminar Contenido" role="button"><i class="fas fa-ban"></i></a>
					<a class="btn btn-danger btn-sm m-0 btn-delete-waypoint" title="Eliminar Parada" role="button"><i class="fas fa-trash-alt"></i></a>
				</div>
			</div>
		</div>
	</div>
</div>