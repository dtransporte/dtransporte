<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina resumen detalles de mudanza solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements/resume
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : cargo-moving-details.php
|--------------------------------------------------------------------------
|
*/
$inventory = $this->lang->line('dtr-moving-inventory');
$detail = json_decode($resume['cargo_moving_detail']);
?>
<div class="alert alert-dark rounded">
	<h5 class="m-3">Detalles de mudanza</h5>
	<table class="table table-bordered table-sm table-responsive-md table-striped btn-table" id="tbl-moving-inventory">
		<thead class="bg-primary text-white text-center">
			<tr>
				<th>Item</th>
				<th>Cantidad</th>
				<th>Notas</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($detail as $d):?>
			<tr>
				<td class="font-weight-bold"><?=$d->name?></td>
				<td class="font-weight-bold"><?=$d->quantity?></td>
				<td class="font-weight-bold"><?=$d->notes?></td>
			</tr>
			<?php endforeach?>
		</tbody>
	</table>
</div>