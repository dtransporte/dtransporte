<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina servicios ofrecidos assoc (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/users
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : assoc-products.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);
?>
<div class="container-fluid" id="container">
	<div class="d-flex justify-content-between mb-5 border-bottom border-light">
		<h2><i class="fas fa-align-justify"></i> Productos Asociados</h2>
		<a href="<?=base_url()?>index.php/Place/Assoc" role="button" class="btn btn-default w-25"><i class="far fa-hand-point-left"></i> Volver</a>
	</div>
	<form id="frm-assoc-products" method="post">
		<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" >
		<?php $this->load->view('es/products/assoc')?>
	</form>
</div>