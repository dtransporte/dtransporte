(function($){
	'use strict';

	$.fn.Products = function(options, method){
		var defaults= {
			dropContainer: 'body',
			containment: 'body',
			dropInsertEl: null
		},
		settings = $.extend(true, defaults, options),
		that = this,

		methods = {
			construct: function(){

			},
			show: function(){
				that.find('#btn-add-requirement').on('click', function(e){
					e.preventDefault();
					$.fn.request({
						url: BaseUrl+'index.php/Products/show',
						type: 'GET',
						showLoadingBar: true
					}).then(
						function(response){
							var modal;
							DomRootEl.append(response);
							modal = DomRootEl.find('#modal-show-products');

							modal.modal();
							modal.on('shown.bs.modal', function(){
								var self = $(this),
									prodContainer = self.find('div.card');

								self.find('[data-toggle="tooltip"]').tooltip({html: true});
								prodContainer
									.on('mouseover', function(){
										$(this).addClass('border-primary')
									})
									.on('mouseout', function(){
										$(this).removeClass('border-primary')
									})
							});

							modal.on('hidden.bs.modal', function(){
								$(this).remove()
							})
						}
					)
				})
			},
			byUser: function(){
				var form = that.closest('form'),
					oldProducts = settings.dropContainer.find('.container-dragged');

				// Si existen servicios agregados por el usuario, los inicializa. 
				if(oldProducts.length > 0){
					_getPrice();
					oldProducts.find('.change-item').on('click', function(e){
						e.stopImmediatePropagation();
						_showCountries($(this).closest('.container-dragged').find('div.media'));
					});
					oldProducts.find('.delete-full-item').on('click', function(e){
						e.stopImmediatePropagation();
						_deleteFullItem($(this).closest('.container-dragged').find('div.media'));
					})
				}
				that.draggable({
					containment: settings.containment,
					cursor: 'crosshair',
					revert: true,
					revertDuration: 500,
					distance: 50,
					addClasses: false,
					drag: function(e, ui){
						ui.helper.css('border', '2px dashed gray').css('z-index', 1000)
					},
					stop: function(e, ui){
						e.stopImmediatePropagation();
						var self = ui.helper;

						if(settings.dropInsertEl != null){
							var insertEl = settings.dropInsertEl.clone(true),
								exists = function(elem){
									var elem = settings.dropContainer.find('#'+elem.attr('id'));
									if(elem.length == 0){
										return false
									}
									return true
								},
								el = self.clone();
							
							self.css('border', 'none');
							if(!exists(el)){
								insertEl.prependTo(settings.dropContainer)
									.find('.element-dragged')
									.append(el)
									.find('div.media').css('border', 'none');
								
								el.closest('.container-dragged').find('.delete-item').on('click', function(){
									_deleteFullItem(el)
								}).tooltip({
									html: true,
									trigger: 'hover',
									placement: 'auto'
								});
								el.closest('.container-dragged').find('.change-item').on('click', function(e){
									e.stopImmediatePropagation();
									_showCountries(el)
								}).tooltip({
									html: true,
									trigger: 'hover',
									placement: 'auto'
								});
								
								_setReceiveFromText(el);
								_getPrice();
								_saveProducts(form);
							}
						}
					}
				});
			},
			hazard: function(){
				that.draggable({
					containment: settings.containment,
					cursor: 'crosshair',
					revert: true,
					revertDuration: 500,
					distance: 50,
					addClasses: false,
					start: function(e, ui){
						ui.helper.css('border', '1px dashed gray').css('z-index', 1000)
					},
					stop: function(e, ui){
						e.stopImmediatePropagation();
						var self = ui.helper,
							insertEl,
							exists = function(e){
								var elems = settings.dropContainer.find('div.media'),
									val = false;
								elems.each(function(){
									if($(this).attr('id') === e.attr('id')){
										val = true
									}
								})
								return val
							};
						
						
						self.css('border', 'none');
						if(!exists(self)){
							insertEl = self.clone(true);
							insertEl
							.appendTo(settings.dropContainer)
							.css('border', 'none')
							.find('div.media-body')
							.append('<a class="btn btn-danger delete-item" role="button"><i class="fas fa-trash-alt"></i></a>')
							.on('click', function(){
								$(this).closest('div.media').remove()
							});
						}
					}
				})
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
		
		function _saveProducts(form){
			var sendData = form.find('input[name="receive_reqs_from"]'),
				dataProduct = settings.dropContainer.find('div.media'),
				results = [];
			if(dataProduct.length == 0){
				DomRootEl.Message(NoServiceSelected, 'set')
			}
			else{
				dataProduct.each(function(){
					var self = $(this),
						data = $.parseJSON(self.attr('data-product'));
					results.push(data)
				});
				sendData.val(JSON.stringify(results));
				form.request({
					url: BaseUrl+'index.php/Products/updateByUser',
					showLoadingBar: true
				}).then(
					function(response){
						var r = $.parseJSON(response);
						DomRootEl.find('input[name="csrf_test_name"]').val(r.hash);
						DomRootEl.Message(r.msg, 'set')
					}
				)
			}
		}

		function _getPrice(){
			var elems = settings.dropContainer.find('.container-dragged div.media'),
				prices = $.parseJSON(DomRootEl.find('div.accordion').attr('data-prices')),
				sum = prices.min,
				categories = [];
			elems.each(function(){
				var self = $(this),
					product = $.parseJSON(self.attr('data-product'));
				if($.inArray(product.id_category, categories) == -1){
					categories.push(product.id_category)
				}
			})
			if(categories.length > 1){
				for(var i=0; i < categories.length - 1; i++){
					sum += prices.step
				}
			}
			if(sum > prices.max){
				sum = prices.max
			}
			DomRootEl.find('#payment-amount').text(sum);
			DomRootEl.find('input[name="payment_price"]').val(sum)
		}

		function _deleteItem(el){
			el.closest('.container-dragged').find('.delete-item, .change-item').tooltip('dispose');
			el.closest('.container-dragged').remove();
			_getPrice();
		}

		function _deleteFullItem(el){
			var form = el.closest('form'),
				product = $.parseJSON(el.attr('data-product')),
				priceInput = form.find('input[name="payment_price"]'),
				activePrice = priceInput.val();

			$.fn.request({
				url: BaseUrl+'index.php/Products/updateByUser/remove',
				type: 'GET',
				data: {id_product: product.id_product}
			}).then(
				function(response){
					var r = $.parseJSON(response);
					DomRootEl.Message(r.message, 'set');
					if(r.message.cls === 'success'){
						var curPrice;
						_deleteItem(el);
						curPrice = priceInput.val();
						if(curPrice != activePrice){
							DomRootEl.find('input[name="csrf_test_name"]').val(r.hash);
							_saveProducts(form);
							location.href = CurUrl;
						}
					}
				}
			)
		}

		function _showCountries(el){
			var idEl = el.attr('id'),
				product = $.parseJSON(el.attr('data-product'));
			
			$.fn.request({
				url: BaseUrl+'index.php/Users/country/getAll',
				type: 'GET',
				showLoadingBar: true
			}).then(
				function(response){
					var modal,
						receiveReqsFrom = {};
					DomRootEl.append(response);
					modal = DomRootEl.find('#modal-show-countries');
					modal.modal();

					modal.on('shown.bs.modal', function(e){
						var self = $(this),
							blocks = product.receiveFrom,
							onlyMyCountry = self.find('#only-my-country'),
							allTheWorld = self.find('#all-the-world'),
							neighbourhood = self.find('#neighbours'),
							select = self.find('select'),
							selEblocks = self.find('#economic-blocks'),
							selCountries = self.find('#countries'),
							init = function(){
								var ec = $.parseJSON(modal.find('#economicBlocks').val());
								$.each(blocks, function(k, v){
									if(v === 'only-my-country'){
										onlyMyCountry.prop('checked', true);
										_setText(self, onlyMyCountry);
										return
									}
									else if(v === 'all-the-world'){
										allTheWorld.prop('checked', true);
										_setText(self, allTheWorld);
										return
									}
									else if(v === 'neighbours'){
										neighbourhood.prop('checked', true);
										_setText(self, neighbourhood)
									}
									else if(v in ec){
										selEblocks.find('option[value="'+v+'"]').attr('selected', 'selected');
									}
									else{
										selCountries.find('option[value="'+v+'"]').attr('selected', 'selected');
									}
								});
								if(selEblocks.find('option:selected').length > 0){
									selEblocks.selectpicker('refresh');
									_setText(self, selEblocks);
								}
								if(selCountries.find('option:selected').length > 0){
									selCountries.selectpicker('refresh');
									_setText(self, selCountries);
								}
							};

						select.selectpicker();
						init();
						self.find('#only-my-country, #all-the-world').on('click', function(e){
							e.stopPropagation();
							if($(this).is(':checked')){
								_setText(modal, $(this))
								self.find('input[type="checkbox"]').not($(this)).prop('checked', false);
							}
							else{
								self.find('fieldset div').empty()
							}
						});
						neighbourhood.on('click', function(e){
							e.stopPropagation();
							if($(this).is(':checked')){
								self.find('input[type="checkbox"]').not($(this)).prop('checked', false);
								self.find('div.neighbours').remove();
								_setText(modal, $(this))
							}
							else{
								self.find('div.neighbours').remove()
							}
						});
						selEblocks.on('hidden.bs.select', function(e){
							e.stopPropagation();
							self.find('div.economic-blocks').remove()
							_setText(modal, $(this));
						});
						selCountries.on('hidden.bs.select', function(e){
							e.stopPropagation();
							self.find('div.countries').remove()
							_setText(modal, $(this));
						});
						select.on('changed.bs.select', function(e){
							e.stopPropagation();
							self.find('#only-my-country, #all-the-world').prop('checked', false)
						})
						self.find('#btn-add-blocks').on('click', function(){
							var form = DomRootEl.find('#frm-assoc-products');
							_setReceiveFrom(self, el);
							_saveProducts(form);
							modal.modal('hide')
						})
						
					});
					modal.on('hidden.bs.modal', function(e){
						$(this).remove()
					})
				}
			)
		}

		function _setText(modal, elem){
			var id = elem.attr('id'),
				text = $.parseJSON(modal.find('#countryOptions').val()),
				container = modal.find('fieldset #container-countries'),
				html = '';
			
			if(id === 'only-my-country' || id === 'all-the-world'){
				var myCountry = $.parseJSON(modal.find('#myCountry').val());

				html += '<div class="alert alert-primary '+id+' border border-primary rounded">';
				html += '<h5>'+text[id]+'</h5>';
				if(id === 'only-my-country'){
					html += '<h5>'+myCountry.country+'</h5>';
				}
				html += '</div>';
				container.empty().append(html)
			}
			if(id === 'neighbours'){
				var neighbours = $.parseJSON(modal.find('#neighbourCountries').val());

				container.find('.only-my-country, .all-the-world').remove();
				html += '<div class="alert alert-primary '+id+' border border-primary rounded">';
				html += '<h5>'+text[id]+'</h5>';
				$.each(neighbours, function(k, v){
					html += '<span class="p-1 d-inline-flex">'+v.country+'</span>';
				})
				html += '</div>';
				container.append(html);
			}
			if(id === 'economic-blocks'){
				var val = elem.val(),
					ec = $.parseJSON(modal.find('#economicBlocks').val());

				container.find('.only-my-country, .all-the-world').remove();
				if(val.length > 0){
					html += '<div class="alert alert-primary '+id+' border border-primary rounded">';
					$.each(val, function(k, v){
						var title = ec[v].id_economic_block.toUpperCase() + ': '+ec[v].name_economic_block.toUpperCase();
						html += '<div class="'+ec[v].id_economic_block+'">';
						html += '<h5><u>'+title+'</u></h5>';
						html += '<p><i class="fas fa-link"></i> <a href="'+ec[v]['website']+'" target="_blank">'+ec[v]['website']+'</a></p>';
						$.each(ec[v].countries, function(key, value){
							var c = key + ' - ' + value;
							html += '<span class="p-1 d-inline-flex">'+c+'</span>';
						})
						html += '</div>';
					})
					html += '</div>';
				}
				container.append(html);
			}
			if(id === 'countries'){
				var val = elem.val(),
					ec = $.parseJSON(modal.find('#country-list').val());
				container.find('.only-my-country, .all-the-world').remove();
				if(val.length > 0){
					html += '<div class="alert alert-primary '+id+' border border-primary rounded">';
					$.each(val, function(k, v){
						var title = v.toUpperCase() + ': '+ec[v].toUpperCase();
						html += '<div class="'+v+'">';
						html += '<p>'+title+'</p>';
						html += '</div>';
					})
					html += '</div>';
				}
				container.append(html);
			}
		}

		function _setReceiveFromText(elem){
			var product = $.parseJSON(elem.attr('data-product')),
				blocks = product.receiveFrom,
				form = elem.closest('form'),
				countryText = $.parseJSON(form.find('#country-text').val()),
				eblockText = $.parseJSON(form.find('#eblocks-text').val()),
				countryListText = $.parseJSON(form.find('#countryList-text').val()),
				appendEl = elem.closest('div.container-dragged').find('.txt-selected-countries'),
				val = [];

			appendEl.html('');
			$.each(blocks, function(k, v){
				var val;
				if(countryText[v] != undefined){
					val = countryText[v]
				}
				else if(eblockText[v] != undefined){
					val = eblockText[v]
				}
				else{
					val = countryListText[v]
				}

				appendEl.append('<li>'+val+'</li>')
			})
			//appendEl.html(val.join(', '));
		}

		function _setReceiveFrom(modal, elem){
			var product = $.parseJSON(elem.attr('data-product')),
				divs = ['only-my-country', 'all-the-world', 'neighbours'],
				prod = [];

			$.each(divs, function(k, v){
				if(modal.find('div.'+v).length > 0){
					prod.push(v)
				}
			})
			if(modal.find('div.economic-blocks').length > 0){
				var data = modal.find('div.economic-blocks').children('div');

				data.each(function(){
					prod.push($(this).attr('class'))
				})
			}
			if(modal.find('div.countries').length > 0){
				var data = modal.find('div.countries').children('div');

				data.each(function(){
					prod.push($(this).attr('class'))
				})
			}
			product.receiveFrom = prod;
			elem.attr('data-product', JSON.stringify(product));
			_setReceiveFromText(elem)
		}
	}
})(jQuery);

/*[
	{"id_category":"2","id_product":"10","receiveFrom":["mera","nafta","ue"]},
	{"id_category":"2","id_product":"16","receiveFrom":["mer"]},
	{"id_category":"1","id_product":"2","receiveFrom":["only-my-country"]},
	{"id_category":"6","id_product":"21","receiveFrom":["neighbours"]},
	{"id_category":"6","id_product":"18","receiveFrom":["neighbours","CL"]},
	{"id_category":"4","id_product":"13","receiveFrom":["only-my-country"]}
]
*/