<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| BARRA USUARIOS
| -------------------------------------------------------------------
| 
|
*/
$user = $this->init->activeUser;
$userImg = $user->image;
$sess_start = mdate($user->dtf, $user->sess_start);
$menuStyle = $user->user_menu_style;
$userRole = $user->user_role === 'user' ? 'text-user-type-user' : 'text-user-type-assoc';
if($user->user_role === 'user')
{
	unset($menuItems['nav']['user-options']['submenu']['user-products']);
}
?>
<nav class="navbar navbar-expand-lg <?=$menuStyle?> fixed-top">
	<a class="navbar-brand" href="#"><?=$user->user_first_name?> <?=$user->user_last_name?></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-first" aria-controls="nav-first" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="nav-user">
		<ul class="navbar-nav ml-auto">
			<?php foreach($menuItems['nav'] as $key => $item):?>
				<?php if(isset($alerts) AND count($alerts) > 0):?>
				<li class="nav-item dropdown pt-2 pr-3">
					<a class="nav-link dropdown-toggle" href="#" role="button" id="<?=$key?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="<?=$item['icon']?>"></i> <?=$item['name']?> 
						<?php if($key === 'user-alerts'):?>
							<span class="badge badge-default"><?=count($alerts)?></span>
						<?php endif?>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="<?=$key?>">
						<?php $it = $key === 'user-alerts' ? $alerts : $item['submenu']?>
						<?php foreach($it as $k => $submenu):?>
							<?php $href = str_replace('%base_url%', base_url(), $submenu['url'])?>
							<a class="dropdown-item" id="<?=$k?>" href="<?=$href?>">
								<i class="<?=$submenu['icon']?>"></i> 
								<?=$submenu['name']?> <span class="sr-only">(current)</span>
							</a>
						<?php endforeach?>
					</div>
				</li>
				<?php else:?>
					<?php if($key === 'user-alerts'):?>
						<li class="nav-item pt-2 pr-3">
							<a class="nav-link" href="#" role="button" id="<?=$key?>">
								<i class="<?=$item['icon']?>"></i> <?=$item['name']?> 
								<span class="pt-0 mt-0" style="font-size: 1.3em;"><i class="badge badge-warning">0</i></span>
							</a>
						</li>
					<?php else:?>
						<li class="nav-item dropdown pt-2 pr-3">
							<a class="nav-link dropdown-toggle" href="#" role="button" id="<?=$key?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="<?=$item['icon']?>"></i> <?=$item['name']?> 
								
							</a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="<?=$key?>">
								
								<?php foreach($item['submenu'] as $k=>$s):?>
									<?php $href = str_replace('%base_url%', base_url(), $s['url'])?>
									<a class="dropdown-item" id="<?=$k?>" href="<?=$href?>">
										<i class="<?=$s['icon']?>"></i> 
										<?=$s['name']?> <span class="sr-only">(current)</span>
									</a>
								<?php endforeach?>
							</div>
						</li>
					<?php endif?>
				<?php endif?>
			<?php endforeach?>
			<li class="nav-item dropdown">
				<div class="btn-group">
					<a href="#" class="nav-link dropdown-toggle" role="button" id="dd-user-img" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img id="nav-user-image" src="<?=$userImg?>" style="width: 40px; height: 40px" class="rounded-circle">
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-navbar" aria-labelledby="dd-user-img">
						<p class="dropdown-header text-center">
							<?=$this->lang->line('text-welcome')?><br><?=$user->user_name?>
						</p>
						<div class="alert alert-light">
						<p class="dropdown-item-text m-0 p-0"><small><b><?=$this->lang->line($userRole)?></b></small></p>
						<p class="dropdown-item-text m-0 p-0"><small><b><?=$user->company_name?></b></small></p>
						<p class="dropdown-item-text m-0 p-0"><small><?=$this->lang->line('text-session-start')?>: <?=$sess_start?></small></p>
						</div>
						<div class="dropdown-divider"></div>
						<?php foreach($menuItems['global'] as $key => $item):?>
							<?php $href = str_replace('%base_url%', base_url(), $item['url'])?>
							<a class="dropdown-item" href="<?=$href?>" id="<?=$key?>">
								<i class="<?=$item['icon']?>"></i> 
								<?=$item['name']?> <span class="sr-only">(current)</span>
							</a>
						<?php endforeach?>
					</div>
				</div>
			</li>
		</ul>
	</div>
</nav>
