(function($){
	'use strict';

	$.fn.User = function(options, method){
		var defaults= {
			updateUrl: BaseUrl,
			dataChartUrl: null
		},
		settings = $.extend(true, defaults, options),
		that = this,
		activeUser = null,

		methods = {
			construct: function(){

			},
			init: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Requirements/Get',
					type: 'GET',
					showLoadingBar: true
				}).then(
					function(response){
						var r = $.parseJSON(response),
							table = that.find('#tbl-user-requirements'),
							configOpts = r;
						table
							.bootstrapTable(configOpts)
							.on('all.bs.table', function(e, name, args){
								var self = $(this),
									rows = self.find('tbody tr');
								self.find('tbody [title]')
									.tooltip({
										html: true,
										trigger: 'hover',
										placement: 'auto'
									});
								self.find('thead').addClass('bg-light text-dark').find('th').addClass('font-weight-bold');
								self.find('tbody td').addClass('text-dark');
							})
							.on('click-row.bs.table', function(e, row, element, field){
								$(element).siblings()
									.removeClass('bg-light')
								$(element)
									.addClass('bg-light')
							});
						table.bootstrapTable('refresh');
					}
				);
			},
			setPanels: function(){
				that.find('.show-hide-panels').on('click', function(){
					var self = $(this),
						child = self.closest('div').find('div.user-panel');
					if (child.hasClass('fadeInLeft')){
						child.removeClass('fadeInLeft').addClass('fadeOutLeft').css('height', '0');
						self.addClass('text-danger')
					}
					else{
						child.removeClass('fadeOutLeft').addClass('fadeInLeft').css('height', 'auto');
						self.removeClass('text-danger')
					}
				})
			},
			setDataChart: function(){
				$.fn.request({
					url: BaseUrl + settings.dataChartUrl,
					type: 'GET',
					showLoadingBar: true
				}).then(
					function(response) {
						var r = $.parseJSON(response);
						that.Charts({
							data: r
						}, 'set')
					}

				)
			},
			register: function(){
				var frmRegister = that.find('#frm-register'),
					userCompany = frmRegister.find('#user_company'),
					radioUser = that.find('#iamuser'),
					radioAssoc = that.find('#iamcompany'),
					userTypes = $.parseJSON(frmRegister.find('#user-type').attr('data-user-type'));

				frmRegister.AutoComplete();
				frmRegister.Geolocation();

				userCompany.removeAttr('required');

				// Inicializa radio botones.
				radioUser.prop('checked', true);
				radioAssoc.prop('checked', false);

				// Listener para radio botones. Muestra info de registro
				radioUser.on('click', function(){
					var self = $(this);
					if(self.is(':checked')){
						if(IsMobile == 0){
							that.find('#register-assoc-info').slideUp('slow');
							that.find('#register-info-user').removeClass('d-none').slideDown('slow');
						}
						frmRegister.find('#user-type span').html(userTypes['user']);
						userCompany.removeAttr('required');
					}
				});
				radioAssoc.on('click', function(){
					var self = $(this);
					if(self.is(':checked')){
						if(IsMobile == 0){
							that.find('#register-assoc-info').removeClass('d-none').slideDown('slow');
							that.find('#register-info-user').slideUp('slow');
						}
						frmRegister.find('#user-type span').html(userTypes['assoc']);
						userCompany.attr('required', '');
					}
				});

				// Listener para autocompletado

				frmRegister.find('input.autocomplete').on('focus', function(){
					frmRegister.AutoComplete()
				})
				
				frmRegister.find('select.country').on('change', function(){
					frmRegister.AutoComplete()
				});

				// Listener para boton geolocalizacion pagina publica
				frmRegister.find('button.btn-locateme').on('click', function(e){
					e.preventDefault();
					frmRegister.Geolocation()
				});

				// Envio de registro de nuevo usuario
				frmRegister.validatr({
					valid: function(){
						_setRegisterResume(frmRegister);
						return false
					}
				})
				_formValidation(frmRegister);
				_validateRange(frmRegister, 5, 13);
				_validateAddres(frmRegister);

				// Listener para actualizacion de imagen captcha
				frmRegister.find('#btn-refresh-captcha').on('click', function(){
					Captcha.refresh()
				})
			},
			firstTime: function(){
				var TabIndex;
				_startSession();
				$('#first-tabs').tabs({
					show: { effect: "fade", duration: 800 },
					beforeActivate: function( event, ui ) {
						var self = ui.newPanel,
							form = self.find('form'),
							formId = form.attr('id'),
							setForm = function(url){
								form.validatr({
									location: 'left',
									theme: 'bootstrap',
									template: '<div class="bg-danger text-white">{{message}}</div>',
									valid: function(){
										_update(form, url)
										return false
									}
								});
							};
						$('html, body').css('font-family', FontFamily).css('font-size', FontSize);

						if(formId === 'frm-change-pwd'){
							var url = BaseUrl+'index.php/Users/update/password';

							form.find('input.password').val('').attr('type', 'password');
							form.find('#show-pwd').removeAttr('checked');
							setForm(url);
							_validatePwd(form);
							_setPassword(form)
						}
						if(formId === 'frm-personal-data'){
							var url = BaseUrl+'index.php/Users/update/personal';
							setForm(url);
							_validateRange(form, 6, 12);
							form.find('input[name="company_name"]').on('blur', function(){
								var val = $(this).val();
								form.find('input[name="company_alt_name"]').val(val)
							})
						}
						if(formId === 'frm-location-data'){
							var url = BaseUrl+'index.php/Users/update/address';
							setForm(url);
							_validateAddres(form);

							form.AutoComplete({showMap: true});
							form.Gmap();
							
							form.find('button.btn-locateme').on('click', function(e){
								e.preventDefault();
								form.Geolocation({showMap: true});
							});
							form.find('input.autocomplete').on('focus', function(){
								form.find('input[fill-location=""]').not('.autocomplete').val('');
								form.AutoComplete({showMap: true});
							});
							form.find('button.btn-restore-address').on('click', function(e){
								e.preventDefault();
								form.RestoreAddress({showMap: true});
							});
							
							form.find('select.country').on('change', function(){
								form.AutoComplete({showMap: true});
							});
						}
						if(formId === 'frm-user-settings'){
							var url = BaseUrl+'index.php/Users/update/settings';
							setForm(url);
							form.find('select[name="user_font_family"]').on('change', function(){
								var val = $(this).val();
								$('html *').not('.fas, .far, .fa, [type="hidden"]').css('font-family', val)
							});
							form.find('select[name="user_font_size"]').on('change', function(){
								var val = $(this).val();
								$('html, body').not('h1, h2, h3, h4, h5, h6').css('font-size', val)
							});
							
						}
						if(formId === 'frm-assoc-products'){
							var accordion = self.find('#products-accordion'),
								draggable = accordion.find('div.card-body div.media'),
								setProducts = function(){
									draggable.Products({
										dropContainer: self.find('#droppable'),
										containment: accordion.closest('div.row'),
										dropInsertEl: DomRootEl.find('#hidden-drags div.container-dragged')
									}, 'byUser')
								};
							setProducts();
							accordion.on('shown.bs.collapse', function () {
								setProducts();
							})
						}
						if(self.attr('id') === 'user-image'){
							var container = self.find('#uploader'),
								imgCfg = $.parseJSON(container.attr('data-img-config'));
							container.Upload(imgCfg, 'start')
						}
					}
				})
			},
			personalData: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Users/Data',
					type: 'GET',
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						that.append(response);
		    			modal = that.find('#modal-show-personal-data');
		    			modal.modal({backdrop: 'static'});

		    			modal.on('shown.bs.modal', function (e) {
							var self = $(this),
								form = self.find('form'),
								url = BaseUrl+'index.php/Users/Data/update';
							form.validatr({
								location: 'left',
								theme: 'bootstrap',
								template: '<div class="bg-danger text-white">{{message}}</div>',
								valid: function(){
									_update(form, url)
									return false
								}
							});
							_validateRange(form, 6, 12);
						});
		    			modal.on('hidden.bs.modal', function (e) {
							$(this).remove();
						})
					}
				)
			},
			password: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Users/Pwd',
					type: 'GET',
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						that.append(response);
		    			modal = that.find('#modal-show-change-pwd');
		    			modal.modal({backdrop: 'static'});

		    			modal.on('shown.bs.modal', function (e) {
							var self = $(this),
								form = self.find('form'),
								url = BaseUrl+'index.php/Users/Pwd/update';

							form.find('input.password').val('').attr('type', 'password');
							form.find('#show-pwd').removeAttr('checked');
							_setPassword(form)
							form.validatr({
								location: 'left',
								theme: 'bootstrap',
								template: '<div class="bg-danger text-white">{{message}}</div>',
								valid: function(){
									_update(form, url)
									return false
								}
							});
							_validatePwd(form);
						});
		    			modal.on('hidden.bs.modal', function (e) {
							$(this).remove();
						})
					}
				)
			},
			fpassword: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Users/Fpwd/showForm',
					type: 'GET',
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						that.append(response);
		    			modal = that.find('#modal-fpwd');
		    			modal.modal();

		    			modal.on('shown.bs.modal', function (e) {
							var self = $(this),
								form = self.find('form');
							form.find('button').on('click', function(e){
								e.preventDefault();
								form.request({
									url: BaseUrl+'index.php/Users/Fpwd',
									showLoadingBar: true
								}).then(
									function(resp){
										var r = $.parseJSON(resp);
										DomRootEl.Message(r, 'set');
										setTimeout(function(){
											location.href = CurUrl
										}, 2000)
									}
								)
							})
						});
		    			modal.on('hidden.bs.modal', function (e) {
							$(this).remove();
						})
					}
				)
			},
			image: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Users/Image',
					type: 'GET',
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						that.append(response);
		    			modal = that.find('#modal-show-change-image');
		    			modal.modal({backdrop: 'static'});

		    			modal.on('shown.bs.modal', function (e) {
							var self = $(this),
								container = self.find('#uploader'),
								imgCfg = $.parseJSON(container.attr('data-img-config'));
							container.Upload(imgCfg, 'start')
							
						});
		    			modal.on('hidden.bs.modal', function (e) {
							$(this).remove();
						})
					}
				)
			},
			settings: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Users/Settings',
					type: 'GET',
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						that.append(response);
		    			modal = that.find('#modal-show-settings');
		    			modal.modal({backdrop: 'static'});

		    			modal.on('shown.bs.modal', function (e) {
							var self = $(this),
								form = self.find('form'),
								url = BaseUrl+'index.php/Users/Settings/update';

							form.find('select').selectpicker();
							form.validatr({
								location: 'left',
								theme: 'bootstrap',
								template: '<div class="bg-danger text-white">{{message}}</div>',
								valid: function(){
									_update(form, url)
									return false
								}
							});
						});
		    			modal.on('hidden.bs.modal', function (e) {
							$(this).remove();
						})
					}
				)
			},
			locationData: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Users/Location',
					type: 'GET',
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						that.append(response);
		    			modal = that.find('#modal-show-location-data');
		    			modal.modal({backdrop: 'static'});

		    			modal.on('shown.bs.modal', function (e) {
							var self = $(this),
								form = self.find('form'),
								url = BaseUrl+'index.php/Users/Location/update';

							form.find('select').selectpicker();

							form.AutoComplete({showMap: true});
							form.Gmap();
							
							form.find('button.btn-locateme').on('click', function(e){
								e.preventDefault();
								form.Geolocation({showMap: true});
							});
							form.find('input.autocomplete').on('focus', function(){
								form.find('input[fill-location=""]').not('.autocomplete').val('');
								form.AutoComplete({showMap: true});
							});
							form.find('button.btn-restore-address').on('click', function(e){
								e.preventDefault();
								form.RestoreAddress({showMap: true});
							});
							
							form.find('select.country').on('change', function(){
								form.AutoComplete({showMap: true});
							});
							form.validatr({
								location: 'left',
								theme: 'bootstrap',
								template: '<div class="bg-danger text-white">{{message}}</div>',
								valid: function(){
									_update(form, url)
									return false
								}
							});
							_validateAddres(form);
						});
		    			modal.on('hidden.bs.modal', function (e) {
							$(this).remove();
						})
					}
				)
			}
		}

		methods.construct();
		if(methods[method] != undefined){
			methods[method].apply(this)
		}
		return this;

		/*-----------------------------------------------------------------------
		|	METODOS PRIVADOS                                                    |
		-----------------------------------------------------------------------*/

		function _setRegisterResume(form){
			form.request({
				url: BaseUrl+'index.php/Registration/Resume',
				type: 'GET',
				showLoadingBar: true
			}).then(
				function(response){
					var modal;
					that.append(response);
	    			modal = that.find('#modal-resume-registration');
	    			modal.modal({backdrop: 'static'});

	    			modal.on('shown.bs.modal', function (e) {
						var self = $(this),
							form = self.find('form');
						self.find('#btn-send-registration').on('click', function(){
							form.request({
								url: BaseUrl+'index.php/Registration/RegisterUser',
								showLoadingBar: true
							}).then(
								function(response){
									var r = $.parseJSON(response);
									that.Message(r, 'set');
									modal.modal('hide')
								}
							)
						})
					});
					modal.on('hidden.bs.modal', function (e) {
						$(this).remove();
					})
				}
			)
		}

		function _startSession(){
			that.find('#btn-start-sesion').on('click', function(){
				$.fn.request({
					url: BaseUrl+'index.php/First/start',
					type: 'GET',
					showLoadingBar: true
				}).then(
					function(response){
						var r = $.parseJSON(response);
						that.Message(r.msg, 'set');
						if(r.msg.cls != 'success'){
							$('#first-tabs').tabs( "option", "active", r.tabId );
						}
					}
				)
			})
		}

		function _setPassword(form){
			form.find('#show-pwd').on('click', function(e){
				e.stopImmediatePropagation();
				var self = $(this);
				if(self.is(':checked')){
					self.attr('checked', '')
				}
				else{
					self.removeAttr('checked')
				}
				//alert('click')
				form.showHidePwd()
			});
			form.find('#btn-random-pwd').on('click', function(e){
				e.preventDefault();
				var chkType = form.find('#pwd-alfanum'),
					type  = chkType.is(':checked') ? 'alfanum' : 'specialchars',
					selChars = form.find('#num-chars-pwd'),
					numChars = selChars.val();
				
				selChars.on('change', function(){
					numChars = $(this).val()
				})
				form.find('input.random-password').randomPassword({type: type, fixedlength: numChars})
			});
		}

		function _update(form, url){
			form.request({
				url: url,
				showLoadingBar: true
			}).then(
				function(response){
					var r = $.parseJSON(response);
					DomRootEl.Message(r.message, 'set');
					if(typeof r.hash != "undefined"){
						DomRootEl.find('input[name="csrf_test_name"]').val(r.hash);
					}
				}
			)
		}

	}
})(jQuery);