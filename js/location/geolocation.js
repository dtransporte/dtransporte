(function($){
	'use strict';

	$.fn.Geolocation = function(options){
		var defaults= {
				showMap: false,
				prefix: '' // '', o-, d-
			},
			settings = $.extend(true, defaults, options),
			that = this,
			geocoder = new google.maps.Geocoder(),
			geoLocOptions = {
				enableHighAccuracy: true, 
				maximumAge : Infinity, 
				timeout : 27000
			},
			geolocate,
			methods = {
				construct: function(){
					if (navigator.geolocation) {
						geolocate = navigator.geolocation.getCurrentPosition(_geoSuccess, _geoError, geoLocOptions);
					}
					else {
						DomRootEl.Message(geoLocError, 'set');
					}
				}
			}
		methods.construct();
		return this;

		/*-----------------------------------------------------------------------
		|	METODOS PRIVADOS                                                    |
		-----------------------------------------------------------------------*/

		function _geoSuccess(position){
			var latLng = {lat: position.coords.latitude, lng: position.coords.longitude};
			geocoder.geocode({location: latLng}, function(results, status){
				if(status === 'OK'){
					that.FillAddress({
						showMap: settings.showMap,
						place: results[0],
						prefix: settings.prefix
					})
				}
			})
			navigator.geolocation.clearWatch(geolocate)
		}

		function _geoError(error){
			var msg = {cls: 'warning', message: error.code+'<br>'+ error.message};
			DomRootEl.Message(msg, 'set');
		}
	}
})(jQuery);