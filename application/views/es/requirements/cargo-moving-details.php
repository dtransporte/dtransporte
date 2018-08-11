<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina detalles de mudanza solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : cargo-moving-details.php
|--------------------------------------------------------------------------
|
*/
$inventory = $this->lang->line('dtr-moving-inventory');
?>
<div id="cargo-moving-details" class="alert alert-light">
	<input type="hidden" name="cargo_moving_detail" id="cargo_moving_detail">
	<h5 class="m-3">Detalles de mudanza</h5>

	<div class="row">
		<div class="col-6">
			<div class="accordion" id="accordion-moving-inventory">
				<?php foreach($inventory as $key => $inv):?>
					<?php $show = $key == 'furniture' ? 'show' : ''?>
					<div class="card">
						<div class="card-header" id="heading-<?=$key?>">
						<h5>
							<button class="btn btn-link btn-lg" type="button" data-toggle="collapse" data-target="#collapse-<?=$key?>" aria-expanded="true" aria-controls="collapse-<?=$key?>">
							<h5><?= $this->lang->line('text-'.$key)?></h5>
							</button>
						</h5>
						</div>

						<div id="collapse-<?=$key?>" class="collapse <?=$show?>" aria-labelledby="heading-<?=$key?>" data-parent="#accordion-moving-inventory">
							<div class="card-body">
								<?php foreach($inv as $k => $i):?>
									<?php $dataItem = ['id'=>$k, 'name'=>$i]?>
									<div class="container-dragged alert alert-success border-success" id="inv-<?=$k?>" data-item='<?=json_encode($dataItem)?>'>
										<h5 class="m-1 font-weight-bold"><?=$i?></h5>
									</div>
								<?php endforeach?>
							</div>
						</div>
					</div>
				<?php endforeach?>
			</div>
		</div>

		<div class="col-6">
			<h5 class="text-muted"><i>Arrastre aqu&iacute; para seleccionar</i></h5>
			<div id="dropped-items" style="min-height: 200px; border: 1px dashed #CCCCCC">
				<table class="table table-bordered table-sm table-responsive-md table-striped btn-table" id="tbl-moving-inventory">
					<thead class="bg-primary text-white text-center">
						<tr>
							<th>Item</th>
							<th>Cantidad</th>
							<th>Notas</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr class="hidden-row-moving d-none">
							<!-- ITEM -->
							<td class="text-dark"></td>
							<!-- CANTIDAD -->
							<td>
								<input type="number" class="form-control" value="1" min="1">
							</td>
							<!-- NOTAS -->
							<td>
								<input type="text" class="form-control mt-1" maxlength="50" placeholder="M&aacute;x 50 caracteres">
							</td>
							<!-- BOTONERA -->
							<td>
								<a class="btn btn-danger btn-sm btn-delete-item mt-1" role="button" title="Eliminar"><i class="fas fa-trash-alt"></i></a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>