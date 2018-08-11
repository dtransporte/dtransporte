<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Vista pagina paises y bloques economicos (Espanol)
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/views/public/es/products
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
| Nombre : modal-countries.php
|--------------------------------------------------------------------------
|
*/
foreach($economicBlocksTxt as $k=>$eblock)
{
	$economic_blocks[$k]['id_economic_block'] = $k;
	$economic_blocks[$k]['name_economic_block'] = $eblock;
	for ($i = 0; $i < count($countriesByEblock); $i++)
	{
		if($countriesByEblock[$i]->id_economic_block === $k)
		{
			$economic_blocks[$k]['website'] = $countriesByEblock[$i]->website;
			$economic_blocks[$k]['countries'][$countriesByEblock[$i]->id_country] = $countriesByEblock[$i]->country;
		}
	}
}
foreach ($countries as $c) {
	$countryList[$c->iso] = $c->country;
}
//var_dump($countryList);
?>
<input type="hidden" id="countryOptions" value='<?=json_encode($countryOptions)?>'>
<input type="hidden" id="neighbourCountries" value='<?=json_encode($neighbours)?>'>
<input type="hidden" id="myCountry" value='<?=json_encode($myCountry)?>'>
<input type="hidden" id="economicBlocks" value='<?=json_encode($economic_blocks)?>'>
<input type="hidden" id="country-list" value='<?=json_encode($countryList)?>'>
<div class="alert alert-info">
	<h4>
		Seleccione los pa&iacute;ses o zonas desde las cuales desea recibir solicitudes.
	</h4>
</div>
<br>
<div class="container-fluid">
	<div class="checkbox">
		<input type="checkbox" id="only-my-country">
		<label for="only-my-country"><?=$countryOptions['only-my-country']?></label>

		<input type="checkbox" id="all-the-world">
		<label for="all-the-world"><?=$countryOptions['all-the-world']?></label>

		<input type="checkbox" id="neighbours">
		<label for="neighbours"><?=$countryOptions['neighbours']?></label>
	</div>
</div>
<br>
<div class="container-fluid">
	<div class="row">
		<div class="col-6">
			<select id="economic-blocks" class="selectpicker" multiple data-live-search="true" title="Bloques Econ&oacute;micos" data-actions-box="true" data-header="Seleccione Bloques Econ&oacute;micos" data-width="auto" data-style="btn-primary" data-selected-text-format="count">
				<?php foreach($economicBlocksTxt as $key => $ec):?>
					<option data-tokens="<?=$key?>" value="<?=$key?>" data-icon="fas fa-globe"><?=$ec?></option>
				<?php endforeach?>
			</select>
		</div>

		<div class="col-6">
			<select id="countries" class="selectpicker" multiple data-live-search="true" title="Selecci&oacute;n individual de pa&iacute;ses" data-size="15" data-actions-box="true" data-header="Selecci&oacute;ne pa&iacute;ses" data-width="auto" data-style="btn-primary" data-selected-text-format="count">
				<?php foreach($countries as $c):?>
					<option data-tokens="<?=$c->iso?>" value="<?=$c->iso?>" data-icon="fas fa-flag"><?=$c->country?></option>
				<?php endforeach?>
			</select>
		</div>
	</div>
</div>
<br>
<fieldset><legend>Pa&iacute;ses Seleccionados</legend>
	<div id="container-countries" class="container-fluid p-3"></div>
</fieldset>
