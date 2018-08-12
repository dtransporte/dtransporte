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
| Nombre : modal-user-ranking.php
|--------------------------------------------------------------------------
|
*/
//var_dump($ranking)
?>
<input type="hidden" id="data-ranking" value='<?=json_encode($ranking)?>'>
<table id="tbl-users-ranking"></table>