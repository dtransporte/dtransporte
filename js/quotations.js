(function($){
	'use strict';

	$.fn.Quotation = function(options, method){
		var defaults= {
			quotation: {}
		},
		settings = $.extend(true, defaults, options),
		that = this,
		status = null,
		form = null,

		methods = {
			init: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Quotations/Get',
					type: 'GET',
					showLoadingBar: true
				}).then(
					function(response){
						var r = $.parseJSON(response),
							tableQuotations = that.find('#tbl-assoc-quotations'),
							tablePending = that.find('#tbl-requirements-pending-quot'),
							configQuotationOpts = r.quotations,
							configPendingOpts = r.requirementsPending;

						tablePending
							.bootstrapTable(configPendingOpts)
							.on('all.bs.table', function(name, args){
								var self = $(this),
									rows = self.find('tbody tr');
								self.find('tbody [title]')
									.tooltip({
										html: true,
										trigger: 'hover',
										placement: 'auto'
									});
								self.find('thead')
									.addClass('bg-light text-dark')
									.find('th').addClass('font-weight-bold');
								self.find('tbody td').addClass('text-dark');
							});
						tablePending.bootstrapTable('refresh');

						tableQuotations
							.bootstrapTable(configQuotationOpts)
							.on('all.bs.table', function(name, args){
								var self = $(this),
									rows = self.find('tbody tr');
								self.find('tbody [title]')
									.tooltip({
										html: true,
										trigger: 'hover',
										placement: 'auto'
									});
								self.find('thead')
									.addClass('bg-light text-dark')
									.find('th').addClass('font-weight-bold');
								self.find('tbody td').addClass('text-dark');
								// rows.each(function(){
								// 	var r = $(this);
								// 	//console.log(r)
								// })
							})
							.on('click-row.bs.table', function(e, row, element, field){
								$(element).siblings()
									.removeClass('bg-light')
								$(element)
									.addClass('bg-light')
							});
						tableQuotations.bootstrapTable('refresh');
					}
				)
			},
			add: function(){
				var tbody = that.find('#tbl-concepts tbody'),
					newRow = tbody.find('tr').eq(0);

				form = that.find('#frm-add-quotation');

				that.find('#btn-show-requirement').on('click', function(){
					var req = $.parseJSON(that.find('#data-requirement').val());
					that.Requirements({
						requirement: req
					}, 'show')
				});
				that.find('#btn-add-concept').on('click', function(e){
					e.stopImmediatePropagation();
					newRow
						.clone(true)
						.appendTo(tbody)
						.find('input').val('')
						.closest('tr')
						.find('div.input-group-append')
						.removeClass('d-none')
						.find('a.btn-delete-concept').on('click', function(){
							$(this).closest('tr').remove()
						});
				});
				that.find('.items-check').on('click', function(){
					var self = $(this);
					$(this).toggleClass('text-danger')
				});
				that.find('#btn-show-route').on('click', function(){
					$.fn.request({
						url: BaseUrl+'index.php/Requirements/Address',
						type: 'GET',
						showLoadingBar: true
					}).then(
						function(response){
							var modal;
							DomRootEl.append(response);
							modal = DomRootEl.find('#modal-show-address');
							modal.modal();

							modal.on('shown.bs.modal', function(){
								that.Gmap({}, 'route')
							});
							modal.on('hidden.bs.modal', function(){
								$(this).remove()
							})
						}
					)
				});
				if(form.find('#quotation_etd').length > 0){
					form.DTRDates({}, 'quotations');
				}
				that.find('a.send-quotation').on('click', function(){
					var self = $(this),
						id = self.attr('id');
					status = id === 'btn-send' ? 'active' : 'nosent';
					_send()
				})
			},
			send: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Quotations/Send/confirm',
					type: 'GET',
					data: {id_quotation: settings.quotation.id_quotation},
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						DomRootEl.append(response);
						modal = DomRootEl.find('#modal-quotation-send-confirm');
						modal.modal();

						modal.on('shown.bs.modal', function(){
							var self = $(this);
							self.find('#btn-send').on('click', function(){
								$.fn.request({
									url: BaseUrl+'index.php/Quotations/Send',
									type: 'GET',
									data: {id_quotation: settings.quotation.id_quotation},
									showLoadingBar: true
								}).then(
									function(resp){
										var r = $.parseJSON(resp);
										DomRootEl.Message(r, 'set')
									}
								)
							})
						});
						modal.on('hidden.bs.modal', function(){
							$(this).remove()
						})
					}
				)
			},
			visit: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Quotations/Visit/confirm',
					type: 'GET',
					data: {id_quotation: settings.quotation.id_quotation},
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						DomRootEl.append(response);
						modal = DomRootEl.find('#modal-quotation-visit-confirm');
						modal.modal();

						modal.on('shown.bs.modal', function(){
							var self = $(this),
								form = self.find('form');
							form.find('input[name="id_requirement"]').val(settings.quotation.id_requirement);
							self.find('#btn-send').on('click', function(){
								form.request({
									url: BaseUrl+'index.php/Quotations/Visit',
									showLoadingBar: true
								}).then(
									function(resp){
										var r = $.parseJSON(resp);
										DomRootEl.Message(r, 'set')
									}
								)
							})
						});
						modal.on('hidden.bs.modal', function(){
							$(this).remove()
						})
					}
				)
			},
			delete: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Quotations/Delete/confirm',
					type: 'GET',
					data: {id_quotation: settings.quotation.id_quotation},
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						DomRootEl.append(response);
						modal = DomRootEl.find('#modal-quotation-delete-confirm');
						modal.modal();

						modal.on('shown.bs.modal', function(){
							var self = $(this);
							self.find('#btn-send').on('click', function(){
								$.fn.request({
									url: BaseUrl+'index.php/Quotations/Delete',
									type: 'GET',
									data: {id_quotation: settings.quotation.id_quotation},
									showLoadingBar: true
								}).then(
									function(resp){
										var r = $.parseJSON(resp);
										DomRootEl.Message(r, 'set')
									}
								)
							})
						});
						modal.on('hidden.bs.modal', function(){
							$(this).remove()
						})
					}
				)
			},
			cancel: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Quotations/Cancel/confirm',
					type: 'GET',
					data: {id_quotation: settings.quotation.id_quotation},
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						DomRootEl.append(response);
						modal = DomRootEl.find('#modal-quotation-cancel-confirm');
						modal.modal();

						modal.on('shown.bs.modal', function(){
							var self = $(this);
							self.find('#view-more-about-faults').on('click', function(){
								self.find('#show-about-faults').toggleClass('d-none')
							})
							self.find('#btn-cancel').on('click', function(){
								$.fn.request({
									url: BaseUrl+'index.php/Quotations/Cancel',
									type: 'GET',
									data: {id_quotation: settings.quotation.id_quotation},
									showLoadingBar: true
								}).then(
									function(resp){
										var r = $.parseJSON(resp);
										DomRootEl.Message(r, 'set');
										modal.modal('hide')
									}
								)
							})
						});
						modal.on('hidden.bs.modal', function(){
							$(this).remove()
						})
					}
				)
			},
			resume: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Quotations/Resume',
					type: 'GET',
					data: {id_quotation: settings.quotation.id_quotation},
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						DomRootEl.append(response);
						modal = DomRootEl.find('#modal-quotation-resume');
						modal.modal();

						modal.on('shown.bs.modal', function () {
							var self = $(this);
							self.find('#btn-print').on('click', function () {
								self.find('div.modal-body').print({
									iframe: self.find('div.modal-body')
								})
							});
						});
						modal.on('hidden.bs.modal', function () {
							$(this).remove()
						})
					}
				)
			}
		}

		methods[method].apply(this);
		return this;

		/*-----------------------------------------------------------------------
		|	METODOS PRIVADOS                                                    |
		-----------------------------------------------------------------------*/

		function _send(){
			if(_validate() == false){
				DomRootEl.Message(ErrorMessages, 'set');
				return
			}
			var quotation_code = form.find('#quotation_code').val(),
				sendQuotation = function(){
					form.request({
						url: BaseUrl + 'index.php/Quotations/Insert',
						showLoadingBar: true
					}).then(
						function (response) {
							var r = $.parseJSON(response);
							DomRootEl.Message(r, 'set')
						}
					)
				};
			form.find('#quotation_status').val(status);
			if(status === 'nosent'){
				sendQuotation()
			}
			else{
				$.fn.request({
					url: BaseUrl+'index.php/Quotations/Insert/confirm',
					type: 'GET',
					data: {quotation_code: quotation_code},
					showLoadingBar:true
				}).then(
					function(response){
						var modal;
						DomRootEl.append(response);
						modal = DomRootEl.find('#modal-quotation-send-confirm');
						modal.modal();

						modal.on('shown.bs.modal', function(){
							var self = $(this);
							
							self.find('#btn-send').on('click', function(){
								sendQuotation()
							})
						});
						modal.on('hidden.bs.modal', function(){
							$(this).remove()
						})
					}
				)
			}
		}

		function _validate(){
			var valid = true,
				concept_name = form.find('input.concept_name'),
				concept_value = form.find('input.concept_value');

			concept_name.each(function(){
				var self = $(this),
					val = $.trim(self.val());
				if(val == ''){
					valid = false 
				}
			});
			if(valid == true){
				concept_value.each(function(){
					var self = $(this),
						val = parseInt($.trim(self.val()));
					if(val == '' || isNaN(val)){
						valid = false 
					}
				})
			}
			return valid
		}
	}
})(jQuery);