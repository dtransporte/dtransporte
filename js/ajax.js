(function($){
	$.fn.request = function(options){
		var defaults = {
			url: BaseUrl,
			data:null,
			type: 'POST',
			showLoadingBar: false,
			dataType: 'html',
			loadingBarText: ''
		};
		var settings = $.extend(true, defaults, options);
		var that = this;
		var data = settings.data != null ? settings.data : this.serialize();
		var dfd = $.Deferred();
		var ajax = $.ajax({
			url: settings.url,
			method: settings.type,
			data: data,
			dataType: settings.dataType,
			success: function(response){
				dfd.resolve(response)
			},
			error: function(){
				if(settings.showLoadingBar){
					DomRootEl.find('.loading-bar').remove();
				}
				dfd.reject('error_no_request');
			},
			beforeSend: function(){
				if(settings.showLoadingBar){
					DomRootEl.loadingBar({text: settings.loadingBarText});
				}
			},
			complete: function(){
				if(settings.showLoadingBar){
					DomRootEl.find('.loading-bar').remove();
				}
			}
		})
		return dfd.promise()
	}
})(jQuery);