(function($){
	'use strict';
	$.fn.Interface = function(options, method){
		var defaults = {
			data: {}
		},
		settings = $.extend(true, defaults, options),
		that = this,

		methods = {
			construct: function(){
				$('[data-toggle="tooltip"]').tooltip({html: true, trigger: 'hover'});
				that.find('div.hiddendiv').remove();
				that.find('input[type="text"], input[type="email"], input[type="password"], input[type="number"], textarea')
				.addClass('bg-light pl-3 rounded');

				if(typeof CookieAlertMessage != "undefined"){
					that.find('nav a[id="access"]').addClass('disabled');
					that.Message(CookieAlertMessage, 'set').find('#more-about-cookies').on('click', function(){
						$.fn.request({
							url: BaseUrl+'index.php/agents',
							type: 'GET',
							showLoadingBar: true
						}).then(
							function(response){
								var modal;
								that.append(response);
				    			modal = that.find('#modal-agents');
				    			modal.modal({backdrop: 'static'});

								modal.on('hidden.bs.modal', function (e) {
									$(this).remove();
								})
							}
						)
					})
				}
				if(typeof ActiveMessage != "undefined"){
					that.Message(ActiveMessage, 'set')
				}
				_checkers();
			},
			public: function(){
				$('#carousel-public').carousel();
				that.find('div.jumbotron').css('height', $(window).height()+'px');
				that.User({}, 'register');
				_setContactForm();
				_setPopOver();
				_acceptCookies();
				_showPolicy()
				
			},
			firstUser: function(){
				_setContainer();
				$('html *').not('.fas, .far, .fa, [type="hidden"]').css('font-family', FontFamily)
				$('html, body').not('h1, h2, h3, h4, h5, h6').css('font-size', FontSize);
				that.User({}, 'firstTime');
			},
			firstAssoc: function(){
				_setContainer();
				$('html *').not('.fas, .far, .fa, [type="hidden"]').css('font-family', FontFamily)
				$('html, body').css('font-size', FontSize);
				that.User({}, 'firstTime');
			},
			user: function(){
				_setContainer();
				$('html, body').css('font-family', FontFamily).css('font-size', FontSize);
				_setUserMenu();
				
				switch(ActivePage){
					case 'home-user':
						that.User({}, 'init');
						that.User({}, 'setPanels');
						that.find('#requirements-by-status-chart').User({
							dataChartUrl: 'index.php/DataChart/getUserRequirementsByStatus'
						}, 'setDataChart');
						that.find('#requirements-finished-by-assoc').User({
							dataChartUrl: 'index.php/DataChart/requirementsFinishedByAssoc'
						}, 'setDataChart');
						that.Products({}, 'show');
						that.find('#show-ranking-detail').on('click', function(){
							that.Ranking({}, 'show')
						})
					break;
					case 'user-requirement':
						that.Requirements({}, 'add');
						that.Requirements({}, 'send')
					break;

					case 'home-assoc':
						that.User({}, 'setPanels');
						that.find('#product-required-by-users-chart').User({
							dataChartUrl: 'index.php/DataChart/getUserRequiredServices'
						}, 'setDataChart');
						that.find('#requirements-finished-by-user').User({
							dataChartUrl: 'index.php/DataChart/requirementsFinishedByUser'
						}, 'setDataChart');
						that.Quotation({}, 'init');
						that.find('#show-ranking-detail').on('click', function(){
							that.Ranking({}, 'show')
						})
					break;

					case 'user-quotation':
						that.Quotation({}, 'add')
					break;

					case 'assoc-products':
						var accordion = that.find('#products-accordion'),
							draggable = accordion.find('div.card-body div.media'),
							setProducts = function(){
								draggable.Products({
									dropContainer: that.find('#droppable'),
									containment: accordion.closest('div.row'),
									dropInsertEl: DomRootEl.find('#hidden-drags div.container-dragged')
								}, 'byUser')
							};
						setProducts();
						accordion.on('shown.bs.collapse', function () {
							setProducts();
						})
					break;
				}
			}
		}
		methods.construct();
		if(method != undefined){
			methods[method].apply(this);
		}
		return this;

		/*-----------------------------------------------------------------------
		|	METODOS PRIVADOS                                                    |
		-----------------------------------------------------------------------*/

		function _setContactForm(){
			var frmContact = that.find('#frm-contact');

			// Validacion de formulario de contacto
			_formValidation(frmContact);
		}

		function _setPopOver(){
			var popover = $("[data-toggle=popover]");
			popover.popover({
				html: true, 
				content: function() {
					var c = $('#popover-content').html();
					return c;
				}
			})
			.on('shown.bs.popover', function () {
				var self = $(this),
					content = DomRootEl.find('div.popover-body'),
					form = content.find('form');
				content.find('#btn-fpwd').on('click', function(){
					that.User({}, 'fpassword');
					popover.popover('hide')
				});
				content.find('#btn-login').on('click', function(e){
					e.preventDefault();
					_login(form);
					popover.popover('hide')
				});
			})
		}

		function _acceptCookies(){
			that.find('#btn-accept-cookie').on('click', function(){
				$.fn.request({
					url: BaseUrl+'index.php/Policy/accept',
					type: 'GET',
					showLoadingBar: true
				}).then(
					function(){
						that.find('#cookie-policy').addClass('d-none')
					}
				)
			})
		}

		function _showPolicy(){
			that.find('.btn-view-policy').on('click', function(){
				$.fn.request({
					url: BaseUrl+'index.php/Policy',
					type: 'GET',
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						that.append(response);
		    			modal = that.find('#modal-show-policy');
		    			modal.modal();

						modal.on('hidden.bs.modal', function (e) {
							$(this).remove();
						})
					}
				)
			})
		}

		function _login(form){
			form.request({
				url: BaseUrl+'index.php/login',
				showLoadingBar: true
			}).then(
				function(response){
					var r = $.parseJSON(response);
					that.Message(r, 'set')
				}
			)
		}

		function _setContainer(){
			var navHeight = that.find('nav').outerHeight();
			that.find('#container').css('margin-top', (navHeight+10)+'px');
		}

		function _setUserMenu(){
			that.find('#user-data').on('click', function(){
				that.User({}, 'personalData');
			});
			that.find('#user-location').on('click', function(){
				that.User({}, 'locationData');
			});
			that.find('#user-image').on('click', function(){
				that.User({}, 'image');
			});
			that.find('#user-pwd').on('click', function(){
				that.User({}, 'password');
			});
			that.find('#user-settings').on('click', function(){
				that.User({}, 'settings');
			});
			if(ScrBlocked == 1){
				BlockScr.init()
			}
			else{
				that.find('#block-scr').on('click', function(){
					BlockScr.init();
				});
				if(BlockScreen > 0){
					setTimeout(function(){
						BlockScr.init()
					}, BlockScreen*60*1000)
				}
			}
		}

		function _checkers(){
			$.fn.Checker({url: BaseUrl+'index.php/Users/Check/validation'});
			$.fn.Checker({url: BaseUrl+'index.php/Users/Check/passwordReset'});
			$.fn.Checker({url: BaseUrl+'index.php/Users/Check/paymentReminder'});
			$.fn.Checker({url: BaseUrl+'index.php/Users/Check/blockUserDuePay'});
			$.fn.Checker({url: BaseUrl+'index.php/Requirements/Check/checkExpiredRequirement'});
			$.fn.Checker({url: BaseUrl+'index.php/Requirements/Check/checkProgramRequirement'});
			$.fn.Checker({url: BaseUrl+'index.php/Requirements/Check/checkFaultsExpiration'});
			$.fn.Checker({ url: BaseUrl + 'index.php/Requirements/Check/checkFinishedRequirements' });
		}
	}
})(jQuery);