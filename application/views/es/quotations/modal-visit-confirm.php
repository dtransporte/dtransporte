<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina confirmacion visita usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/quotations
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : modal-visit-confirm.php
|--------------------------------------------------------------------------
|
*/
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);
?>
<form>
	<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" >
	<input type="hidden" name="id_requirement">
	<input type="hidden" name="quotation_qrcode" value="<?=$qrText?>">
	<input type="hidden" name="quotation_code" value="<?=$quotation_code?>">
	<div class="text-center alert alert-primary d-flex justify-content-between">
		<div class="mr-4"><i class="fas fa-envelope fa-4x animated rotateIn"></i></div>
		<div>
			<p>La confirmaci&oacute;n de visita <?=$quotation_code?> ser&aacute; enviada a su destinatario.</p>
		</div>
	</div>
</form>