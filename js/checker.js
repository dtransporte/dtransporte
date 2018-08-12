(function($){
	'use strict';

	$.fn.Checker = function(options){
		var defaults= {
			url: BaseUrl,
			interval: 60 // Intervalo de chequeo en segundos
		},
		settings = $.extend(true, defaults, options),
		that = this,

		methods = {
			construct: function(){
				setInterval(function(){
					$.fn.request({
						url: settings.url,
						type: 'GET'
					})
				}, settings.interval * 1000)
			}
		}

		methods.construct();
		return this;
	}
})(jQuery);