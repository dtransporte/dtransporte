(function($){
	'use strict';

	$.fn.WayPoints = function(){
		var that = this,
		container = that.find('#wp-cloned'),
		hiddenWp = DomRootEl.find('#hidden-waypoints'),

		methods = {
			construct: function(){
				var clonedWp = hiddenWp.find('div.row').clone(true);

				clonedWp
				.appendTo(container)
				.find('a.btn-delete-waypoint-content, a.btn-delete-waypoint')
				.tooltip({
					html: true,
					trigger: 'hover',
					placement: 'auto'
				});
				clonedWp.find('input.autocomplete').attr('name', 'wp-address[]');
				clonedWp.find('input.wp-notes').attr('name', 'wp-notes[]');
				clonedWp.find('a.btn-delete-waypoint-content').on('click', function(){
					$(this).closest('div.row').find('input[type="text"]').val('')
				});
				clonedWp.find('a.btn-delete-waypoint').on('click', function(){
					$(this).closest('div.row').remove();
					_setAutocomplete();
					_sort()
				});
				_setAutocomplete();
				_sort();
			}
		}

		methods.construct();
		return this;

		/*-----------------------------------------------------------------------
		|	METODOS PRIVADOS                                                    |
		-----------------------------------------------------------------------*/
		
		function _setAutocomplete(){
			var rows = container.find('div.row');
			if(rows.length != undefined){
				rows.each(function(){
					var self = $(this);
					self.find('input.autocomplete').attr('id', 'wp-'+self.index());
					self.AutoComplete({
						setRestrictions: false,
						fillAddress: false
					})
				})
			}
		}

		function _sort(){
			var elements = container.find('div.row'),
				msg = that.find('#drag-message');

			if(elements.length > 1){
				msg.removeClass('d-none');
				container.sortable({
					start: function(event, ui){
						ui.item
							.css('border', '2px dashed #666666')
					},
					stop: function(event, ui){
						ui.item
							.css('border', 'none')
					}
				})
			}
			else{
				msg.addClass('d-none');
				container.sortable();
				container.sortable('destroy')
			}
		}
	}
})(jQuery)