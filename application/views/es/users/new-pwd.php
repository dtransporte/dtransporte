<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina publica formulario de cambio de contrasenia (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : new-pwd.php
|--------------------------------------------------------------------------
|
*/
$this->load->helper('captcha');
$csrf_pwd = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);
$pwdSettings = $this->config->item('dtr-password');
$data['captcha'] = create_captcha($this->init->setCaptcha());
$data['captchaSettings'] = $this->config->item('dtr-captcha');
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>dTransporte.com - Reseteo de contrase&ntilde;a</title>
		<!--[if lt IE 9]>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv-printshiv.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
		<![endif]-->
		
		<!-- AGREGA LAS HOJAS DE ESTILO -->
		<link rel="stylesheet" href="<?=base_url()?>application/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

		<style type="text/css">
			.dtr{
				background: #333333;
			}
		</style>
	</head>
	<body>
		<div class="container">
		<div class="alert dtr">
			<?php $src= base_url().'imgs/logo-dtransporte.png'?>
			<img src="<?= $src?>" class="img-responsive">
		</div>
		<?php if(isset($user)):?>
			<h2>Cambiar Contrase&ntilde;a</h2>
			<?php if(isset($message)):?>
			<h2 class="alert alert-warning"><?=$message?></h2>
			<?php endif?>
			<p class="alert alert-warning">
				La contrase&ntilde;a debe tener una longitud m&iacute;nima de <?= $pwdSettings['minlength']?> caracteres y una longitud m&aacute;xima de <?= $pwdSettings['maxlength']?> caracteres
			</p>
			<form id="frm-new-pwd" role="form" method="post" action="<?= $action?>">
				<input type="hidden" name="<?=$csrf_pwd['name'];?>" value="<?=$csrf_pwd['hash'];?>" >
				<input type="hidden" name="id_user" value="<?= $user->id_user?>">
				<input type="hidden" name="hash" value="<?= $hash?>">
				<input type="hidden" name="captcha-word" id="captcha-word" value="<?= $data['captcha']['word']?>">
				<div class="alert alert-light">
					<div class="form-group">
						<label for="new-pwd">Ingrese Contrase&ntilde;a</label>
						<input type="password" class="form-control form-control-lg" name="new-pwd" id="new-pwd" required 
						placeholder="Campo Requerido" 
						>
					</div>

					<div class="form-group">
						<label for="rnew-pwd">Reingrese Contrase&ntilde;a</label>
						<input type="password" class="form-control form-control-lg" name="rnew-pwd" id="rnew-pwd" 
						data-match="new-pwd" data-message="<?=$minMaxPwd['msg']?>" data-min="<?=$minMaxPwd['min']?>" data-max="<?=$minMaxPwd['max']?>" required data-checkPwdLength
						>
					</div>

					<div class="form-group">
					<?php $this->load->view('captcha', $data)?>
					</div>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Cambiar Contrase&ntilde;a</button>
				</div>
			</form>
		<?php else:?>
			<h1 class="alert alert-success">Su contrase&ntilde;a ha sido exitosamente actualizada.</h1>
		<?php endif?>
		</div>

		<script type="text/javascript" src="<?=base_url()?>application/vendor/components/jquery/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>js/popper.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>application/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?= base_url()?>js/form-validator.js"></script>
		<script type="text/javascript" src="<?= base_url()?>js/validatr.min.js"></script>
		<script type="text/javascript" src="<?= base_url()?>js/captcha.js"></script>
		<script type="text/javascript" src="<?= base_url()?>js/ajax.js"></script>
		<script type="text/javascript" src="<?= base_url()?>js/message.js"></script>
		<script type="text/javascript" src="<?= base_url()?>js/loading-bar.js"></script>
		<script type="text/javascript">
			var BaseUrl = '<?= base_url()?>';
			var DomRootEl = $(document.body);
			var form = DomRootEl.find('form');
			$(function(){
				$('[data-toggle="tooltip"]').tooltip({html: true});
				$('#btn-refresh-captcha').on('click', function(){
					Captcha.refresh($('#frm-new-pwd'))
				});
				$(form).validatr({
					location: 'left',
					theme: 'bootstrap',
					template: '<div class="bg-danger text-white">{{message}}</div>',
					// valid: function(){
					// 	_update(form, url)
					// 	return false
					// }
				});
				_validatePwd(form);
			})
		</script>
	</body>
</html>