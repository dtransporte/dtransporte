<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina ubicacion usuarios (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/users
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : modal-location-data.php
|--------------------------------------------------------------------------
|
*/
$user = $this->init->activeUser;
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);
?>
<form>
	<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" >
	<input type="hidden" fill-location name="phone_prefix" value="<?=$user->phone_prefix?>">
	<input type="hidden" fill-location name="latitude" value="<?=$user->latitude?>">
	<input type="hidden" fill-location name="longitude" value="<?=$user->longitude?>">
	<input type="hidden" fill-location name="place_id" value="<?=$user->place_id?>" required>
	<input type="hidden" fill-location name="postal_code" value="<?=$user->postal_code?>">
	<input type="hidden" fill-location name="locality" value="<?=$user->locality?>">
	<input type="hidden" fill-location name="user_timezone" value="<?=$user->user_timezone?>">
	<input type="hidden" fill-location name="user_tz_offset" value="<?=$user->user_tz_offset?>">
	<?php $this->load->view('es/users/location-data')?>
	<button class="btn btn-primary btn-block" id="btn-save"><i class="fas fa-check"></i> Actualizar</button>
</form>