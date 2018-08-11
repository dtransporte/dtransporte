(function($){
	'use strict';

	$.fn.Ranking = function(options, method){
		var defaults= {
			requirement: null
		},
		settings = $.extend(true, defaults, options),
		that = this,

		methods = {
			showModal: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Users/RankUser',
					type: 'GET',
					data: {id_requirement: settings.requirement.id_requirement, id_quotation: settings.requirement.id_quotation},
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						DomRootEl.append(response);
						modal = DomRootEl.find('#modal-show-ranking');
						modal.modal();

						modal.on('shown.bs.modal', function(){
							var self = $(this),
								form = self.find('form'),
								container = form.find('#ranking-concepts'),
								sliders = container.find('div.slider'),
								values = $.parseJSON(container.attr('data-ranking-values'));
								
							sliders.each(function(){
								$(this).slider({
									min: parseInt(values.min),
									max: parseInt( values.max),
									step: parseFloat(values.step),
									orientation: 'horizontal',
									slide: function(e, ui){
										var span = $(this).parent('div').find('span.ranking-value')
										span.text(ui.value);
										$(this).parent('div').find('input[type="hidden"]').val(ui.value)
									},
									change: function(e, ui){
										var total = _getTotal(sliders).toFixed(2),
											percent = (total / values.max*100).toFixed(2);
										container.find('#total-ranking').text(total+' - '+percent+'%')
									}
								})
							});
							self.find('#btn-rank').on('click', function(){
								form.request({
									url: BaseUrl+'index.php/Users/RankUser/insert',
									showLoadingBar: true
								}).then(
									function(response){
										var r = $.parseJSON(response);
										DomRootEl.Message(r, 'set')
									}
								)
							})
						})
						modal.on('hidden.bs.modal', function(){
							$(this).remove()
						})
					}
				)
			},
			show: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Users/RankUser/show',
					type: 'GET',
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						DomRootEl.append(response);
						modal = DomRootEl.find('#modal-user-ranking');
						modal.modal();

						modal.on('shown.bs.modal', function(){
							var self = $(this),
								data = self.find('#data-ranking'),
								table = self.find('#tbl-users-ranking'),
								tblOptions = $.parseJSON(data.val());
							console.log(tblOptions)
							table.bootstrapTable(tblOptions);
							table.on('expand-row.bs.table', function(e, index, row, detail){
								$(detail).empty().append('<div class="alert alert-primary"></div>');
								var container = $(detail).find('div.alert'),
									tbl;
								
								container.append('<table></table>');
								tbl = $(detail).find('table');
								$.fn.request({
									url: BaseUrl+'index.php/Users/RankUser/getSubTable',
									data: {id_ranking: row.id_ranking, ranked_by: row.ranked_by},
									type: 'GET',
									showLoadingBar: true
								}).then(
									function(resp){
										var r = $.parseJSON(resp);
										tbl.bootstrapTable(r)
										console.log(r)
									}
								)
							})
						});
						modal.on('hidden.bs.modal', function(){
							$(this).remove()
						})
					}
				)
			}
		}

		methods[method].apply(this);
		return this;

		function _getTotal(sliders){
			var totalSliders = sliders.length,
				total = 0;
			sliders.each(function(){
				var val = $(this).parent('div').find('span.ranking-value').text();
				total += parseFloat(val)
			});
			return total/totalSliders
		}
	}
})(jQuery);