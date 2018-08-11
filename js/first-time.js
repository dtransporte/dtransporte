var FirstTime = (function(){
	'use strict',

	init = function(){
		_startSession();
		$('#first-tabs').tabs({
			show: { effect: "blind", duration: 500 },
			beforeActivate: function( event, ui ) {
				var self = ui.newPanel,
					form = self.find('form'),
					formId = form.attr('id');

				form.validatr({
					location: 'left',
					theme: 'bootstrap',
					template: '<div class="bg-danger text-white">{{message}}</div>',
					valid: function(){
						return false
					}
				});
				if(formId === 'frm-change-pwd'){
					_validatePwd(form)
				}
				if(formId === 'frm-location-data'){
					_setAddress(form);
					_showMap(form);
					_validateAddres(form);
					form.find('#btn-locateme').on('click', function(e){
						e.preventDefault();
						_locateMe(form)
					});
				}
				if(self.attr('id') === 'user-image'){
					upload()
				}
			}
		})
	},
	_setAddress = function(form){
		form.Address({
			fillAddress: true,
			showPhonePrefix: true
		}, 'autoComplete');
	},
	_locateMe = function(container){
		container.Address({
			showPhonePrefix: true,
			showGeoLocactionMessage: true
		}, 'locateMe');
	},
	_showMap = function(container){
		var location = {
			lat: parseFloat(container.find('.latitude').val()),
			lng: parseFloat(container.find('.longitude').val())
		};
		container.Address({
			location: location
		}, 'showMap');
	},
	_startSession = function(){
		DomRootEl.find('#btn-start-sesion').on('click', function(){
			$.fn.request({
				url: BaseUrl+'index.php/First/start',
				type: 'GET',
				showLoadingBar: true
			}).then(
				function(response){
					var r = $.parseJSON(response);
					DomRootEl.Message(r.msg, 'set'),
					$('#first-tabs').tabs( "option", "active", r.tabId );
				}
			)
		})
	}

	return{
		init: init
	}
})();