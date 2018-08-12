<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  JUMBOTRON PAGINA PUBLICA
| -------------------------------------------------------------------
| 
|
*/
?>
<div class="jumbotron text-center">
	<h1 class="animated bounceInRight">
		dTransporte <br>
		La mayor red de transporte del mercosur
	</h1>
	<?php $this->load->view('public-carousel')?>
	<?php $this->load->view('es/public-thumbs')?>
</div>