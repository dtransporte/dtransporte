<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina resumen tipo de operacion solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements/resume
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : operation-type.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
$opTypeText = $this->lang->line('dtr-operation-type');
$incoterms = $this->lang->line('dtr-incoterms');
?>
<div class="alert alert-dark rounded">
	<div class="row">
		<div class="col-md-6">
			<h5>Tipo Operaci&oacute;n: <span class="font-weight-bold"><?= $opTypeText[$resume['operation_type']]?></span></h5>
			<h5>Incoterm Operaci&oacute;n: <span class="font-weight-bold"><?= strtoupper($resume['operation_incoterm'])?></span></h5>
			<h5>Moneda Operaci&oacute;n: <span class="font-weight-bold"><?= $currencies[$resume['operation_currency']]['currencyname']?> -- <?= $currencies[$resume['operation_currency']]['currencycode']?></span></h5>
			<h5>Valor Operaci&oacute;n: <span class="font-weight-bold"><?= $resume['operation_value']?></span></h5>
		</div>
		<div class="col-md-6">
			<?php if(isset($resume['custom_clearance'])  AND ($resume['custom_clearance'] == 1)):?>
				<p><span class="font-weight-bold"><i class="fas fa-check"></i> Requiere despacho aduanero.</span></p>
			<?php endif?>
			<?php if(isset($resume['require_insurance'])  AND ($resume['require_insurance'] == 1)):?>
				<p><span class="font-weight-bold"><i class="fas fa-check"></i> Requiere contrataci&oacute;n de seguro.</span></p>
			<?php endif?>
			<?php if(isset($resume['require_co']) AND ($resume['require_co'] == 1)):?>
				<p><span class="font-weight-bold"><i class="fas fa-check"></i> Requiere emisi&oacute;n de cert. origen.</span></p>
			<?php endif?>

			<?php if($resume['inspection_required'] != 'no'):?>
				<?php $placeInspection = $this->lang->line('text-'.$resume['inspection_required'])?>
				<p><span class="font-weight-bold"><i class="fas fa-check"></i> Requiere inspecci&oacute;n en <?= $placeInspection?>.</span></p>
				<?php if(!empty($resume['inspection_company'])):?>
					<small>Compa&ntilde;ia Inspectora: <?= $resume['inspection_company']?>.</small>
				<?php endif?>
				<?php if(!empty($resume['inspection_notes'])):?>
					<br>
					<small>Notas Inspecci&oacute;n: <?= $resume['inspection_notes']?>.</small>
				<?php endif?>
			<?php endif?>
		</div>
	</div>
	<?php if(!empty($resume['operation_ncm_codes'])):?>
		<?php $hsCodes = json_decode($resume['operation_ncm_codes'])?>
		<h5 class="mt-2">C&oacute;digos Arancelarios</h5>
		<table class="table table-bordered table-sm">
			<thead class="bg-dark text-white">
				<tr>
					<th>C&oacute;digo</th>
					<th>Valor</th>
					<th>Descripci&oacute;n</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($hsCodes as $code):?>
				<tr>
					<td><?= $code->code?></td>
					<td><?= $code->value?></td>
					<td><?= $code->description?></td>
				</tr>
				<?php endforeach?>
			</tbody>
		</table>
	<?php endif?>
</div>