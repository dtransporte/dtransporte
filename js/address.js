(function($){
	'use strict';

	$.fn.Address = function(options, method){
		var defaults = {
			address: null,
			location: null, //{"lat":-34.9011127,"lng":-56.16453139999999}
			route: {
				origin: null, //{"lat":-34.9011127,"lng":-56.16453139999999}
				destination: null, //{"lat":-34.9011127,"lng":-56.16453139999999}
				waypoints: null
			},
			clearFields: null,
			componentForm: null,
			iconMarker: null,
			fillAddress: false,
			setRestrictions: true,
			restrictions: null,
			showMap: true,
			showPhonePrefix: false,
			showGeoLocactionMessage: false,
			setTimeZone: true,
			idMap: null,
			title: '',
			zoom: 12,
			infoWindow: false,
			infoWindowContent: '',
			geoLocOptions:{
				enableHighAccuracy: true, 
				maximumAge : Infinity, 
				timeout : 27000
			}
		},
		settings = $.extend(true, defaults, options),
		that = this,
		geolocate,
		geocoder,
		autocomplete,
		addressType = null,
		componentForm = {
			locality: 'long_name',
			administrative_area_level_1: 'long_name',
			country: 'short_name',
			postal_code: 'short_name'
		},
		idMap = settings.idMap == null ? 'map' : settings.idMap,
		selCountry = that.find('select.country'),

		methods = {
			construct: function(){
				geocoder = new google.maps.Geocoder();
				_setRestrictions();
				selCountry.on('changed.bs.select', function(){
					var self = $(this);
					_clear();
					if(settings.showPhonePrefix == true){
						_setPhonePrefix()
					}
					_setRestrictions();
				})
			},
			locateMe: function(){
				if (navigator.geolocation) {
					geolocate = navigator.geolocation.getCurrentPosition(_geoSuccess, _geoError, settings.geoLocOptions);
				}
				else {
					DomRootEl.Message(geoLocError, 'set');
				}
			},
			showMap: function(){
				_showMap(settings.location, settings.title)
			},
			fill: function(){
				that.find('input.autocomplete').val(settings.componentForm.address);
				if(selCountry.hasClass('selectpicker')){
					that.find('select.country').selectpicker('val', settings.componentForm.country);
				}
				else{
					selCountry.val(settings.componentForm.country);
				}
				that.find('input.locality').val(settings.componentForm.administrative_area_level_1);
				//that.find('input.region').val(settings.componentForm.region);
				that.find('input.postal_code').val(settings.componentForm.zipcode);
				that.find('input.latitude').val(settings.componentForm.latitude);
				that.find('input.longitude').val(settings.componentForm.longitude);
				that.find('input.place_id').val(settings.componentForm.place_id);
			},
			autoComplete: function(){
				var idElement = that.find('input.autocomplete').attr('id'),
					options = {
						//types: ['geocode']
					};
				_destroyAutoComplete(idElement);
				if(settings.setRestrictions == true && settings.restrictions != null){
					options.componentRestrictions = settings.restrictions
				}
				autocomplete = new google.maps.places.Autocomplete(document.getElementById(idElement), options);
				if(settings.fillAddress == true){
					autocomplete.addListener('place_changed', _fill);
				}
			},
			route: function(){
				var directionsService = new google.maps.DirectionsService,
       				directionsDisplay = new google.maps.DirectionsRenderer,
       				map = new google.maps.Map(document.getElementById(idMap), {
						center: settings.location
					});
       			
       			directionsDisplay.setMap(map);
       			directionsDisplay.setPanel(document.getElementById('data-panel'));
       			directionsService.route({
					origin: settings.route.origin,
					destination: settings.route.destination,
					waypoints: settings.route.waypoints,
					travelMode: 'DRIVING'
				}, function(response, status) {
					if (status === 'OK') {
						directionsDisplay.setDirections(response);
					}
					else {
						DomRootEl.Message({
							cls: 'danger',
							message: 'Fallo en la solicitud debido a: '+status
						}, 'set')
					}
				});
			},
			clear: function(){
				_clear()
			},
			restore: function(){
				var id_address = that.attr('data-address');
				$.fn.request({
					url: BaseUrl+'index.php/Address/restore',
					type: 'GET',
					data: {id_address: id_address},
					showLoadingBar: true
				}).then(
					function(response){
						var r = $.parseJSON(response);
						$.each(r, function(k, v){
							that.find('.'+k).val(v)
						});
						if(settings.showMap == true){
							var center = {lat: parseFloat(r.latitude), lng: parseFloat(r.longitude)}
							_showMap(center, '')
						}
						if(settings.setTimeZone == true){
							_setTimeZones()
						}
					}
				)
			}
		};

		methods.construct();
		methods[method].apply(this);
		return this;

		function _geoSuccess(position){
			var latLng = {lat: position.coords.latitude, lng: position.coords.longitude};
			geocoder.geocode({location: latLng}, function(results, status){
				if(status === 'OK'){
					_fill(results[0]);
					return
				}
			})
			navigator.geolocation.clearWatch(geolocate)
		}

		function _geoError(error){
			if(settings.showGeoLocactionMessage == true)
			{
				var msg = {cls: 'warning', message: error.code+'<br>'+ error.message};
				DomRootEl.Message(msg, 'set');
			}
			return false;
		}

		function _fill(data){
			var place = data == undefined ? autocomplete.getPlace() : data,
				idElement = that.attr('id');

			//console.log(place)
			if(data != undefined){
				that.find('input.autocomplete').val(place.formatted_address);
			}
			for (var i = 0; i < place.address_components.length; i++) {
				var address_type = place.address_components[i].types[0];
				if (componentForm[address_type]) {
					var val = place.address_components[i][componentForm[address_type]];
					that.find('.'+address_type).val(val)
					if(selCountry.hasClass('selectpicker') && address_type === 'country'){
						that.find('.'+address_type).selectpicker('val', val);
					}
				}
			}
			that.find('input.latitude').val(place.geometry.location.lat);
			that.find('input.longitude').val(place.geometry.location.lng);
			that.find('input.place_id').val(place.place_id);

			if(settings.showMap == true){
				_showMap(place.geometry.location, place.name)
			}
			if(settings.showPhonePrefix == true){
				_setPhonePrefix()
			}
			if(settings.setTimeZone == true){
				_setTimeZones()
			}
		}

		function _clear(){
			var components = settings.clearFields != null ? settings.clearFields : componentForm;
			$.each(components, function(k, v){
				if(k != 'country'){
					that.find('.'+k).val('');
				}
			});
			if(settings.clearFields == null){
				that.find('input.latitude').val('');
				that.find('input.longitude').val('');
				that.find('input.place_id').val('');
				that.find('input.postal_code').val('');
				that.find('input.locality').val('');
			}
			that.find('input.user_tz_offset').val('');
			that.find('input.user_timezone').val('');
		}

		function _showMap(latlng, title){
			var map = new google.maps.Map(document.getElementById(idMap), {
					center: latlng,
					zoom: settings.zoom
				}),
				markerOptions = {
					position: latlng,
					map: map,
					title: title
				};
			if(settings.iconMarker != null){
				markerOptions.icon = settings.iconMarker
			}
			var marker = new google.maps.Marker(markerOptions);
			if(settings.infoWindow == true){
				var infowindow = new google.maps.InfoWindow({content: settings.infoWindowContent});
				marker.addListener('click', function() {
					infowindow.open(map, marker);
				});
			}
		}

		function _destroyAutoComplete(idElement){
			new google.maps.event.clearInstanceListeners(document.getElementById(idElement));
		}

		function _setPhonePrefix(){
			var phone_prefix = selCountry.find('option:selected').attr('data-phone-prefix');

			that.find('.phone_prefix').val(phone_prefix.replace('+', ''));
		}

		function _setTimeZones(){
			var location = '',
				timestamp = moment().unix();
			if(settings.location == null){
				location = that.find('input[name="latitude"]').val()+','+that.find('input[name="longitude"]').val()
			}
			else{
				location = settings.location.lat+','+settings.location.lng
			}
			$.fn.request({
				url: 'https://maps.googleapis.com/maps/api/timezone/json?location='+location+'&timestamp='+timestamp+'&language='+ActiveLang+'&key=AIzaSyC7gYBywHDf_IxnCPzbM3wHHsPDi90mwBg',
				type: 'GET'
			}).then(
				function(response){
					var r = $.parseJSON(response);
					if(r.status === 'OK'){
						that.find('input.user_timezone').val(r.timeZoneId);
						//that.find('input.user_timezone-text').text(r.timeZoneId);
						that.find('input.user_tz_offset').val(parseInt(r.rawOffset)/3600)
					}
				}
			)
		}

		function _setRestrictions(){
			if(settings.setRestrictions == true){
				settings.restrictions = {country: selCountry.val()}
			}
			console.log(settings.restrictions)
		}
	}
})(jQuery);

