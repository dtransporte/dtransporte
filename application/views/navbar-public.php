<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| BARRA DE NAVEGACION
| -------------------------------------------------------------------
| 
|
*/
$navBarImg = base_url()."imgs/logo1.png";
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="public-nav">
	<div class="container-fluid">
		<a class="navbar-brand js-scroll-trigger" href="#top"><div class="d-flex"><img src="<?=$navBarImg?>" class="img-fluid"></div></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#dtrNavBarPublic" aria-controls="dtrNavBarPublic" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse justify-content-end" id="dtrNavBarPublic">
			<ul class="navbar-nav ml-auto">
				<?php foreach($menuItems as $key => $item):?>
					<?php if($key === 'access'):?>
						<a id="<?= $key?>" class="nav-link pointer" data-container="body" data-toggle="popover" data-html="true" data-placement="bottom" role="button">
							<span class="<?= $item['icon']?>" ></span> 
							<?= $item['name']?> 
							<span class="fa fa-caret-down"></span>
						</a>
						<?= $loginForm?>
					<?php else:?>
						<li class="nav-item">
							<a class="nav-link js-scroll-trigger" href="<?= $item['url']?>">
								<i class="<?= $item['icon']?>" ></i> <?= $item['name']?>
							</a>
						</li>
					<?php endif?>
				<?php endforeach?>
			</ul>
		</div>
	</div>
</nav>
