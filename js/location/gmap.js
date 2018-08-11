(function($){
	'use strict';

	$.fn.Gmap = function(options, method){
		var defaults = {
			latlng: {}, //{lat: -25.344, lng: 131.036}
			zoom: 10,
			prefix: '' // '', o-, d-
		},
		settings = $.extend(true, defaults, options),
		that = this,
		map,
		idMap = DomRootEl.find('#map').attr('id'),

		methods = {
			construct: function(){
				var latlng = $.isEmptyObject(settings.latlng) ? _setLatLng(that) : settings.latlng,
					map = new google.maps.Map(document.getElementById(idMap), {
					center: latlng,
					zoom: settings.zoom
				}),
				markerOptions = {
					position: latlng,
					animation: google.maps.Animation.DROP,
					map: map
				};
				var marker = new google.maps.Marker(markerOptions);
				var content = '<p class="alert alert-light text-dark">'+that.find('input.autocomplete').val()+'</p>';
				var infowindow = new google.maps.InfoWindow({
					content: content
				});
				marker.addListener('click', function() {
					infowindow.open(map, marker);
				})
			},
			route: function(){
				var directionsService = new google.maps.DirectionsService,
       				directionsDisplay = new google.maps.DirectionsRenderer,
       				origin = _setLatLng(DomRootEl.find('#origin-address'), 'o-'),
       				destination = _setLatLng(DomRootEl.find('#destination-address'), 'd-'),
       				map = new google.maps.Map(document.getElementById(idMap), {
						center: settings.location
					});

       			directionsDisplay.setMap(map);
       			directionsDisplay.setPanel(document.getElementById('data-panel'));
       			directionsService.route({
					origin: new google.maps.LatLng(origin.lat, origin.lng),
					destination: new google.maps.LatLng(destination.lat, destination.lng),
					waypoints: _setWayPoints(),
					travelMode: 'DRIVING'
				}, function(response, status) {
					if (status === 'OK') {
						directionsDisplay.setDirections(response);
					}
					else {
						DomRootEl.Message({
							cls: 'danger',
							message: status
						}, 'set')
					}
				});
			},
		}

		methods.construct();
		if(methods[method] != undefined){
			methods[method].apply(this)
		}
		return this;

		/*-----------------------------------------------------------------------
		|	METODOS PRIVADOS                                                    |
		-----------------------------------------------------------------------*/

		function _setLatLng(container, prefix){
			var p = prefix == undefined ? settings.prefix : prefix;
			return {
				lat: parseFloat(container.find('input[name="'+p+'latitude"]').val()),
				lng: parseFloat(container.find('input[name="'+p+'longitude"]').val())
			}
		}

		function _setWayPoints(){
			var waypoints = [],
				wps = DomRootEl.find('#wp-cloned div.row');
			if(wps.length != undefined){
				wps.each(function(){
					var self = $(this),
						address = $.trim(self.find('input.autocomplete').val());
					if(address != ''){
						waypoints.push({location: address, stopover: true})
					}
				})
			}
			return waypoints
		}

	}
})(jQuery);