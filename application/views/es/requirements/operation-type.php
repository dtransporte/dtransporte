<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina tipo de operacion solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
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
<div id="operations">
	<input type="hidden" name="operation_ncm_codes" id="operation_ncm_codes">
	<div class="row">
		<div class="col-lg-4 col-md-6">
			<!-- SELECTOR DE TIPO OPERACION -->
			<div class="form-group">
				<h5><u>Tipo Operaci&oacute;n</u></h5>
				<p class="font-italic"><small><i class="fas fa-info-circle"></i> Seleccione el tipo de operaci&oacute;n a realizar.</small></p>
				<select class="selectpicker show-menu-arrow" name="operation_type" id="operation_type" data-width="100%">
				<?php foreach($opTypeText as $k=>$op):?>
					<?php $selected = $k === 'impo' ? 'selected="selected"' : '' ?>
					<option data-tokens="<?=$k?>" value="<?=$k?>" <?=$selected?> ><?= $op?></option>
				<?php endforeach?>
				</select>
			</div>

			<!-- SELECTOR DE INCOTERMS -->
			<div class="form-group">
				<h5><u>Icoterm</u></h5>
				<p class="font-italic"><small><i class="fas fa-info-circle"></i> Seleccione el incoterm en que llevar&aacute; a cabo su operaci&oacute;n.</small></p>
				<select class="selectpicker show-menu-arrow" name="operation_incoterm" id="operation_incoterm" data-width="100%">
				<?php foreach($incoterms as $k=>$inc):?>
					<?php $selected = $k === 'exw' ? 'selected="selected"' : '' ?>
					<option data-incoterm='<?=$inc['description']?>' data-tokens="<?=$k?>" value="<?=$k?>" <?=$selected?> ><?= $inc['name']?></option>
				<?php endforeach?>
				</select>
			</div>

			<!-- SELECTOR DE MONEDAS -->
			<h5><u>Moneda y Valor Operaci&oacute;n</u></h5>
			<p class="font-italic"><small><i class="fas fa-info-circle"></i> Seleccione la moneda en la que llevar&aacute; a cabo su operaci&oacute;n y el valor total de la misma.</small></p>
			<div class="d-flex justify-content-between">
				<select class="selectpicker show-menu-arrow" name="operation_currency" id="operation_currency" data-width="45%">
				<?php foreach($currencies as $k=>$cur):?>
					<?php $selected = $k === $user->user_currency ? 'selected="selected"' : '' ?>
					<option data-tokens="<?=$k?>" value="<?=$k?>" <?=$selected?> ><?= $cur['currencyname']?> -- <?= $cur['currencycode']?></option>
				<?php endforeach?> 
				</select>
				<div class="md-form pl-2 m-2">
					<input type="text" class="form-control bg-white text-primary" name="operation_value" id="operation_value" value="0">
				</div>
			</div>

			<!-- VALOR OPERACION -->
			<div class="form-group">
				
			</div>
		</div>
		<div class="col-lg-8 col-md-6 p-3" id="optype-description"></div>
	</div>

	<!-- REQUERIMIENTO DE DESPACHO, SEGURO, CO, INSPECCION -->
	<div class="alert alert-danger border border-danger rounded">
		<p class="font-italic"><small><i class="fas fa-info-circle"></i> Seleccione las opciones que su solicitud requiera.</i></small></p>
		<div class="checkbox">
			<input type="checkbox" id="custom_clearance" name="custom_clearance" value="0">
			<label for="custom_clearance">Requiere Despacho</label>

			<input type="checkbox" id="require_insurance" name="require_insurance" value="0">
			<label for="require_insurance">Requiere Seguro</label>

			<input type="checkbox" id="require_co" name="require_co" value="0">
			<label for="require_co">Requiere Cert. Origen</label>

			<select class="selectpicker show-menu-arrow" name="inspection_required" id="inspection_required" data-width="auto">
				<option value="no" selected="selected">No requiere inspecci&oacute;n</option>
				<option value="origin">Requiere inspecci&oacute;n en origen</option>
				<option value="destination">Requiere inspecci&oacute;n en destino</option>
				<option value="origin-destination">Requiere inspecci&oacute;n en origen y destino</option>
			</select>
		</div>
		
		<div id="inspection-required" class="d-none">
			<div class="w-25">
				<div class="md-form mb-4">
					<input type="text" class="form-control w-100 text-primary" name="inspection_company" id="inspection_company">
					<label for="inspection_company">Compa&ntilde;a Inspectora</label>
				</div>
			</div>

			<div class="w-25">
				<div class="md-form mb-4">
					<i class="fas fa-pencil-alt prefix"></i>
					<textarea class="form-control md-textarea" id="inspection_notes" name="inspection_notes"></textarea>
					<label for="inspection_notes">Notas</label>
				</div>
			</div>
		</div>
	</div>

	<!-- SISTEMA ARMONIZADO -->
	<div class="alert alert-danger border border-danger rounded d-none" id="container-hs-codes">
		<h5>Sistema Armonizado</h5>
		<p><i>Opcionalmente puede agregar los c&oacute;digos arancelarios que correspondan.</i></p>
		<a role="button" class="btn btn-primary" id="btn-add-hs-row">Agregar C&oacute;digo</a>

		<table class="table table-bordered table-sm" id="tbl-hs-codes">
			<thead class="bg-primary text-white">
				<tr>
					<th>C&oacute;digo</th>
					<th>Valor</th>
					<th>Descripci&oacute;n</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr class="hidden-row d-none">
					<!-- CODIGO -->
					<td>
						<div class="input-group border border-primary rounded">
							<input type="text" class="form-control form-control-sm hs-code">
							<div class="input-group-append">
								<a class="btn btn-primary btn-sm m-0 btn-add-hs-code" role="button" title="Agregar C&oacute;digo"><i class="fas fa-plus"></i></a>
							</div>
						</div>
					</td>
					<!-- VALOR -->
					<td>
						<div class="form-group">
							<input type="text" class="form-control border border-primary hs-value" value="0">
						</div>
					</td>
					<!-- DESCRIPCION -->
					<td>
						<div class="form-group">
							<input type="text" class="form-control border border-primary hs-description" maxlength="20" placeholder="M&aacute;x 20 caracteres">
						</div>
					</td>
					<!-- BOTONERA -->
					<td>
						<a class="btn btn-danger btn-sm btn-delete-row" role="button" title="Eliminar"><i class="fas fa-trash-alt"></i></a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>