/*
	place
	{
		"address_components":[
			{"long_name":"3456","short_name":"3456","types":["street_number"]},
			{"long_name":"León Pérez","short_name":"León Pérez","types":["route"]},
			{"long_name":"Montevideo","short_name":"Montevideo","types":["locality","political"]},
			{"long_name":"Montevideo","short_name":"Montevideo","types":["administrative_area_level_1","political"]},
			{"long_name":"Uruguay","short_name":"UY","types":["country","political"]},
			{"long_name":"12300","short_name":"12300","types":["postal_code"]}
		],
			"adr_address":"<span class=\"street-address\">León Pérez 3456</span>, <span class=\"postal-code\">12300</span> <span class=\"locality\">Montevideo</span>, <span class=\"country-name\">Uruguay</span>",
			"formatted_address":"León Pérez 3456, 12300 Montevideo, Uruguay",
			"geometry":{"location":{"lat":-34.8546699,"lng":-56.16571959999999},
			"viewport":{"south":-34.8560262802915,"west":-56.167071230291526,"north":-34.8533283197085,"east":-56.164373269708506}
	},
	"icon":"https://maps.gstatic.com/mapfiles/place_api/icons/geocode-71.png",
	"id":"232dc60b74b5520bf7a65ebce276b5ba71cb8bf1",
	"name":"León Pérez 3456",
	"place_id":"EixMZcOzbiBQw6lyZXogMzQ1NiwgMTIzMDAgTW9udGV2aWRlbywgVXJ1Z3VheQ",
	"reference":"CpQBigAAAEvQzJ7900_eWYbUmfemZ6tlmQVhl_sV4GU0gXF5YnKwchHJxcsB837DfWqCtcZ0Bal6StGm7aBdVeN9gTHoCgnlGb2SRkqZK7_j0EQKRdXuJ_S6riJSygDJnUs_6NeOsvXyH3bpV5xRmlX0mPjWHdQceQQhxcMF-aqm3xvK1IuoA8jWmeE55rzgTTqWevSpxhIQw0psgW2ejf3mh0yI9V0IkxoUaSF5rY23mO4UyqnqAepO46mIVhk",
	"scope":"GOOGLE",
	"types":["street_address"],
	"url":"https://maps.google.com/?q=Le%C3%B3n+P%C3%A9rez+3456,+12300+Montevideo,+Uruguay&ftid=0x95a02a8393419f45:0xdbe801e9ddf9eb5f",
	"utc_offset":-180,
	"vicinity":"Montevideo",
	"html_attributions":[]
	}
*/