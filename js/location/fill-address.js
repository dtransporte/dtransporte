(function($){
	'use strict';

	$.fn.FillAddress = function(options, method){
		var defaults = {
			showMap: false,
			place: [],
			setTimeZones: true,
			setPhonePrefix: true,
			prefix: '' // '', o-, d-
		},
		settings = $.extend(true, defaults, options),
		that = this,
		fields = this.find('input[fill-location=""]'),
		componentForm = {
			locality: 'long_name',
			administrative_area_level_1: 'long_name',
			country: 'short_name',
			postal_code: 'short_name'
		},

		methods = {
			construct: function(){
				fields.val('');
				_setAddress();
				if(settings.setTimeZones == true){
					_setTimeZones()
				}
				if(settings.setPhonePrefix == true){
					var phonePrefix = that.find('select[name="'+settings.prefix+'country"]').find('option:selected').attr('data-phone-prefix');
					that.find('input[name="'+settings.prefix+'phone_prefix"]').val(phonePrefix);
				}
			}
		};

		methods.construct();
		return this;

		/*-----------------------------------------------------------------------
		|	METODOS PRIVADOS                                                    |
		-----------------------------------------------------------------------*/

		function _setAddress(){
			for (var i = 0; i < settings.place.address_components.length; i++) {
				var address_type = settings.place.address_components[i].types[0];
				if (componentForm[address_type]) {
					var val = settings.place.address_components[i][componentForm[address_type]],
						element = that.find('input[name="'+settings.prefix+address_type+'"]');
					element.val(val)
					if(address_type === 'country'){
						that.find('select[name="'+settings.prefix+'country"]').selectpicker('val', val);
					}
				}
			}
			that.find('input[name="'+settings.prefix+'address"]').val(settings.place.formatted_address);
			that.find('input[name="'+settings.prefix+'latitude"]').val(settings.place.geometry.location.lat);
			that.find('input[name="'+settings.prefix+'longitude"]').val(settings.place.geometry.location.lng);
			that.find('input[name="'+settings.prefix+'place_id"]').val(settings.place.place_id);
			if(settings.showMap == true){
				that.Gmap({
					prefix: settings.prefix
				})
			}
		}

		function _setTimeZones(){
			var lat = settings.prefix + 'latitude',
				lng = settings.prefix + 'longitude',
				location = that.find('input[name="'+lat+'"]').val()+','+that.find('input[name="'+lng+'"]').val(),
				timestamp = moment().unix();
			$.fn.request({
				url: 'https://maps.googleapis.com/maps/api/timezone/json?location='+location+'&timestamp='+timestamp+'&language='+ActiveLang+'&key=AIzaSyC7gYBywHDf_IxnCPzbM3wHHsPDi90mwBg',
				type: 'GET'
			}).then(
				function(response){
					var r = $.parseJSON(response);
					if(r.status === 'OK'){
						that.find('input[name="user_timezone"]').val(r.timeZoneId);
						that.find('input[name="user_tz_offset"]').val(parseInt(r.rawOffset)/3600)
					}
				}
			)
		}
	}
})(jQuery);

/*
	{
		"address_components":[
			{"long_name":"3482","short_name":"3482","types":["street_number"]},
			{"long_name":"León Pérez","short_name":"León Pérez","types":["route"]},
			{"long_name":"Montevideo","short_name":"Montevideo","types":["locality","political"]},
			{"long_name":"Montevideo","short_name":"Montevideo","types":["administrative_area_level_1","political"]},
			{"long_name":"Uruguay","short_name":"UY","types":["country","political"]},
			{"long_name":"12300","short_name":"12300","types":["postal_code"]}
		],
		"formatted_address":"León Pérez 3482, 12300 Montevideo, Uruguay",
		"geometry":{"location":{"lat":-34.8545708,"lng":-56.16595810000001},
		"location_type":"RANGE_INTERPOLATED",
		"viewport":{"south":-34.8559197802915,"west":-56.16730708029149,"north":-34.8532218197085,"east":-56.16460911970853}},
		"place_id":"EixMZcOzbiBQw6lyZXogMzQ4MiwgMTIzMDAgTW9udGV2aWRlbywgVXJ1Z3VheSIbEhkKFAoSCUWfQZODKqCVEZj2O3Z4ZSvAEJob",
		"types":["street_address"]
	}
*/