(function($){
	$.fn.loadingBar = function(options){
		var defaults = {
			text: '',
			size: 'large', // large, small
			image: null,
			imageDir: BaseUrl+'imgs/',
			appendTo: null
		},
			settings = $.extend(defaults, options),
			that = this,
			lbar, src, img, container, container_text, appendTo,

		methods = {
			construct: function(){
				that.find('.loading-bar').remove();
				if(settings.image != null){
					src = settings.imageDir+settings.image;
				}
				else{
					if(settings.size == 'large'){
						//src = settings.imageDir+'loadingBar.gif';
						src = 'fa-5x'
					}
					else{
						src = ''//settings.imageDir+'loadingBar-sm.gif'
					}
				}
				container = $('<div class="loading-bar" style=position:absolute; "></div>');
				img = '<i class="fas fa-cog fa-spin '+src+'"></i>';//$('<img src="'+src+'" />');
				that.append(container);
				container.append(img);
				if(settings.text != ''){
					container_text = $('<span class="pull-left text-center" style="width: 100%; position:relative">'+settings.text+'</span>');
					container.append(container_text);
				}
				var w =container.width(), h = container.height();
				var ml = ($(window).width() - w)/2, mt = ($(window).height() - h)/2;
				lbar = that.find('div.loading-bar');
				lbar
					.css('width', w+'px')
					.css('height', h+'px')
					.css('left', ml+'px')
					.css('top', mt+'px')
					.css('z-index', 6000);
			}
		};

		methods.construct();
		return this;
	}
})(jQuery);