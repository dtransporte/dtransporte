<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| VISTA PRINCIPAL
| -------------------------------------------------------------------
| Este archivo es el punto de entrada para todas las vistas
|
*/
$base_url = base_url();
$globalFiles = $this->config->item('dtr-global-files');
$cookieAccept = $this->config->item('dtr-cookie-accept');
$blockScr = isset($this->init->activeUser) ? $this->init->activeUser->user_block_scr_duration : 0;
?>
<!DOCTYPE html>
<html lang="<?= $this->init->activeLang?>">

	<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Transporte, Logistica, Depositos">
	<meta name="author" content="Marcelo Mossian">

	<title>dTransporte - La mayor red de transporte del mercosur.</title>

	<link rel="shortcut icon" href="<?php $base_url ?>imgs/favicon.png" type="image/x-icon">
	
	<!-- Chequea si requiere bootstrap 3. Utilizado para bootstrap tables -->
	<?php if(isset($activePage['require-bs3']) AND $activePage['require-bs3'] === TRUE):?>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<?php endif?>

	<!-- Archivos CSS -->
	<?php foreach($globalFiles['css'] as $css):?>
		<link href="<?=$base_url?><?=$css?>" rel="stylesheet">
	<?php endforeach?>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

	<!-- Estilos asociados a la pagina -->
	<?php foreach($activePage['css'] as $css):?>
		<link href="<?=$base_url?><?=$css?>" rel="stylesheet">
	<?php endforeach?>
	
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?language=es&amp;key=AIzaSyAOmIqx9Zvyo8bTXGOLFhKFuZKGb8h525w&amp;v=3&amp;libraries=places" async defer></script>
	</head>

	<body id="top">
		<!-- Carga vista de mensaje -->
		<?php $this->load->view('inline-message')?>
		
		<!-- Carga vistas asociadas a la pagina -->
		<?php foreach($activePage['views'] as $view):?>
			<?php $v = str_replace('%lang%', $this->init->activeLang, $view) ?>
			<?php $this->load->view($v)?>
		<?php endforeach?>

		<!-- Carga la vista aceptar cookies -->
		<?php if(get_cookie($cookieAccept['name']) === NULL AND !isset($this->init->activeUser)):?>
		<?php $this->load->view($this->init->activeLang.'/cookies-policy')?>
		<?php endif?>

		<!-- Archivos JS -->
		<?php foreach($globalFiles['js'] as $js):?>
			<script type="text/javascript" src="<?=$base_url?><?=$js?>"></script>
		<?php endforeach?>
		<?php foreach($activePage['js'] as $js):?>
			<?php $v = str_replace('%lang%', $this->init->activeLang, $js) ?>
			<script type="text/javascript" src="<?=$base_url?><?=$v?>"></script>
		<?php endforeach?>

		<!-- Variables JS -->
		<script type="text/javascript">
			var ActivePage = "<?=$activePage['idPage']?>",
				BaseUrl = "<?=$base_url?>",
				CurUrl = "<?=current_url()?>",
				ActiveLang = "<?=$this->init->activeLang?>",
				IsMobile =  <?=$this->init->isMobile?>,
				TextRedirect = '<?=$this->lang->line('text-redirect')?>',
				UserRole = "<?= isset($this->init->activeUser) ? $this->init->activeUser->user_role : ''?>",
				FontFamily = "<?= isset($this->init->activeUser) ? $this->init->activeUser->user_font_family : ''?>",
				FontSize = "<?= isset($this->init->activeUser) ? $this->init->activeUser->user_font_size : ''?>",
				Uid = <?= isset($this->init->activeUser) ? $this->init->activeUser->id_user : 0?>,
				BlockScreen = <?=$blockScr?>,
				ScrBlocked = <?= isset($_SESSION['DTR-BLOCK-SCREEN']) ? 1 : 0?>,
				DomRootEl = $(document.body);
				<?php if(isset($activePage['fns']) > 0):?>
					<?php foreach($activePage['fns'] as $fns):?>
						<?= $fns."\n"?>
					<?php endforeach?>
				<?php endif?>
				
		</script>
	</body>
</html>