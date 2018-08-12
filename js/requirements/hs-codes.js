(function($){
	'use strict';

	$.fn.HsCodes = function(options, method){
		var defaults= {
			
		},
		settings = $.extend(true, defaults, options),
		that = this,

		methods = {
			construct: function(){

			},
			add: function(){
				var tbody = that.find('#tbl-hs-codes tbody'),
					activeRow = tbody.find('tr.hidden-row').clone(true).removeClass('d-none').removeClass('hidden-row'),
					btnAddCode,
					btnDeleteRow,
					tooltipOptions = {html: true, trigger: 'hover', placement: 'auto'};

				tbody.prepend(activeRow);
				btnAddCode = activeRow.find('a.btn-add-hs-code');
				btnDeleteRow = activeRow.find('a.btn-delete-row');

				btnAddCode.tooltip(tooltipOptions);
				btnAddCode.on('click', function(){
					_showCodes(activeRow)
				})

				btnDeleteRow.tooltip(tooltipOptions);
				btnDeleteRow.on('click', function(){
					$(this).closest('tr').remove()
				});
				//_sum()
			},
			set: function(){
				var rows = that.find('#tbl-hs-codes tbody tr').not('.hidden-row'),
					hidden = that.find('#operation_ncm_codes'),
					codes = [];

				hidden.val('')
				if(rows.length > 0){
					rows.each(function(){
						var self = $(this),
							hscode = $.trim(self.find('input.hs-code').val()),
							hsvalue = $.trim(self.find('input.hs-value').val()),
							hsdescription = $.trim(self.find('input.hs-description').val());

						codes.push({code: hscode, value: hsvalue, description: hsdescription})
					})
					hidden.val(JSON.stringify(codes))
				}
			},
			sum: function(){
				var rows = that.find('#tbl-hs-codes tbody tr').not('.hidden-row'),
					grandTotal = that.find('#operation_value'),
					sum = 0;

				rows.find('input.hs-value').each(function(){
					sum += parseInt($(this).val());
				});
				grandTotal.val(sum);
			}
		}

		methods.construct();
		if(methods[method] != undefined){
			methods[method].apply(this)
		}
		return this;

		/*-----------------------------------------------------------------------
		|	METODOS PRIVADOS                                                    |
		-----------------------------------------------------------------------*/

		function _showCodes(row){
			$.fn.request({
				url: BaseUrl+'index.php/Requirements/HsCodes',
				type: 'GET',
				showLoadingBar: true
			}).then(
				function(response){
					var modal;
					DomRootEl.append(response);
					modal = DomRootEl.find('#modal-hs-codes');
					modal.modal();

					modal.on('shown.bs.modal', function(){
						var self = $(this),
							btnAdd = self.find('#btn-insert-code'),
							code = $.trim(row.find('td').eq(0).find('input').val());
						$.fn.request({
							url: BaseUrl+'index.php/Requirements/HsCodes/load',
							data: {code: code},
							type: 'GET'
						}).then(
							function(r){
								var grid,
									insert = function(data){
										row.find('td').eq(0).find('input').val(data.code);
										row.find('td').eq(2).find('input').focus();
										modal.modal('hide')
									};
								FGHs.data = $.parseJSON(r);
								grid = new FancyGrid(FGHs);

								grid.on('rowdblclick', function(g, o){
									insert(o.item.data)
									
								});
								grid.on('rowclick', function(g, o){
									btnAdd
										.removeAttr('disabled')
										.on('click', function(){
											insert(o.item.data)
										});
								})
								
								self.find('a[href="http://www.fancygrid.com"]').remove();
								self.find('#grid-hs-codes').addClass('w-100')
							}
						)
					});
					modal.on('hidden.bs.modal', function(){
						$(this).remove();
					})
				}
			)
		}

		function _sum(){
			var rows = that.find('#tbl-hs-codes tbody tr').not('.hidden-row'),
				grandTotal = that.find('#operation_value'),
				sum = 0;

			rows.find('input.hs-value').each(function(){
				$(this).on('blur', function(){
					sum += parseInt($(this).val());
					grandTotal.val(sum);
				});
			});
		}
	}
})(jQuery);