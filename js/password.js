(function($){
	'use strict';
	$.fn.showHidePwd = function(){
		var input = this.find('input.password');
		$.each(input, function(){
			var self = $(this);
			if(self.attr('type') == 'password'){
				self.attr('type', 'text')
			}
			else{
				self.attr('type', 'password')
			}
		})
		return this
	}

	$.fn.randomPassword = function(options){
		var defaults = {
			minlength: 6,
			maxlength: 12,
			fixedlength: 0,
			type: 'alfanum' // alfanum, alfa, num, specialchars
		};
		var settings = $.extend(defaults, options);
		var ascii_val = 0;
		var ascii = '';
		var len = 0;
		//if(settings.fixedlength>settings.minlength && settings.fixedlength<=settings.maxlength){
		if(settings.fixedlength > 0){
			len = settings.fixedlength
		}
		else{
			len = Math.round((Math.random() * settings.maxlength));
			if(len<settings.minlength){
				len = settings.minlength
			}
		}
		
		do{
			ascii_val = Math.floor(Math.random()*126);
			if(settings.type == 'alfanum'){
				if((ascii_val>47 && ascii_val<58) || (ascii_val>64 && ascii_val<91) || (ascii_val>96 && ascii_val<123)){
					ascii += String.fromCharCode(ascii_val);
				}
			}
			if(settings.type == 'alfa'){
				if((ascii_val>64 && ascii_val<91) || (ascii_val>96 && ascii_val<123)){
					ascii += String.fromCharCode(ascii_val);
				}
			}
			if(settings.type == 'num'){
				if((ascii_val>47 && ascii_val<58)){
					ascii += String.fromCharCode(ascii_val);
				}
			}
			if(settings.type == 'specialchars'){
				if((ascii_val>32 && ascii_val<126)){
					ascii += String.fromCharCode(ascii_val);
				}
			}
		}while(ascii.length < len)
		
		if(this.is('input')){
			this.val(ascii)
		}
		else if(this.is('div') || this.is('span')){
			this.text(ascii)
		}
		else{
			return ascii
		}
		return this;
	}
})(jQuery);