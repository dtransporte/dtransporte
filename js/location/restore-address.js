(function($){
	'use strict';

	$.fn.RestoreAddress = function(options){
		var defaults= {
			showMap: false,
			prefix: '' // '', o-, d-
		},
		settings = $.extend(true, defaults, options),
		that = this,
		fields = that.find('[fill-location=""]'),

		methods = {
			construct: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Users/get',
					type: 'GET',
					showLoadingBar: true
				}).then(
					function(response){
						var r = $.parseJSON(response);
						fields.val('');
						$.each(r, function(k, v){
							var name = settings.prefix+k,
								el = that.find('[name="'+name+'"]');
							if(el.is('select')){
								el.selectpicker('val', v)
							}
							else{
								el.val(v)
							}
						});
						if(settings.showMap == true){
							that.Gmap({
								prefix: settings.prefix
							})
						}
					}
				)
			}
		}

		methods.construct();
		return this;
	}
})(jQuery);