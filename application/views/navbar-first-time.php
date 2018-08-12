<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| BARRA DE FIRST TIME
| -------------------------------------------------------------------
| 
|
*/
$userImg = $this->init->activeUser->image;
$sess_start = mdate($this->init->activeUser->dtf, $this->init->activeUser->sess_start);
$menuStyle = $this->init->activeUser->user_menu_style;
$userRole = $this->init->activeUser->user_role === 'user' ? 'text-user-type-user' : 'text-user-type-assoc';
?>
<nav class="navbar navbar-expand-lg <?=$menuStyle?> fixed-top">
	<a class="navbar-brand" href="#"><?=$this->lang->line('text-welcome-to')?> dTransporte</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-first" aria-controls="nav-first" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="nav-first">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<div class="btn-group">
					<a href="#" role="button" id="dd-user-img" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img id="nav-user-image" src="<?=$userImg?>" style="width: 50px; height: 50px" class="rounded-circle z-depth-1">
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-navbar" aria-labelledby="dd-user-img">
						<p class="dropdown-header text-center">
							<?=$this->lang->line('text-welcome')?><br><?=$this->init->activeUser->user_name?>
						</p>
						<p class="dropdown-item-text text-center"><small><b><?=$this->lang->line($userRole)?></b></small></p>
						<p class="dropdown-item-text text-center"><small><?=$this->lang->line('text-session-start')?>: <?=$sess_start?></small></p>
						<div class="dropdown-divider"></div>
						<?php foreach($menuItems as $key => $item):?>
							<?php $href = str_replace('%base_url%', base_url(), $menuItems[$key]['url'])?>
							<a class="dropdown-item" href="<?=$href?>">
								<i class="<?=$menuItems[$key]['icon']?>"></i> 
								<?=$menuItems[$key]['name']?> <span class="sr-only">(current)</span>
							</a>
						<?php endforeach?>
					</div>
				</div>
			</li>
		</ul>
	</div>
</nav>
