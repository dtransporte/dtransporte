<?php
/*
| -------------------------------------------------------------------
| Vista fragmento dialogo modal
| -------------------------------------------------------------------
|
| -------------------------------------------------------------------
| Nombre: modal.php
| -------------------------------------------------------------------
|
| -------------------------------------------------------------------
| Location ./application/views
| -------------------------------------------------------------------
|
*/
if(! isset($modalSize)){
	$modalSize = '';
}
/*
	@modalAttribs
		modal-frame 		- Ocupa todo el largo de la pantalla
		modal-full-height	- Ocupa todo la altura de la pantalla
		modal-right	| top	- Se despliega de derecha a izquierda
		modal-bottom-right
		modal-danger
		modal-side
*/
if(! isset($modalAttribs)){
	$modalAttribs = '';
}
?>
<!-- Modal -->
<div class="modal fade top z-depth-0" id="<?php echo $modalId?>" tabindex="-1" role="dialog" aria-labelledby="dtrModalLabel">
	<div class="modal-dialog <?=$modalAttribs?> <?php echo $modalSize?>" role="document">
		<div class="modal-content">
			<div class="modal-header z-depth-0">
				<h4 class="modal-title text-white" id="dtrModalLabel"><?php echo $modalTitle?></h4>
				<?php if(!isset($modalShowCloseBtn) OR $modalShowCloseBtn === TRUE):?>
				<button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<?php endif?>
			</div>
			<div class="modal-body">
				<?php echo $modalBody?>
			</div>
			<?php if(isset($modalFooter) AND $modalFooter != ''):?>
				<div class="modal-footer">
					<?php echo $modalFooter?>
				</div>
			<?php endif?>
		</div>
	</div>
</div>