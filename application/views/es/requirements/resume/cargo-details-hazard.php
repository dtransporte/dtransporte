<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina resumen detalles de requerimientos mercaderia peligrosa solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements/resume
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : cargo-details-hazard.php
|--------------------------------------------------------------------------
|
*/
$hazardProducts = $this->lang->line('products-hazard-clasification');
$hazardDetail = json_decode($resume['cargo_hazard_detail']);
?>
<div class="alert alert-dark rounded">
	<h5>Detalles</h5>
	<?php foreach($hazardDetail as $detail):?>
		<div class="media">
			<img src="<?=base_url()?><?=$hazardProducts[$detail->id][$detail->product]['image']?>" class="rounded m-3" style="max-width: 100px">
			<div class="media-body m-3 text-dark">
				<h5 class="mt-0 font-weight-bold"><?=$detail->product?></h5>
				<p><?=$hazardProducts[$detail->id][$detail->product]['description']?></p>
			</div>
		</div>
	<?php endforeach?>
</div>
<!-- <div id="cargo-details-hazard" class="alert alert-light">
	<input type="hidden" name="cargo_hazard_detail" id="cargo_hazard_detail">
	<div class="row">
		<div class="col-6">
			<div class="accordion" id="accordion-hazard-products">
				<?php foreach($hazardProducts as $key => $hprod):?>
					<?php $show = $key == 1 ? 'show' : ''?>
					<div class="card">
						<div class="card-header" id="heading-<?=$key?>">
						<h5 class="mb-0">
							<button class="btn btn-link btn-lg" type="button" data-toggle="collapse" data-target="#collapse-<?=$key?>" aria-expanded="true" aria-controls="collapse-<?=$key?>">
							<?= $key?> - <?= $hprod['name']?>
							</button>
						</h5>
						</div>

						<div id="collapse-<?=$key?>" class="collapse <?=$show?>" aria-labelledby="heading-<?=$key?>" data-parent="#accordion-hazard-products">
							<div class="card-body draggable">
								<?php foreach($hprod as $k => $hp):?>
									<?php if($k != 'name'):?>
										<div class="media container-dragged" id="hp-<?=$k?>" data-product="<?=$k?>">
											<img src="<?=base_url()?><?=$hp['image']?>" class="rounded m-3" style="max-width: 100px">
											<div class="media-body m-3 text-dark">
												<h5 class="mt-0 font-weight-bold"><?=$k?></h5>
												<p><?=$hp['description']?></p>
											</div>
										</div>
									<?php endif?>
								<?php endforeach?>
							</div>
						</div>
					</div>
				<?php endforeach?>
			</div>
		</div>

		<div class="col-6">
			<h5 class="text-muted"><i>Arrastre aqu&iacute; para seleccionar</i></h5>
			<div id="dropped-products" style="min-height: 200px; border: 1px dashed #CCCCCC"></div>
		</div>
	</div>
</div> -->