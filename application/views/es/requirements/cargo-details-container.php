<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina detalles de carga fcl solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : cargo-details-container.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
$containers = $this->lang->line('dtr-containers');
$imgSrc = base_url().'imgs/containers/';
?>
<div id="containers-type" class="alert alert-light">
	<h5>Seleccione Contenedor</h5>
	<div class="row">
		<div class="col-lg-4 col-md-8">
			<select class="selectpicker show-menu-arrow" name="cargo_containers" id="cargo_containers" data-width="100%">
			<?php foreach($containers as $k=>$c):?>
				<option data-container='<?=json_encode($c)?>' data-tokens="<?=$k?>" value="<?=$k?>" ><?= $c['title']?></option>
			<?php endforeach?>
			</select>
		</div>

		<div class="col-lg-8 col-md-4">
			<div id="container-data">
				<div class="media">
					<img class="rounded m-3" style="max-width: 200px">
					<div class="media-body m-3 text-dark">
						<h5 class="mt-0 font-weight-bold"></h5>
						<div class="media-data"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>