<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina resumen solicitudes usuario (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/requirements
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : modal-resume.php
|--------------------------------------------------------------------------
|
*/
?>
<div class="container-fluid alert alert-light text-dark">
	<?php foreach($views as $k=>$view):?>
		<?php if($k != 'attributes' AND isset($view['views'])):?>
			<?php foreach($view['views'] as $v):?>
				<?php if(file_exists(FCPATH.'application/views/'.$v.'.php')):?>
					<?php $this->load->view($v)?>
				<?php endif?>
			<?php endforeach?>
		<?php endif?>
	<?php endforeach?>
</div>

<!-- 
array(48) { ["csrf_test_name"]=> string(32) "a8dbeae80395c5ad66e97d7513716906" 
	["requirement_status"]=> string(6) "active" 
	["requirement_name"]=> string(0) "" 
	["requirement_expiration"]=> string(16) "2018-07-28 16:00" 
	["requirement_schedule"]=> string(16) "2018-07-29 06:00" 
	["operation_ncm_codes"]=> string(137) "[{"code":"2204210010","value":"36000","description":"Vinos finos de mesa"},{"code":"4818300000","value":"3500","description":"Manteles"}]"
	["operation_type"]=> string(4) "impo" 
	["operation_incoterm"]=> string(3) "fob" 
	["operation_currency"]=> string(4) "euro" 
	["operation_value"]=> string(5) "59400" 
	["custom_clearance"]=> string(2) "on" 
	["require_insurance"]=> string(2) "on" 
	["require_co"]=> string(2) "on" 
	["inspection_required"]=> string(11) "destination" 
	["inspection_company"]=> string(3) "SGS" 
	["inspection_notes"]=> string(0) "" 
	["o-phone_prefix"]=> string(2) "34" 
	["o-latitude"]=> string(10) "43.3423314" 
	["o-longitude"]=> string(19) "-3.0426105000000234" 
	["o-place_id"]=> string(27) "ChIJQ0hQYxNZTg0R3EAwKM0EKOE" 
	["o-postal_code"]=> string(0) "" 
	["o-locality"]=> string(0) "" 
	["o-user_timezone"]=> string(0) "" 
	["o-user_tz_offset"]=> string(0) "" 
	["o-country"]=> string(2) "ES" 
	["o-address"]=> string(25) "Puerto de Bilbao, España" 
	["o-address_notes"]=> string(0) "" 
	["d-phone_prefix"]=> string(3) "598" 
	["d-latitude"]=> string(11) "-34.8546392" 
	["d-longitude"]=> string(11) "-56.1657108" 
	["d-place_id"]=> string(100) "EixMZcOzbiBQw6lyZXogMzQ1NiwgMTIzMDAgTW9udGV2aWRlbywgVXJ1Z3VheSIbEhkKFAoSCUWfQZODKqCVEZj2O3Z4ZSvAEIAb" ["d-postal_code"]=> string(5) "12300" 
	["d-locality"]=> string(0) "" 
	["d-user_timezone"]=> string(18) "America/Montevideo" 
	["d-user_tz_offset"]=> string(2) "-3" 
	["d-country"]=> string(2) "UY" 
	["d-address"]=> string(38) "León Pérez 3456, Montevideo, Uruguay" 
	["d-address_notes"]=> string(0) "" 

	["wp-address"]=> array(2) { [0]=> string(44) "San José Departamento de San José, Uruguay" [1]=> string(40) "Durazno Departamento de Durazno, Uruguay" } 
	["wp-notes"]=> array(2) { [0]=> string(15) "levantar a pitu" [1]=> string(21) "levantar herramientas" } 

	["cargo_units_qty"]=> string(1) "1" 
	["cargo_weight"]=> string(5) "27000" 
	["cargo_volume"]=> string(2) "30" 
	["cargo_notes"]=> string(17) "Mercaderia fragil" 
	["cargo_additionals"]=> string(305) "[
	 {"item":"forklift","name":"Autoelevador","quantity":"1","place":"origin","notes":"nada"},
	 {"item":"workers","name":"Peones","quantity":"1","place":"destination","notes":"bien empilchados"},
	 {"item":"others","name":"muzza y faina","quantity":"150","place":"origin-destination","notes":"pa matar el hambre"}
	]" 

	["cargo_containers"]=> string(5) "ref20" 
	["requirement-images_count"]=> string(1) "0" 
	["requirement_currency"]=> string(5) "dolar" 
	["requirement_pay_terms"]=> string(19) "Cheque BROU 15 dias" 
	["requirement_notes"]=> string(34) "Se debe mantener la cadena de frio" } 



	array(10) { ["info"]=> array(4) 
	{ 
		["views"]=> array(1) { [0]=> string(27) "es/requirements/resume/info" } 
		["tabTitle"]=> string(7) "General" 
		["tabId"]=> string(11) 
		"reqTab-info" 
		["tabIcon"]=> string(11) "fas fa-home" 
	} 
	["dates"]=> array(4) { ["views"]=> array(1) { [0]=> string(28) "es/requirements/resume/dates" } ["tabTitle"]=> string(6) "Fechas" ["tabId"]=> string(12) "reqTab-dates" ["tabIcon"]=> string(19) "far fa-calendar-alt" } ["operation-type"]=> array(4) { ["views"]=> array(1) { [0]=> string(37) "es/requirements/resume/operation-type" } ["tabTitle"]=> string(16) "Operación" ["tabId"]=> string(21) "reqTab-operation-type" ["tabIcon"]=> string(18) "fas fa-file-import" } ["address"]=> array(4) { ["views"]=> array(2) { ["origin-address"]=> string(37) "es/requirements/resume/origin-address" ["destination-address"]=> string(42) "es/requirements/resume/destination-address" } ["tabTitle"]=> string(11) "Direcciones" ["tabId"]=> string(14) "reqTab-address" ["tabIcon"]=> string(21) "fas fa-map-marker-alt" } ["cargo"]=> array(4) { ["views"]=> array(2) { ["cargo-details"]=> string(36) "es/requirements/resume/cargo-details" ["cargo-specials"]=> string(37) "es/requirements/resume/cargo-specials" } ["tabTitle"]=> string(5) "Carga" ["tabId"]=> string(12) "reqTab-cargo" ["tabIcon"]=> string(19) "fas fa-people-carry" } ["images"]=> array(4) { ["views"]=> array(1) { [0]=> string(29) "es/requirements/resume/images" } ["tabTitle"]=> string(15) "Imágenes" ["tabId"]=> string(13) "reqTab-images" ["tabIcon"]=> string(12) "fas fa-image" } ["pay-terms"]=> array(4) { ["views"]=> array(1) { [0]=> string(32) "es/requirements/resume/pay-terms" } ["tabTitle"]=> string(4) "Pago" ["tabId"]=> string(16) "reqTab-pay-terms" ["tabIcon"]=> string(18) "fas fa-dollar-sign" } ["notes"]=> array(4) { ["views"]=> array(1) { [0]=> string(28) "es/requirements/resume/notes" } ["tabTitle"]=> string(5) "Notas" ["tabId"]=> string(12) "reqTab-notes" ["tabIcon"]=> string(10) "fas fa-pen" } 

	["attributes"]=> array(4) { ["views"]=> array(5) { ["mirror-address"]=> string(1) "0" ["show-route"]=> string(1) "0" ["show-origin"]=> string(1) "1" ["show-destination"]=> string(1) "1" ["lcl"]=> string(1) "1" } ["tabTitle"]=> string(0) "" ["tabId"]=> string(17) "reqTab-attributes" ["tabIcon"]=> string(0) "" } ["attributeTitle"]=> array(4) { ["views"]=> string(0) "" ["tabTitle"]=> string(0) "" ["tabId"]=> string(21) "reqTab-attributeTitle" ["tabIcon"]=> string(0) "" } } 
 -->