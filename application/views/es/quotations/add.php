<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina agregar solicitud role user (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/es/quotations
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : add.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
$product_description = $this->lang->line('product')[$product->product_description];
$category_description = $this->lang->line('category')[$product->category_name];
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);
$dataReq = json_encode([
	'id_requirement' => $requirement[0]->id_requirement,
	'requirement_name' => $requirement[0]->requirement_name
])
?>
<br>
<div class="container-fluid" id="container">
	<input type="hidden" id="data-requirement" value='<?=$dataReq?>'>
	<h3 class="alert border border-secondary border-top-0 border-left-0 border-right-0 text-secondary">
		<i class="fas fa-window-maximize"></i> Nueva Cotizaci&oacute;n <small><?=$product_description?></small>
	</h3>
	<br>
	<div class="media container">
		<img class="m-2" src="<?=$qrImageSrc?>" style="max-width: 100px">
		<div class="media-body">
			<h5>Nombre de la Solicitud: <span class="font-weight-bold"><?=$requirement[0]->requirement_name?></span> - 
			<span class="font-weight-bold text-muted"><?=$category_description?></span></h5>
			<h5 class="text-danger">
				Esta solicitud debe ser cotizada en <span class="font-weight-bold"><?=$currency['currencycode']?> <?=$currency['currencyname']?></span>
			</h5>
			<p>C&oacute;digo QR: <span class="font-weight-bold"><?=$qrText?></span></p>
			<h5 class="text-danger">ID Cotizaci&oacute;n: <?=$quotation_code?></h5>
		</div>
	</div>

	<br>
	<div class="container btn-toolbar justify-content-between" role="toolbar">
		<div class="btn-group" role="group">
			<a role="button" class="btn btn-primary dropdown-toggle" id="btn-send-quotation" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-plus"></i> Cotizar
			</a>
			<div class="dropdown-menu" aria-labelledby="btn-send-quotation">
				<a class="dropdown-item send-quotation" role="button" id="btn-send"><i class="fas fa-envelope"></i> Enviar Ahora</a>
				<a class="dropdown-item send-quotation" role="button" id="btn-save"><i class="fas fa-save"></i> Solo Guardar</a>
			</div>
			<a role="button" class="btn btn-light" id="btn-show-requirement" data-toggle="tooltip" data-placement="auto" data-trigger="hover" title="Mostrar Solicitud">
				<i class="fas fa-eye"></i>
			</a>

			<!-- MUESTRA EL BOTON MOSTRAR RUTA -->
			<?php if(!in_array($product->id_product, $prodNoRoute) OR $requirement[0]->cargo_product_type === 'visit-required'):?>
				<a role="button" class="btn btn-light" id="btn-show-route" data-toggle="tooltip" data-placement="auto" data-trigger="hover" title="Mostrar Ruta">
					<i class="fas fa-road"></i>
				</a>
				<!-- MUESTRA DIRECCIONES DE ORIGEN, DESTINO Y WAYPOINTS -->
				<div id="origin-address">
					<?php foreach($requirement as $req):?>
						<?php if($req->address_type === 'origin'):?>
							<input type="hidden" name="o-latitude" value="<?=$req->latitude?>">
							<input type="hidden" name="o-longitude" value="<?=$req->longitude?>">
						<?php endif?>
					<?php endforeach?>
				</div>
				<div id="destination-address">
					<?php foreach($requirement as $req):?>
						<?php if($req->address_type === 'destination'):?>
							<input type="hidden" name="d-latitude" value="<?=$req->latitude?>">
							<input type="hidden" name="d-longitude" value="<?=$req->longitude?>">
						<?php endif?>
					<?php endforeach?>
				</div>
				<div id="wp-cloned">
					<div class="row">
						<?php foreach($requirement as $req):?>
							<?php if($req->address_type === 'waypoint'):?>
								<input type="hidden" class="autocomplete" value="<?=$req->address?>">
							<?php endif?>
						<?php endforeach?>
					</div>
				</div>
			<?php endif?>
		</div>

		<div class="btn-group w-25" role="group">
			<a role="button" class="btn btn-default btn-block" href="<?=base_url()?>index.php/Place/Assoc">
				<i class="fas fa-hand-point-left"></i> Volver
			</a>
		</div>
	</div>
	<br>
	<form id="frm-add-quotation">
		<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" >
		<input type="hidden" name="quotation_status" id="quotation_status">
		<input type="hidden" name="id_requirement" id="id_requirement" value="<?=$requirement[0]->id_requirement?>">
		<input type="hidden" name="quotation_qrcode" id="quotation_qrcode" value="<?=$qrText?>">
		<input type="hidden" name="quotation_code" id="quotation_code" value="<?=$quotation_code?>">
		<div class="container alert alert-success">
			<a role="button" class="btn btn-success" id="btn-add-concept">Agregar Concepto</a>
			<?php if($product->id_product == 9 OR $product->id_product == 10 OR $product->id_product == 16):?>
				<input type="hidden" name="quotation_etd" id="quotation_etd" value="<?= mdate($this->config->item('dtr-date-db'), mysql_to_unix($requirement[0]->requirement_expiration)+24*3600)?>">
				<input type="hidden" name="quotation_eta" id="quotation_eta" value="<?= mdate($this->config->item('dtr-date-db'), mysql_to_unix($requirement[0]->requirement_expiration)+24*7200)?>">
				<div id="container-service-dates" class="d-flex justify-content-between alert alert-light">
					<div>
						<h5>ETD</h5>
						<div class="md-form form-lg mb-4 mt-0">
							<input type="text" class="form-control text-primary" id="quotation-etd" data-etd="<?= mysql_to_unix($requirement[0]->requirement_expiration)?>">
						</div>
					</div>
					<div>
						<h5>ETA</h5>
						<div class="md-form form-lg mb-4 mt-0">
							<input type="text" class="form-control text-primary" id="quotation-eta">
						</div>
					</div>
				</div>
			<?php endif?>
			
			<div class="d-flex justify-content-between">
				<div class="w-75">
					<table class="table table-hover table-striped" id="tbl-concepts">
						<thead>
							<tr>
								<th class="font-weight-bold">Concepto</th>
								<th class="font-weight-bold">Valor</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<input type="text" class="form-control concept_name" name="concept_name[]" maxlength="50" placeholder="M&aacute;x 50 caracteres">
								</td>
								<td>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><?=$currency['currencycode']?></span>
										</div>
										<input type="number" class="form-control concept_value" name="concept_value[]" min="0" step="1" value="0">
										<div class="input-group-append d-none">
											<a role="button" class="btn btn-sm btn-danger btn-delete-concept"><i class="fas fa-trash"></i></a>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="pl-2">
					<h5>Items de Control</h5>
					<?php if(!empty($requirement[0]->cargo_additionals)):?>
						<?php $additionals = json_decode($requirement[0]->cargo_additionals)?>
						<?php foreach($additionals as $k=>$v):?>
							<p class="pointer items-check text-danger"><i class="fas fa-check"></i> Requiere <?=$v->name?></p>
						<?php endforeach?>
					<?php endif?>

					<?php if(isset($requirement[0]->id_operationtype)):?>
						<?php if($requirement[0]->custom_clearance == 1):?>
							<p class="pointer items-check text-danger"><i class="fas fa-check"></i> Requiere Despacho Aduanero</p>
						<?php endif?>
						<?php if($requirement[0]->require_insurance == 1):?>
							<p class="pointer items-check text-danger"><i class="fas fa-check"></i> Requiere Seguro</p>
						<?php endif?>
						<?php if($requirement[0]->require_co == 1):?>
							<p class="pointer items-check text-danger"><i class="fas fa-check"></i> Requiere Cert. Origen</p>
						<?php endif?>
						<?php if($requirement[0]->inspection_required != 'no'):?>
							<p class="pointer items-check text-danger"><i class="fas fa-check"></i> Requiere Inspecci&oacute;n</p>
						<?php endif?>
					<?php endif?>
				</div>
			</div>

			<fieldset><legend><u>Notas</u></legend>
				<p><i>M&aacute;x 100 caracteres.</i></p>
				<div class="md-form form-lg mb-4 shadow-textarea">
					<i class="fas fa-pencil-alt prefix"></i>
					<textarea class="form-control md-textarea" name="quotation_notes" maxlength="100"></textarea>
				</div>
			</fieldset>
		</div>
	</form>
</div>