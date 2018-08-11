<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina home role user (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/users
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : user-home.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
?>

<div class="container-fluid" id="container">
	<div class="text-center">
		<!-- BOTON AGREGAR SOLICITUD -->
		<button type="button" class="btn btn-lg btn-unique btn-block rounded" id="btn-add-requirement">
			<h4><i class="fas fa-window-maximize"></i> Agregar Solicitud</h4>
		</button>
	</div>

	<div class="alert alert-light">
		<i class="fas fa-bars fa-lg pointer show-hide-panels" data-trigger="hover" data-toggle="tooltip" data-placement="right" title="Mostrar/Ocultar Panel"></i>
		<div class="d-flex justify-content-between animated fadeInLeft user-panel">
			<!-- MUESTRA LISTADO DE SOLICITUDES -->
			<div class="card border-primary mt-3 mb-3 w-75 mr-1" id="requirements-list">
				 <div class="card-header bg-primary text-white font-weight-bold">
					<h5>
						<i class="fas fa-window-maximize"></i> Solicitudes
					</h5>
				</div>
				<div class="card-body">
					<?php if(count($requirements) == 0): ?>
						<p class="font-weight-bold">
							A&uacute;n no ha agregado ninguna solicitud.<br>
							Haga click en el bot&oacute;n "Agregar Solicitud" para agregar su primera solicitud.
						</p>
					<?php else:?>
						<table id="tbl-user-requirements"></table>
					<?php endif?>
				</div>
			</div>

			<!-- RANKING USUARIO -->
			<div class="card border-danger mt-3 mb-3 w-25 ml-1">
				<div class="card-header text-white bg-danger font-weight-bold">
					<h5><i class="fas fa-user-check"></i> Ranking</h5>
				</div>
				<div class="card-body">
					<?php if($faults > 0):?>
						<h5 class="card-title border border-danger border-left-0 border-right-0 border-top-0">
							<i class="fas fa-user-times"></i> Penalizaciones: <span class="font-weight-bold"><?=$faults*100?>%</span>
						</h5>
					<?php endif?>
					<?php if($ranking == 0):?>
						<p><i class="fas fa-user-times"></i> <span class="font-weight-bold">A&uacute;n no has sido rankeado.</span></p>
					<?php else:?>
						<?php $percent = round($ranking/$rankingValues['max'] * 100, 2)?>
						<p class="font-weight-bold text-danger"><i class="fas fa-check-double"></i> <?= round($ranking, 2)?> - <?=$percent?>%</p>
						<div class="progress">
							<div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?=ceil($percent)?>%" aria-valuenow="<?=ceil($percent)?>" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<br>
						<a role="button" class="btn btn-primary" id="show-ranking-detail">Ver detalle</a>
					<?php endif?>
				</div>
				
			</div>
		</div>
	</div>

	<div class="alert alert-light">
		<i class="fas fa-bars fa-lg pointer show-hide-panels" data-trigger="hover" data-toggle="tooltip" data-placement="right" title="Mostrar/Ocultar Panel"></i>
		<div class="d-flex justify-content-between animated fadeInLeft user-panel">
			<!-- GRAFICO SOLICITUDES POR ESTADO -->
			<div class="card border-info mt-3 mb-3 w-50 mr-1">
				<div class="card-header text-white bg-info font-weight-bold">
					<h5>Solicitudes por Estado</h5>
				</div>
				<div class="card-body">
					<canvas id="requirements-by-status-chart" width="auto" height="100" ></canvas>
				</div>
			</div>
			
			<div class="card border-info mt-3 mb-3 w-50 ml-1">
				<div class="card-header text-white bg-info font-weight-bold">
					<h5><i class="fas fa-file"></i> Solicitudes Finalizadas por Empresa</h5>
				</div>
				
				<div class="card-body">
					<canvas id="requirements-finished-by-assoc" width="auto" height="100" ></canvas>
				</div>
			</div>
		</div>
	</div>
</div>