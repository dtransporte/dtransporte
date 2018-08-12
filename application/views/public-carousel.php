<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$urlImg = base_url().'imgs/slider/';
?>
<div id="carousel-public" class="carousel slide opaque" data-ride="carousel">
	<div class="carousel-inner">
		<?php foreach($sliders as $k=>$img):?>
			<?php $class = $k==0 ? 'carousel-item active' : 'carousel-item'?>
			<div class="<?= $class?>">
				<img src="<?=$urlImg.$img?>" class="img-fluid mx-auto d-block w-100" style="max-height: 100%">
				<div class="carousel-caption d-none d-md-block opaque-black">
					<h3 class="text-center p-2 display-4">
						<b>Reg&iacute;strese <i class="fa fa-play"></i> Contrate <i class="fa fa-play"></i> Cargue</b>
					</h3>
				</div>
			</div>
		<?php endforeach;?>
	</div>
</div>