var Captcha = (function(){
	'use strict',
	
	refresh = function(container){
		$.fn.request({
			url: BaseUrl+'index.php/captcha',
			type: 'GET',
			showLoadingBar: true
		}).then(
			function(response){
				var captcha = $.parseJSON(response),
					c = container == undefined ? DomRootEl : container;
				c.find('#captcha-word').val(captcha.word);
				c.find('#image-captcha').empty().append(captcha.image);
			}
		)
	}

	return{
		refresh: refresh
	}
})();