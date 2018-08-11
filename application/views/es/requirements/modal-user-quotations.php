<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Vista cotizaciones asociadas a una solicitud
|--------------------------------------------------------------------------
| Ubicacion: application/views/es/requirements
| 
|
*/
?>
<div class="card z-depth-0 mb-3">
	<div class="card-header pointer" id="operation-details">Detalles Operaci&oacute;n <i class="fas fa-angle-double-down"></i></div>
	<div class="card-body">
		<div class="d-flex justify-content-between">
			<?php if(count($operationType) > 0):?>
				<div>
					<p class="card-text">Tipo: <?= $this->lang->line('dtr-operation-type')[$operationType->operation_type] ?></p>
					<p class="card-text">Incoterm: <?= $this->lang->line('dtr-incoterms')[$operationType->operation_incoterm]['name'] ?></p>
					<p class="card-text">Moneda: <?= $currencies[$operationType->operation_currency]['currencycode'] ?></p>
					<p class="card-text">Valor: <?= $operationType->operation_value?></p>
				</div>
			<?php endif?>
			<?php if(!empty($cargoDetails->cargo_additionals)):?>
				<?php $additionals = json_decode($cargoDetails->cargo_additionals) ?>
				<div>
					<h5>Servicios Adicionales</h5>
					<?php foreach($additionals as $a):?>
					<p><?= $a->name?> <?= $a->quantity?></p>
					<?php endforeach?>
				</div>
			<?php endif?>
		</div>
	</div>
</div>
<table></table>

<div class="d-none" id="hidden-data">
	<div class="alert alert-danger">
		<h5>Confirma que desea cerrar la solicitud quotation-code con la empresa company-name?</h5>
		<a role="button" class="close-quotation btn btn-lg btn-danger rounded no-print" id="btn-close-requirement"><i class="fas fa-check-double"></i> Cerrar Solicitud</a>
	</div>
</div>