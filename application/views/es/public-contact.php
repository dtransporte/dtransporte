<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina publica formulario de contacto (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : contact-form.php
|--------------------------------------------------------------------------
|
*/
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);
$action = base_url().'index.php/contact';
$icon = $this->lang->line('dtr-public-menu')['contact']['icon'];
?>
<div class="container" id="public-contact">
	<hr>
	<h1 class="display-4 d-none d-sm-block"><span class="<?=$icon?>"></span> Cont&aacute;ctenos</h1>
	<h1 class="d-md-none"><span class="<?=$icon?>"></span> Cont&aacute;ctenos</h1>
	<form role="form" id="frm-contact" method="post" action="<?= $action?>" class="alert alert-secondary">
		<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
		
		<!-- NOMBRE COMPLETO -->
		<div class="md-form form-lg mb-4">
			<i class="fa fa-user prefix"></i>
			<input type="text" class="form-control" id="ctc_fullname" name="ctc_fullname" required>
			<label for="ctc_fullname">Nombre Completo</label>
		</div>
		<br>
		<!-- CORREO ELECTRONICO -->
		<div class="md-form form-lg mb-4">
			<i class="fa fa-envelope prefix"></i>
			<input type="email" class="form-control" id="ctc_email" name="ctc_email" required >
			<label for="ctc_email">Correo Electr&oacute;nico</label>
		</div>
		<br>
		<!-- ASUNTO -->
		<div class="md-form form-lg mb-4">
			<i class="fas fa-comment prefix"></i>
			<input type="text" class="form-control" id="ctc_subject" name="ctc_subject" required>
			<label for="ctc_subject">Asunto</label>
		</div>
		<br>
		<!-- MENSAJE -->
		<div class="md-form form-lg mb-4">
			<i class="fas fa-pencil-alt prefix"></i>
			<textarea class="form-control md-textarea" 
			name="ctc_message" 
			id="ctc_message" required 
			>
			</textarea>
			<label for="ctc_message">Mensaje</label>
		</div>
		
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-lg btn-block" id="btn-contact" type="submit">
			<span class="fa fa-envelope" aria-hidden="true"></span>&nbsp;
			Enviar
			</button>
		</div>
	</form>
</div>
<br>
<hr>