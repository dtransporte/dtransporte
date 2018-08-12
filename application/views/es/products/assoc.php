<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina productos assoc (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/products
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : assoc.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
$prodSrc = base_url().'imgs/products/';
$dataPrices = $this->config->item('dtr-service-price');
foreach ($countries as $c) {
	$countryList[$c->iso] = $c->country;
}
?>
<input type="hidden" id="country-text" value='<?=json_encode($countryOptions)?>'>
<input type="hidden" id="eblocks-text" value='<?=json_encode($economicBlocks)?>'>
<input type="hidden" id="countryList-text" value='<?=json_encode($countryList)?>'>
<input type="hidden" name="receive_reqs_from" value='<?= ($productsByUser) ? json_encode($productsByUser) : ""?>'>
<input type="hidden" name="payment_price">
<div class="alert alert-info">
	<p>
		A trav&eacute;s de esta opci&oacute;n usted podr&aacute; seleccionar los servicios que su empresa ofrecer&aacute;.
	</p>
	<p>
		Deber&aacute; seleccionar al menos 1 servicio.
	</p>
	<p>
		Usted tendr&aacute; <?= $this->config->item('dtr-assoc-freedays')?> d&iacute;as libres para uso de la aplicaci&oacute;n desde el momento de su registro.<br>
		<small><b>Su pr&oacute;ximo vencimiento ser&aacute; el <?=$paymentDay?> </b></small>
	</p>
	<p>
		El precio m&iacute;nimo es de <?= $dataPrices['min']?> d&oacute;lares americanos.
	</p>
	<p>
		El precio se incrementar&aacute; a raz&oacute;n de <?= $dataPrices['step']?> d&oacute;lares americanos por categor&iacute;a seleccionada con un m&aacute;ximo de <?= $dataPrices['max']?> d&oacute;lares americanos
	</p>
	<h3 class="alert alert-warning">
		Su precio actual es de <span id="payment-amount"><?=$paymentAmount?></span> d&oacute;lares americanos.
	</h3>
</div>
<br>
<div class="row">
	<div class="col-md-6">
		<div class="accordion" id="products-accordion" role="tablist" data-prices='<?=json_encode($dataPrices)?>'>
			<div class="card">
				<?php foreach($categories as $k => $cat):?>
					<?php $expanded = $k == 0 ? 'true' : 'false';  $clsShow = $k == 0 ? 'show' : ''?>
					<div class="card-header bg-light" role="tab" id="heading-<?=$cat->id_category?>">
						<h5 display-1 class="mb-0">
							<a class="text-dark" role="button" data-toggle="collapse" href="#collapse-<?=$cat->id_category?>" aria-expanded="<?=$expanded?>" aria-controls="<?=$cat->id_category?>">
								Categor&iacute;a - 
								<?=$this->lang->line('category')[$cat->category_name]?> <i class="fas fa-caret-down"></i>
							</a>
						</h5>
					</div>
					<div id="collapse-<?=$cat->id_category?>" class="collapse <?=$clsShow?>" aria-labelledby="heading-<?=$cat->id_category?>" data-parent="#products-accordion">
						<div class="card-body draggable">
							<h5><?=$this->lang->line('category')[$cat->category_name]?></h5>
							<?php foreach($products as $prod):?>
								<?php if($prod->id_category == $cat->id_category):?>
									<?php
										$receiveFrom = [
											'only-my-country'
										];
										if($productsByUser)
										{
											foreach($productsByUser as $p)
											{
												if($p->id_product == $prod->id_product)
												{
													$receiveFrom = json_decode($p->receive_reqs_from);
													break;
												}
											}
										}
										$dataProduct = [
											'id_category' => $cat->id_category,
											'id_product' => $prod->id_product,
											'receiveFrom' => $receiveFrom
										];
									?>
									<div class="media pointer p-2" 
									id="prod-<?=$prod->id_product?>" 
									data-product='<?=json_encode($dataProduct)?>' 
									data-toggle="tooltip" data-placement="auto" title="Arrastre par seleccionar">
										<img class="align-self-center mr-3 rounded" src="<?=$prodSrc?><?=$prod->product_image?>" style="width: 50px; height: 50px">
										<div class="media-body">
											<p>
												<?=$this->lang->line('product')[$prod->product_description]?><br>
												<small><?=$this->lang->line('product')[$prod->product_alt_description]?></small>
											</p>
										</div>
									</div>
								<?php endif?>
							<?php endforeach?>
						</div>
					</div>
				<?php endforeach?>
			</div>
		</div>
	</div>

	<div class="col-md-6" style="border: 1px dashed #999999">
		<h4>Arrastre aqu&iacute; para seleccionar</h4>
		<div id="droppable" style="min-height: 300px">
			<?php if($productsByUserFormatted):?>
				<?php foreach($productsByUserFormatted as $prd):?>
					<?php foreach($products as $product):?>
						<?php
						$receiveFrom = $prd['receiveFrom'];
						if($product->id_product == $prd['id_product'])
						{
							$activeProd = $product;
							break;
						}
						?>
					<?php endforeach?>
					<div class="container-dragged mb-2 alert alert-dark border-dark rounded">
						<div class="row">
							<div class="element-dragged col-6">
								<div id="prod-<?=$prd['id_product']?>" class="media pointer p-2 ui-draggable-handle ui-draggable-dragging" data-product='<?=json_encode($prd)?>'>
									<img class="align-self-center mr-3 rounded" src="<?=base_url()?>imgs/products/<?=$activeProd->product_image ?>" style="width: 50px; height: 50px">

									<div class="media-body">
										<p>
											<?=$this->lang->line('product')[$activeProd->product_description] ?><br>
											<small><?=$this->lang->line('product')[$activeProd->product_alt_description] ?></small>
										</p>
									</div>
								</div>
							</div>

							<div class="col-6">
								<span class="p-1 pointer">Ud. recibir&aacute; solicitudes desde: </span> 
								<ul class="txt-selected-countries">
									<?php foreach($prd['receiveFrom'] as $from):?>
										<li><?=$prd['receiveFromTxt'][$from]?></li>
									<?php endforeach?>
								</ul>
							</div>
						</div>

						<div class="row">
							<div class="col-12">
								<a class="btn btn-warning float-left change-item" role="button" data-toggle="tooltip" data-placement="auto" data-trigger="hover" title="Click aqu&iacute; para restringir las opciones de recepci&oacute;n de solicitudes">Restringir</a>
								<a class="btn btn-danger float-right delete-full-item" role="button" data-toggle="tooltip" data-placement="auto" data-trigger="hover" title="Eliminar Servicio"><i class="fas fa-trash-alt"></i></a>
							</div>
						</div>
					</div>
				<?php endforeach?>
			<?php endif?>
		</div>
	</div>
</div>

<div class="d-none" id="hidden-drags">
	<div class="container-dragged mb-2 alert alert-dark border-dark rounded">
		<div class="row">
			<div class="element-dragged col-6"></div>
			<div class="col-6">
				<span class="p-1 pointer">Ud. recibir&aacute; solicitudes desde: </span> 
				<!-- <span class="d-inline-block p-1 txt-selected-countries font-weight-bold text-danger"></span> -->
				<ul class="txt-selected-countries"></ul>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<a class="btn btn-warning float-left change-item" role="button" title="Click aqu&iacute; para restringir las opciones de recepci&oacute;n de solicitudes">Restringir</a>
				<a class="btn btn-danger float-right delete-item" role="button" title="Eliminar Servicio"><i class="fas fa-trash-alt"></i></a>
			</div>
		</div>
	</div>
</div>