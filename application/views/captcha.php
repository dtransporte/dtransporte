<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| captcha - Fragmento vista captcha
| -------------------------------------------------------------------------
|
| -------------------------------------------------------------------------
| Ubicacion
|	application/views
| -------------------------------------------------------------------------
*/
?>

<div class="form-group">
	<label for="dtr-captcha">Ingrese C&oacute;digo</label>
	<div class="input-group input-group-sm mb-3">
		<input type="text" name="dtr-captcha" id="dtr-captcha" class="form-control" required data-match="captcha-word" data-message="<?=$this->lang->line('dtr-error-match-captcha')?>">
		<div class="input-group-append">
			<a class="btn btn-secondary" id="btn-refresh-captcha"
				data-toggle="tooltip" 
				data-placement="bottom" 
				title="Refrescar im&aacute;gen"
			>
				<span class="fas fa-sync-alt"></span>
			</a>
		</div>
		<div class="input-group-append">
			<span class="ml-2" id="image-captcha"><?= $captcha['image']?></span>
		</div>
	</div>
</div>