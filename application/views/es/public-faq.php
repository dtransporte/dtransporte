<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina publica preguntas frecuentes (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/es
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : faq.php
|--------------------------------------------------------------------------
|
*/
$icon = $this->lang->line('dtr-public-menu')['faq']['icon'];
?>
<div class="container" id="public-faq">
	<hr>
	<h1 class="display-4 d-none d-sm-block"><span class="<?=$icon?>"></span> Preguntas Frecuentes</h1>
	<h1 class="d-md-none"><span class="<?=$icon?>"></span> Preg. Frec.</h1>
	<div id="faq-accordion" class="accordion" role="tablist">
		<?php foreach($faq as $k => $f):?>
			<?php $expanded = $k == 0 ? 'true' : 'false'?>
			<div class="card">
				<div class="card-header" role="tab" id="heading<?= $k?>">
					<h5 class="mb-0">
						<a data-toggle="collapse" href="#collapse<?=$k ?>" aria-expanded="<?=$expanded?>" aria-controls="collapse<?=$k ?>">
							<?= $f['title']?>
						</a>
					</h5>
				</div>
			
				<div id="collapse<?= $k?>" class="collapse" role="tabpanel" aria-labelledby="heading<?= $k?>" data-parent="#faq-accordion">
					<div class="card-body"><?= $f['content']?></div>
				</div>
			</div>
		<?php endforeach?>
	</div>
</div>