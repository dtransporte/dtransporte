<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina resumen cotizacion assoc (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/quotations
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : modal-resume.php
|--------------------------------------------------------------------------
|
*/
$qrSrc = base_url()."dtr-quotations/{$quotation[0]->id_quotation}/qrcode/qrcode.png";
$dtf = str_replace(':%s', '', $this->init->activeUser->dtf);
$total = 0;
?>

<div class="container-fluid">
	<div class="media">
		<img class="mr-3" src="<?= $qrSrc?>" style="max-width: 100px">
		<div class="media-body font-weight-bold">
			<h5>C&oacute;digo: <?=$quotation[0]->quotation_code?></h5>
			<p>Estado: <?=$this->lang->line('dtr-quotation-status')[$quotation[0]->quotation_status]?></p>
			<p>Empresa: <?=$companyName?></p>
		</div>
	</div>

	<p>Fecha Alta: <?= mdate($dtf, mysql_to_unix($quotation[0]->quotation_entered))?></p>
	<?php if(!empty($quotation[0]->quotation_sent)):?>
		<p>Fecha Env&iacute;o: <?= mdate($dtf, mysql_to_unix($quotation[0]->quotation_sent))?></p>
	<?php endif ?>
	<?php if(!empty($quotation[0]->quotation_cancelation)):?>
		<p>Fecha Cancelaci&iacute;on: <?= mdate($dtf, mysql_to_unix($quotation[0]->quotation_cancelation))?></p>
	<?php endif ?>
	<p>Moneda: <?=$currencies[$quotation[0]->requirement_currency]['currencycode']?> - <?=$currencies[$quotation[0]->requirement_currency]['currencyname']?></p>
	<p>C&oacute;digo QR: <?= $quotation[0]->quotation_qrcode?></p>

	<?php if($showConcepts === TRUE):?>
		<div class="alert alert-light">
			<h5 class="font-weight-bold">Detalles Cotizaci&oacute;n</h5>
			<?php if(!empty($quotation[0]->quotation_etd)):?>
				<div class="d-flex justify-content-between">
					<p>ETD: <?= mdate($dtf, mysql_to_unix($quotation[0]->quotation_etd.' 00:00:00'))?></p>
					<p>ETA: <?= mdate($dtf, mysql_to_unix($quotation[0]->quotation_eta.' 00:00:00'))?></p>
				</div>			
			<?php endif ?>

			<div class="container-fluid">
				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th>Concepto</th>
							<th>Valor</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($quotation as $q):?>
							<?php $total += (int) $q->concept_value?>
							<tr>
							 <td><?=$q->concept_name?></td>
							 <td><?=$q->concept_value?></td>
							</tr>
						<?php endforeach?>
					</tbody>
				</table>
				<h5 class="font-weight-bold">Notas: <?=$quotation[0]->quotation_notes?></h5>
				<br>
				<h4 class="font-weight-bold">Total Cotizado: <?=$total?></h4>
			</div>
		</div>
	<?php endif?>
</div>
