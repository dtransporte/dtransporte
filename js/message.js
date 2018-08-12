(function($){
	'use strict';
	$.fn.Message = function(options, method){
		var defaults = {
			sizeClass: 'message-sm', //sm, md ,lg
			cls: 'success', // success, warning, danger
			duration: 0, // la duracion en milisegundos antes que desaparezca
			message: null,
			href: null,
			loader: {
				cls: 'message-loader-sm',
				text: null
			},
			showLoadingBar: true
		},
		settings = $.extend(true, defaults, options),
		that = this,
		html = '',
		msg = this.find('#inline-message'),
		navHeight = this.find('nav').height()+15,
		wtop = $(window).scrollTop()+navHeight,
		borderColor = {warning: 'rgb(201, 175, 96)', success: '#2E6A3B', danger: '#721C24'},
		icon = {
			success: 'fa-check-circle fa-3x',
			danger: 'fa-times-circle fa-3x',
			warning: 'fa-exclamation-circle fa-3x'
		},
		methods = {
			construct: function(){
				$(window).on('scroll', function(){
					msg.css('top', wtop+'px');
				});
				if(settings.showLoadingBar){
					that.loadingBar()
				}
				msg.removeAttr('class')
			},
			set: function(){
				that.on('click', function(){
					that.find('.loading-bar').remove();
					msg.fadeOut('slow')
				});
				if(settings.duration > 0){
					that.off('click');
					if(settings.href != null){
						msg.find('#message-loader').removeClass('d-none').html(TextRedirect);
					}
					setTimeout(function(){
						that.find('.loading-bar').remove();
						msg.slideUp('slow');
						if(settings.href != null){
							location.href = BaseUrl+settings.href
						}

					}, settings.duration)
				}
				msg.addClass(settings.sizeClass).addClass('alert alert-'+settings.cls);
				msg.css('border', '1px solid '+borderColor[settings.cls]).css('border-left', '10px solid '+borderColor[settings.cls]);
					
				msg.find('#message-icon').addClass(icon[settings.cls]);
				
				msg.find('#message-text').append('<p></p>').addClass('p-2, mt-4').html(settings.message);
				msg.css('top', wtop+'px');

				msg.fadeIn('fast');
				msg.addClass('animated bounceInDown');
				
				that.find('.loading-bar').remove();
			}
		};
		methods.construct();
		if(method != undefined){
			methods[method].apply(this)
		}
		return this;

		function _setLoader(){
			var loader = msg.find('#message-loader');
			loader
				.addClass(settings.loader.cls)
				.removeClass('hidden');
			if(settings.loader.text != null && settings.loader.text != undefined){
				loader.text(settings.loader.text)
			}
		}
	}
})(jQuery);
