<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina agregar solicitud role user (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : add.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
$product_description = $this->lang->line('product')[$product->product_description];
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);
?>
<br>
<div class="container-fluid" id="container">
	<h3 class="alert border border-secondary border-top-0 border-left-0 border-right-0 text-secondary">
		<i class="fas fa-window-maximize"></i> Nueva Solicitud <small><?=$product_description?></small> 
	</h3>
	<div class="d-flex justify-content-between">
		<a class="btn btn-default" role="button" href="<?=base_url()?>Place/User">
			<i class="fas fa-angle-double-left"></i> Volver
		</a>
		<div class="btn-group" role="group">
			<div class="dropdown">
				<a class="btn btn-primary dropdown-toggle" role="button" id="btn-show-resume" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-plus"></i> Agregar Solicitud
				</a>
				<div class="dropdown-menu" aria-labelledby="btn-show-resume">
					<a class="dropdown-item btn-send-req" href="#" id="btn-send-requirement"><i class="fas fa-envelope"></i> Enviar Ahora</a>
					<!-- <a class="dropdown-item btn-send-req" href="#" id="btn-prog-requirement"><i class="fas fa-clock"></i> Programar Env&iacute;o</a> -->
					<a class="dropdown-item btn-send-req" href="#" id="btn-save-requirement"><i class="fas fa-save"></i> Solo Guardar</a>
				</div>
			</div>
		</div>
	</div>
	<br>
	<ul class="nav nav-tabs nav-fill dtr-tabs" id="requirements-tabs" role="tablist">
		<?php foreach($requirementsViews as $key=>$tab):?>
			<?php $active = $key === 'info' ? 'active' : '' ?>
			<li class="nav-item">
				<a class="nav-link <?= $active?>" id="<?=$tab['tabId']?>" data-toggle="tab" href="#tab<?=$key?>" role="tab" aria-controls="aria-<?=$key?>" aria-selected="true">
					<i class="<?=$tab['tabIcon']?>"></i> <?=$tab['tabTitle']?>
				</a>
			</li>
		<?php endforeach?>
	</ul>

	<form id="frm-add-requirement">
		<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" >
		<input type="hidden" name="requirement_status" id="requirement_status">
		<input type="hidden" name="id_product" value="<?=$product->id_product?>">
		<input type="hidden" name="requirement_qrcode" value="<?=$qrText?>">
		<div class="tab-content">
			<?php foreach($requirementsViews as $key=>$tab):?>
				<?php $active = $key === 'info' ? 'active show' : '' ?>
				<div class="tab-pane fade <?= $active?>" id="tab<?=$key?>" role="tabpanel" aria-labelledby="<?=$tab['tabId']?>">
					<br>
					<div class="container-fluid mr-2 mt-2">

						<?php foreach($tab['views'] as $k=>$view):?>
							<?php if($key != 'attributes' AND file_exists(FCPATH.'application/views/'.$view.'.php')):?>
								<?php $this->load->view($view)?>
							<?php endif?>
						<?php endforeach?>
					</div>
				</div>
			<?php endforeach?>
		</div>
	</form>
</div>