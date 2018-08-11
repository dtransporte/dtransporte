<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina productos role user (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/products
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : modal-show.php
|--------------------------------------------------------------------------
|
*/
$imgSrc = base_url().'imgs/products/';
$url = base_url().'index.php/Requirements/add/index/'
?>
<div id="container-fluid">
	<?php foreach($categories as $cat):?>
		<div class="d-block">
			<h4 class="alert alert-dark">Categor&iacute;a - <?=$this->lang->line('category')[$cat->category_name]?></h4>
		</div>
		<?php foreach($products as $prod):?>
			<?php if($cat->id_category == $prod->id_category):?>
				<div class="card text-center rounded d-inline-block p-0 mb-2 w-25" style="min-width: 150px; box-shadow: none;">
					<img src="<?=$imgSrc?><?=$prod->product_image?>" class="mx-auto d-block pt-1" style="width: 60px; height: 60px">
					<div class="card-body">
						<p class="card-text">
							<?=$this->lang->line('product')[$prod->product_description]?><br>
							<small><?=$this->lang->line('product')[$prod->product_alt_description]?></small>
						</p>
						<?php if(!empty($prod->product_attribs)):?>
							<?php $attributes = explode(',', $prod->product_attribs) ?>
							<?php foreach($attributes as $attr):?>
								<?php $dataProduct = ['id_product'=> $prod->id_product, 'attributes' => $attr]?>
								<a class="btn btn-sm btn-primary d-inline-block btn-new-requirement" role="button" href="<?=$url?><?=$prod->id_product?>/<?=$attr?>" data-product='<?=json_encode($dataProduct)?>' data-toggle="tooltip" data-placement="auto" data-trigger="hover" title="<?=$this->lang->line('product-attribute')[$attr]['message']?>">
									<?=$this->lang->line('product-attribute')[$attr]['title']?>
								</a>
							<?php endforeach?>
						<?php else:?>
							<?php $dataProduct = ['id_product'=> $prod->id_product]?>
							<a class="btn btn-sm btn-primary d-inline-block btn-new-requirement" role="button" href="<?=$url?><?=$prod->id_product?>" data-product='<?=json_encode($dataProduct)?>'>
								Agregar
							</a>
						<?php endif?>
						
					</div>
				</div>
			<?php endif?>
		<?php endforeach?>
	<?php endforeach?>
</div>