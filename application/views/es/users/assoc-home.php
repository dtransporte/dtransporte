<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina home role assoc (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/users
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : assoc-home.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
?>
<div class="container-fluid" id="container">
	<div class="alert alert-light">
		<i class="fas fa-bars fa-lg pointer show-hide-panels" data-trigger="hover" data-toggle="tooltip" data-placement="right" title="Mostrar/Ocultar Panel"></i>
		<div class="d-flex justify-content-between animated fadeInLeft user-panel">
			<!-- MUESTRA LISTADO DE COTIZACIONES -->
			<div class="card border-primary mt-3 mb-3 w-50 mr-1">
				<div class="card-header text-white bg-primary font-weight-bold">
					<h5>
						<i class="fas fa-file"></i> Solicitudes Cotizadas
					</h5>
				</div>
				<div class="card-body">
					<table id="tbl-assoc-quotations"></table>
				</div>
			</div>
			<!-- MUESTRA LISTADO DE SOLICITUDES PENDIENTES DE COTIZAR -->
			<div class="card border-warning mt-3 mb-3 ml-1" id="requirements-pending-list">
				<div class="card-header text-white bg-warning font-weight-bold">
					<h5>
						<i class="fas fa-window-maximize"></i> Solicitudes Pendientes
					</h5>
				</div>
				<div class="card-body">
					<table id="tbl-requirements-pending-quot"></table>
				</div>
			</div>
		</div>
	</div>

	<div class="alert alert-light">
		<i class="fas fa-bars fa-lg pointer show-hide-panels" data-trigger="hover" data-toggle="tooltip" data-placement="right" title="Mostrar/Ocultar Panel"></i>
		<div class="d-flex justify-content-between animated fadeInLeft user-panel">
			<div class="card border-info mt-3 mb-3 w-50 mr-1">
				<div class="card-header bg-info text-white font-weight-bold">
					<h5>Porcentaje servicios m&aacute;s solicitados.</h5>
					<!-- <select class="custom-select form-control-sm w-25">
						<option value="bar">Barra Vertical</option>
						<option value="horizontalBar">Barra Horizontal</option>
						<option value="line">L&iacute;neas</option>
						<option value="pie">Pie</option>
						<option value="doughnut">Doughnut</option>
					</select> -->
				</div>
				<div class="card-body">
					<canvas id="product-required-by-users-chart" width="auto" height="100"></canvas>
				</div>
			</div>
			<div class="card border-info mt-3 mb-3 w-50 ml-1">
				<div class="card-header bg-info text-white font-weight-bold">
					<h5>Solicitudes finalizadas por usuario</h5>
				</div>
				<div class="card-body">
					<canvas id="requirements-finished-by-user" width="auto" height="100" ></canvas>
				</div>
				
			</div>
		</div>
	</div>

	<div class="alert alert-light">
		<div class="d-flex justify-content-between">
			<div class="card border-info mt-3 mb-3 w-50 mr-1">
				<div class="card-header bg-info text-white font-weight-bold">
					<h5>Detalle Cotizaciones</h5>
				</div>
				<div class="card-body">
					<?php $total = count($quotations)?>
					<h5>Total Solicitudes Cotizadas: <?= $total?></h5>
					<p>Cotizaciones Rechazadas: <?= $rejectedQuotations?></p>
					<div class="progress">
						<div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?=ceil($rejectedQuotations/$total*100)?>%" aria-valuenow="<?=ceil($rejectedQuotations/$total*100)?>" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
					<br>
					<p>Cotizaciones Finalizadas: <?= $finishedQuotations?></p>
					<div class="progress">
						<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?=ceil($finishedQuotations/$total*100)?>%" aria-valuenow="<?=ceil($finishedQuotations/$total*100)?>" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>

			<div class="card border-danger mt-3 mb-3 w-50 ml-1">
				<div class="card-header bg-danger text-white font-weight-bold">
					<h5><i class="fas fa-user-check"></i> Ranking</h5>
				</div>
				<div class="card-body">
					<?php if($faults > 0):?>
						<h5 class="card-title border border-danger text-danger border-left-0 border-right-0 border-top-0">
							<i class="fas fa-user-times"></i> Penalizaciones: <span class="font-weight-bold"><?=$faults*100?>%</span>
						</h5>
					<?php endif?>
					<?php if($ranking == 0):?>
						<p><i class="fas fa-user-times"></i> <span class="font-weight-bold">A&uacute;n no has sido rankeado.</span></p>
					<?php else:?>
						<?php $percent = round($ranking/$rankingValues['max'] * 100, 2)?>
						<p class="font-weight-bold text-danger"><i class="fas fa-check-double"></i> <?= $ranking?> - <?=$percent?>%</p>
						<div class="progress">
							<div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?=ceil($percent)?>%" aria-valuenow="<?=ceil($percent)?>" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<br>
						<a role="button" class="btn btn-primary" id="show-ranking-detail">Ver detalle</a>
						<?php //var_dump($rankingDetail) ?>
					<?php endif?>
				</div>
			</div>
		</div>
	</div>
</div>