(function($){
	'use strict';

	$.fn.CargoSpecials = function(method){
		//settings = $.extend(true, defaults, options),
		var that = this,
			container = this.find('#cargo-specials'),
			sel = container.find('#cargo-additionals'),
			tbody = container.find('#tbl-cargo-additionals tbody'),
			activeRow = tbody.find('tr.hidden-row-additionals'),

		methods = {
			init: function(){
				sel.on('change', function(e){
					var self = $(this),
						val = self.selectpicker('val'),
						text,
						newRow;
					if(val != 'others'){
						text = self.find('option:selected').html()
					}
					else{
						text = '<input type="text" class="form-control additionals-others" maxlength="20" placeholder="Max 20 car">'
					}
					if(!exists(val)){
						newRow = activeRow
							.clone(true)
							.appendTo(tbody)
							.removeClass('d-none')
							.removeClass('hidden-row-additionals')
							//.addClass('row-'+val)
							.attr('id', val)
							.find('td').eq(0).append(text)
							.closest('tr').find('a.btn-delete-item').on('click', function(){
								$(this).closest('tr').remove()
							});
					}
					else{
						tbody.find('#'+val+' td').eq(1).find('input').focus()
					}
					self.val('')
				})
			},
			set: function(){
				var rows = tbody.find('tr').not('.hidden-row-additionals'),
					hidden = container.find('#cargo_additionals'),
					data = [];

				hidden.val('');
				if(rows.length > 0){
					rows.each(function(){
						var self = $(this),
							item = self.attr('id'),
							name = self.find('td').eq(0).find('input').val(),
							qty = $.trim(self.find('td').eq(1).find('input').val()),
							place = self.find('td').eq(2).find('select').val(),
							notes = self.find('td').eq(3).find('input').val();

						data.push({
							item: item,
							name: typeof name == "undefined" ? self.find('td').eq(0).html() : name,
							quantity: qty,
							place: place,
							notes: notes
						})
					})
					hidden.val(JSON.stringify(data))
				}
			}
		}

		methods[method].apply(this);
		return this;


		function exists(val){
			var rows = tbody.find('tr'),
				exist = false;
			if(val != 'others'){
				rows.each(function(){
					if($(this).hasClass('row-'+val)){
						exist = true;
					}
				})
			}
			return exist
		};
	}
})(jQuery);