<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina ranking usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : modal-ranking.php
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
	<input type="hidden" name="id_requirement" value="<?=$id_requirement?>">
	<div class="alert alert-primary">
		<h5>Ranking Solicitud <?=$requirement_name?></h5>
		<p><?=$company?></p>
		<div id="ranking-concepts" data-ranking-values='<?=json_encode($ranking_values)?>'>
			<p class="font-weight-bold">Total: <span id="total-ranking"><?= $ranking_values['min']?></span></p>
			<?php foreach($ranking_concepts as $k => $concept):?>
				<div>
					<input type="hidden" name="<?=$k?>">
					<p class="d-flex justify-content-between">
						<?= $this->lang->line($concept)?>
						<span class="ranking-value font-weight-bold"><?= $ranking_values['min']?></span>
					</p>
					<div class="slider mb-3 bg-primary" style="height: 10px"></div>
				</div>
			<?php endforeach?>
		</div>

		<div class="md-form">
			<i class="far fa-comments prefix"></i>
			<textarea type="text" id="rank_post" name="rank_post" class="form-control md-textarea" rows="3"></textarea>
			<label for="rank_post">Postear un comentario</label>
		</div>
	</div>
</form>