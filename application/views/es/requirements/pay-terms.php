<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina terminos de pago solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : pay-terms.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
?>
<h5 class="alert alert-light">
	Seleccione la moneda y los t&eacute;rminos en los que har&aacute; efectivo su pago.<br>
</h5>
<p class="alert alert-warning">Ej: Cheque <span class="text-muted"> &lt;nombre banco&gt; </span> a 7 d&iacute;as. Tarjeta cr&eacute;dito Visa, etc. 
<span class="font-weight-bold font-italic">Bajo ning&uacute;n concepto introduzca los n&uacute;meros de sus tarjetas.</span></p>
<p>Si deja el campo <i class="fas fa-hand-holding-usd"></i> <u>Forma Pago</u> en blanco se asumir&aacute; como efectivo.</p>
<div class="alert alert-light">
	<div class="row">
		<div class="col-sm-6">
			<!-- SELECTOR DE MONEDAS -->
			<div class="form-group">
				<h5><i class="fas fa-dollar-sign"></i> <u>Moneda</u></h5>
				<select class="selectpicker show-menu-arrow" name="requirement_currency" data-width="100%">
				<?php foreach($currencies as $k=>$cur):?>
					<?php $selected = $k === $user->user_currrency ? 'selected="selected"' : '' ?>
					<option data-tokens="<?=$k?>" value="<?=$k?>" <?=$selected?> ><?= $cur['currencyname']?> -- <?= $cur['currencycode']?></option>
				<?php endforeach?>
				</select>
			</div>
		</div>
	
		<div class="col-sm-6">
			<h5><i class="fas fa-hand-holding-usd"></i> <u>Forma Pago</u></h5>
			<p><i>M&aacute;ximo 100 caracteres.</i></p>
			<div class="md-form form-lg mb-4">
				<i class="fas fa-hand-holding-usd prefix"></i>
				<textarea class="form-control md-textarea" name="requirement_pay_terms" maxlength="100"></textarea>
			</div>
		</div>
	</div>
</div>