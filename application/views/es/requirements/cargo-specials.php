<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina detalles de requerimientos especiales carga solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : cargo-specials.php
|--------------------------------------------------------------------------
|
*/
$additionals = $this->lang->line('dtr-requirements-additionals');
?>
<div id="cargo-specials" class="alert alert-light">
	<input type="hidden" name="cargo_additionals" id="cargo_additionals">

	<h5>Requerimientos Adicionales</h5>
	<div class="row">
		<div class="col-md-4">
			<select class="selectpicker show-menu-arrow" id="cargo-additionals" data-width="100%" title="Seleccione">
			<?php foreach($additionals as $k=>$a):?>
				<option data-tokens="<?=$k?>" value="<?=$k?>" ><?= $a?></option>
			<?php endforeach?>
			</select>
		</div>

		<div class="col-md-8">
			<table class="table table-bordered table-sm table-responsive-md table-striped btn-table" id="tbl-cargo-additionals">
				<thead class="bg-primary text-white text-center">
					<tr>
						<th>Item</th>
						<th>Cantidad</th>
						<th>Lugar</th>
						<th>Notas</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr class="hidden-row-additionals d-none">
						<!-- ITEM -->
						<td></td>
						<!-- CANTIDAD -->
						<td>
							<input type="number" class="form-control" value="1" min="1">
						</td>
						<!-- LUGAR -->
						<td>
							<select class="custom-select cargo-additionals-place" data-width="100%">
								<option value="origin" >Origen</option>
								<option value="destination" >Destino</option>
								<option value="origin-destination" >Origen y Destino</option>
							</select>
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