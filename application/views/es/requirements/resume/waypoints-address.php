<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina resumen paradas intermedias solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements/resume
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : waypoints-address.php
|--------------------------------------------------------------------------
|
*/
?>
<?php if(isset($resume['wp-address'])):?>
	<div class="alert alert-dark rounded">
		<h5 class="mb-2">Paradas Intermedias</h5>
		<table class="table table-bordered table-sm">
			<thead class="bg-dark text-white">
				<tr>
					<th>Direcci&oacute;n</th>
					<th>Notas</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($resume['wp-address'] as $k=>$addr):?>
				<tr>
					<td><?= $addr?></td>
					<td><?= $resume['wp-notes'][$k]?></td>
				</tr>
				<?php endforeach?>
			</tbody>
		</table>
	</div>
<?php endif?>