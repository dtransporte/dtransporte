var BlockScr = (function(){
	'use strict',

	init = function(){
		$.fn.request({
			url: BaseUrl+'index.php/BlockScr',
			type: 'GET',
			showLoadingBar: true
		}).then(
			function(response){
				var modal;
				DomRootEl.append(response);
				modal = DomRootEl.find('#modal-block-scr');
				modal.modal({backdrop: 'static', keyboard: false});

				modal.on('shown.bs.modal', function (e) {
					var self = $(this);
					DomRootEl.find('div.modal-backdrop').css('background-color', '#000000');
					self.find('#btn-unlock').on('click', function(){
						unlock(modal)
					})
				});
				modal.on('hidden.bs.modal', function (e) {
					$(this).remove();
				})
			}
		)
	},
	unlock = function(modal){
		var form = modal.find('#frm-unblock-scr');
		form.request({
			url: BaseUrl+'index.php/BlockScr/unlock',
			type: 'GET',
			showLoadingBar: true
		}).then(
			function(response){
				if(response == 0){
					location.href = BaseUrl+'index.php/logout'
				}
				else if(response === 'ok'){
					modal.modal('hide')
				}
				else{
					modal.find('#attempts-unlock').text(response);
					form.find('input[type="password"]').val('')
				}
			}
		)
	}

	return{
		init: init
	}
})();