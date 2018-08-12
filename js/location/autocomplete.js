(function($){
	'use strict';

	$.fn.AutoComplete = function(options){
		var defaults = {
			showMap: false,
			setRestrictions: true,
			fillAddress: true,
			prefix: '' // '', o-, d-
		},
		settings = $.extend(true, defaults, options),
		that = this,
		idElement = that.find('input.autocomplete').attr('id'),
		options = {
			//types: ['geocode']
		},
		selCountry = that.find('[name="'+settings.prefix+'country"]'),
		autocomplete,

		methods = {
			construct: function(){
				new google.maps.event.clearInstanceListeners(document.getElementById(idElement));
				if(settings.setRestrictions == true){
					options.componentRestrictions = {country: selCountry.val()};
				}
				autocomplete = new google.maps.places.Autocomplete(document.getElementById(idElement), options);
				
				if(settings.fillAddress == true){
					autocomplete.addListener('place_changed', _fill);
				}
				DomRootEl.find('div.pac-container').css('z-index', 10000000000000)
			}
		}

		methods.construct();
		return this;

		/*-----------------------------------------------------------------------
		|	METODOS PRIVADOS                                                    |
		-----------------------------------------------------------------------*/
		
		function _fill(){
			var place = autocomplete.getPlace();
			that.FillAddress({
				showMap: settings.showMap,
				place: place,
				prefix: settings.prefix
			})
		}
	}
})(jQuery);