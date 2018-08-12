<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina de expiracion de datos
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/es
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : expiration-form.php
|--------------------------------------------------------------------------
|
*/
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>dTransporte.com - P&aacute;gina expirada</title>
		<!--[if lt IE 9]>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv-printshiv.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
		<![endif]-->
		
		<!-- AGREGA LAS HOJAS DE ESTILO -->
		<link rel="stylesheet" href="<?=base_url()?>application/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">

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

			<div class="alert alert-warning" role="alert">
				<h3 class="text-center">La p&aacute;gina ha expirado.</h3>
				<h4 class="text-center">Su per&iacute;odo de validaci&oacute;n ha caducado o sus datos ya han sido validados.</h4>
			</div>

			<p class="alert alert-info" role="alert">El equipo de dTransporte</p>
		</div>

		<script type="text/javascript" src="<?=base_url()?>application/vendor/components/jquery/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>js/popper.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>application/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
	</body>
</html>