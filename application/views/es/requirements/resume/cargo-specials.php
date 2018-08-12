<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina resumen detalles de requerimientos especiales carga solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements/resume
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : cargo-specials.php
|--------------------------------------------------------------------------
|
*/
$additionals = $this->lang->line('dtr-requirements-additionals');
?>
<?php if(isset($resume['cargo_additionals']) AND !empty($resume['cargo_additionals'])):?>
	<?php $additionals = json_decode($resume['cargo_additionals']) ?>
	<div class="alert alert-dark rounded">
		<h5>Requerimientos Adicionales de Carga</h5>
		<table class="table table-bordered table-sm table-responsive-md table-striped btn-table">
			<thead class="bg-dark text-white text-center">
				<tr>
					<th>Item</th>
					<th>Cantidad</th>
					<th>Lugar</th>
					<th>Notas</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($additionals as $adds):?>
				<tr>
					<td class="font-weight-bold"><?=$adds->name?></td>
					<td class="font-weight-bold"><?=$adds->quantity?></td>
					<td class="font-weight-bold"><?=$this->lang->line('text-'.$adds->place)?></td>
					<td class="font-weight-bold"><?=$adds->notes?></td>
				</tr>
				<?php endforeach?>
			</tbody>
		</table>
	</div>
<?php endif?>