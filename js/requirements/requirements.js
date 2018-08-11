(function($){
	'use strict';

	$.fn.Requirements = function(options, method){
		var defaults= {
			requirement: {}
		},
		settings = $.extend(true, defaults, options),
		that = this,
		form,
		addressTypes = [],
		opertationType = false,
		containerType = false,
		mirrorAddres = false,
		cargoSpecial = false,
		cargoWarehousing = false,
		cargoMovingDetails = false,
		cargoHazard = false,
		status = null,

		methods = {
			construct: function(){
				form = that.find('#frm-add-requirement');
				if(form.length > 0){
					if(form.find('#operations').length > 0){
						opertationType = true
					}
					if(form.find('#containers-type').length > 0){
						containerType = true
					}
					if(form.find('#cargo-specials').length > 0){
						cargoSpecial = true
					}
					if(form.find('#cargo-details-warehousing').length > 0){
						cargoWarehousing = true
					}
					if(form.find('#cargo-moving-details').length > 0){
						cargoMovingDetails = true
					}
					if(form.find('#cargo-details-hazard').length > 0){
						cargoHazard = true
					}
					if(form.find('#mirror-address').val() == 1){
						mirrorAddres = true
					}
				}
			},
			add: function(){
				that.find('#requirement-dates').DTRDates({}, 'setRequirement');

				_setAddress();
				if(mirrorAddres == true){
					_setMirrorAddress()
				}
				if(opertationType == true){
					_setOperationType()
				}
				if(containerType == true){
					_setcontainerType()
				}
				if(cargoSpecial == true){
					_setCargoSpecial()
				}
				if(cargoWarehousing == true){
					_setCargoWarehousing()
				}
				if(cargoMovingDetails == true){
					_setCargoMovingDetails()
				}
				if(cargoHazard == true){
					_setCargoHazard()
				}
				if(ProductType != ''){
					form.prepend('<input type="hidden" name="cargo_product_type" value="'+ProductType+'">');
				}
				_uploadImages()
			},
			send: function(){
				DomRootEl.find('a.btn-send-req').on('click', function(){
					var id = $(this).attr('id');
					status = id === 'btn-send-requirement' ? 'active' : 'nosent';
					_send()
				})
			},
			sendSaved: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Requirements/Send/confirm',
					type: 'GET',
					data: {id_requirement: settings.requirement.id_requirement},
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						DomRootEl.append(response);
						modal = DomRootEl.find('#modal-requirement-send-confirm'),
						modal.modal();

						modal.on('shown.bs.modal', function(){
							var self = $(this);
							self.find('#btn-send').on('click', function(){
								$.fn.request({
									url: BaseUrl+'index.php/Requirements/Send',
									type: 'GET',
									data: {id_requirement: settings.requirement.id_requirement},
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
			delete: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Requirements/Delete/confirm',
					type: 'GET',
					data: {id_requirement: settings.requirement.id_requirement},
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						DomRootEl.append(response);
						modal = DomRootEl.find('#modal-requirement-delete-confirm'),
						modal.modal();

						modal.on('shown.bs.modal', function(){
							var self = $(this);
							self.find('#btn-delete').on('click', function(){
								$.fn.request({
									url: BaseUrl+'index.php/Requirements/Delete',
									type: 'GET',
									data: {id_requirement: settings.requirement.id_requirement},
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
			cancel: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Requirements/Cancel/confirm',
					type: 'GET',
					data: {id_requirement: settings.requirement.id_requirement},
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						DomRootEl.append(response);
						modal = DomRootEl.find('#modal-requirement-cancel-confirm'),
						modal.modal();

						modal.on('shown.bs.modal', function(){
							var self = $(this);
							self.find('#view-more-about-faults').on('click', function(){
								self.find('#show-about-faults').toggleClass('d-none')
							})
							self.find('#btn-cancel').on('click', function(){
								$.fn.request({
									url: BaseUrl+'index.php/Requirements/Cancel',
									type: 'GET',
									data: {id_requirement: settings.requirement.id_requirement},
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
			program: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Requirements/Program/confirm',
					type: 'GET',
					data: {id_requirement: settings.requirement.id_requirement},
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						DomRootEl.append(response);
						modal = DomRootEl.find('#modal-requirement-prog-confirm'),
						modal.modal({backdrop: 'static'});

						modal.on('shown.bs.modal', function(){
							var self = $(this),
								frm = self.find('form');
							self.DTRDates({}, 'newProgramation');
							self.find('#btn-prog').on('click', function(){
								frm.request({
									url: BaseUrl+'index.php/Requirements/Program',
									showLoadingBar: true
								}).then(
									function(resp){
										var r = $.parseJSON(resp);
										modal.modal('hide');
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
			deleteProgramation: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Requirements/Program/delete',
					type: 'GET',
					data: {id_requirement: settings.requirement.id_requirement},
					showLoadingBar: true
				}).then(
					function(){
						location.href = CurUrl
					}
				)
			},
			show: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Requirements/Resume/get',
					type: 'GET',
					data: {id_requirement: settings.requirement.id_requirement},
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						DomRootEl.append(response);
						modal = DomRootEl.find('#modal-requirement-resume'),
						modal.modal();

						modal.on('shown.bs.modal', function () {
							var self = $(this);
							self.find('#btn-print').on('click', function () {
								self.find('div.modal-body').print({
									iframe: self.find('div.modal-body')
								})
							});
						});
						modal.on('hidden.bs.modal', function(){
							$(this).remove()
						})
					}
				)
			},
			showQuotations: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Requirements/Quotations',
					type: 'GET',
					data: {id_requirement: settings.requirement.id_requirement},
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						DomRootEl.append(response);
						modal = DomRootEl.find('#modal-user-quotation-show'),
						modal.modal();

						modal.on('shown.bs.modal', function(){
							var self = $(this),
								tbl = self.find('table'),
								tblConfig = {};
							$.fn.request({
								url: BaseUrl+'index.php/Requirements/Quotations/get',
								type: 'GET',
								data: {id_requirement: settings.requirement.id_requirement},
								showLoadingBar: true
							}).then(
								function(resp){
									tblConfig = $.parseJSON(resp);
									tbl.bootstrapTable(tblConfig)
									.on('expand-row.bs.table', function(e, index, row, detail){
										var container = $(detail).empty(),
											hidden = self.find('#hidden-data').children().clone(true),
											hidden = container.append(hidden),
											txt = hidden.find('h5');
										
										txt.html(
											txt.html()
											.replace("quotation-code", row.quotation_code)
											.replace("company-name", row.company_name)
										);
										hidden.find('#btn-close-requirement').on('click', function(e){
											e.stopImmediatePropagation();
											self.Requirements({
												requirement: row
											}, 'close');
											modal.modal('hide')
										})
									});
								}
							)
							if(self.find('#operation-details').length > 0){
								self.find('#operation-details').on('click', function(){
									$(this).closest('div.card').find('div.card-body').toggleClass('d-none')
								})
							}
							self.find('#btn-print').on('click', function(){
								var bst = $(this).closest('div.bootstrap-table');

								self.find('div.modal-body').print({
									iframe: self.find('div.modal-body')
								})
							});
						});
						modal.on('hidden.bs.modal', function(){
							$(this).remove()
						})
					}
				)
			},
			close: function(){
				$.fn.request({
					url: BaseUrl+'index.php/Requirements/Close',
					type: 'GET',
					data:{id_requirement: settings.requirement.id_requirement, id_quotation: settings.requirement.id_quotation},
					showLoadingBar: true
				}).then(
					function(response){
						var r = $.parseJSON(response);
						DomRootEl.Message(r, 'set')
					}
				)
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
		function _setAddressTypes(){
			var originAddress = form.find('#origin-address'),
				destinationAddress = form.find('#destination-address'),
				presentationAddress = form.find('#presentation-address');

			if(originAddress.length == 1)
			{
				addressTypes.push({container: 'origin-address', prefix: 'o-'});
			}
			if(destinationAddress.length == 1)
			{
				addressTypes.push({container: 'destination-address', prefix: 'd-'});
			}
			if(presentationAddress.length == 1)
			{
				addressTypes.push({container: 'presentation-address', prefix: ''});
			}
		}

		function _setAddress(){
			var btnWaypoint = form.find('#btn-add-waypoint');

			_setAddressTypes();
			$.each(addressTypes, function(k, v){
				var self = that.find('#'+v.container);
				self.find('button.btn-locateme').on('click', function(e){
					e.preventDefault();
					self.Geolocation({prefix: v.prefix});
				});
				self.find('button.btn-restore-address').on('click', function(e){
					e.preventDefault();
					self.RestoreAddress({prefix: v.prefix});
				});
				self.find('input.autocomplete').on('focus', function(){
					self.find('input[fill-location=""]').not('.autocomplete').val('');
					self.AutoComplete({prefix: v.prefix});
				});
				self.AutoComplete({prefix: v.prefix});

				self.find('.btn-show-address').on('click', function(e){
					e.preventDefault();
					_showAddress(self, v.prefix, false);
				});
				self.find('.btn-show-route').on('click', function(e){
					e.preventDefault();
					_showAddress(self, v.prefix, true);
				});
				self.find('.btn-use-address').on('click', function(e){
					e.preventDefault();
					_useAddress(self)
				})
			});
			
			if(btnWaypoint.length != undefined){
				btnWaypoint.on('click', function(e){
					e.preventDefault();
					form.find('#waypoints-address').WayPoints();
				});
				form.find('#btn-delete-all-waypoints').on('click', function(e){
					e.preventDefault();
					form.find('#waypoints-address #drag-message').addClass('d-none');
					form.find('#waypoints-address #wp-cloned').empty();
				});
			}
		}

		function _setMirrorAddress(){
			var selCountry = form.find('select.country');

			selCountry.on('change', function(){
				var val = $(this).val();
				selCountry.val(val);
				form.find('#d-country').html($(this).find('option:selected').text());
				form.find('input[name="d-country"]').val(val)
			});
		}

		function _showAddress(container, prefix, isRoute){
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
						var self = $(this),
							method = '';
						if(isRoute == true){
							self.find('#data-panel').removeClass('d-none');
							method = 'route';
						}
						container.Gmap({prefix: prefix}, method);
					});
					modal.on('hidden.bs.modal', function(){
						$(this).remove();
					})
				}
			)
		}

		function _useAddress(container){
			var addressType = container.attr('id') === 'destination-address' ? 'destination' : 'origin';
			$.fn.request({
				url: BaseUrl+'index.php/Requirements/Address/useAddress',
				type: 'GET',
				showLoadingBar: true
			}).then(
				function(response){
					var modal;
					DomRootEl.append(response);
					modal = DomRootEl.find('#modal-use-address');
					modal.modal();

					modal.on('shown.bs.modal', function(){
						var self = $(this);
						$.fn.request({
							url: BaseUrl+'index.php/Requirements/Address/loadAddress',
							data: {address_type: addressType},
							type: 'GET'
						}).then(
							function(r){
								var grid;
								FGData.data = $.parseJSON(r);
								grid = new FancyGrid(FGData);
								
								self.find('a[href="http://www.fancygrid.com"]').remove();
								self.find('#tbl-use-address').addClass('w-100')
							}
						)
					});
					modal.on('hidden.bs.modal', function(){
						$(this).remove();
					})
				}
			)
		}

		function _setOperationType(){
			var operations = form.find('#operations'),
				incotermDescription = operations.find('#optype-description'),
				selIncoterm = operations.find('#operation_incoterm'),
				selInspection = operations.find('#inspection_required'),
				customClearance = operations.find('#custom_clearance');

			incotermDescription.html(selIncoterm.find('option:selected').attr('data-incoterm'));

			operations.find('input[type="checkbox"]').prop('checked', false);

			selIncoterm.on('change', function(){
				var incoterm = $(this).find('option:selected').attr('data-incoterm');
				incotermDescription.html(incoterm)
			});
			selInspection.on('change', function(){
				var val = $(this).val(),
					inspRequired = operations.find('#inspection-required');
				if(val != 'no'){
					inspRequired.removeClass('d-none')
				}
				else{
					inspRequired.addClass('d-none')
				}
			});
			customClearance.on('click', function(){
				var checked = $(this).is(':checked'),
					container = operations.find('#container-hs-codes');
				if(checked == true){
					$(this).val(1);
					container.removeClass('d-none');
					container.find('#btn-add-hs-row').on('click', function(e){
						e.stopImmediatePropagation();
						operations.HsCodes({}, 'add')
					});
				}
				else{
					$(this).val(0);
					container.find('#operation_value').val(0);
					container.addClass('d-none').find('table tbody tr').not('.hidden-row').remove();
				}
			});
			operations.find('#require_insurance, #require_co').on('click', function(){
				var self = $(this);
				if(self.is(':checked')){
					self.val(1)
				}
				else{
					self.val(0)
				}
			})
		}

		function _setcontainerType(){
			var container = form.find('#containers-type'),
				containerData = container.find('#container-data div.media'),
				selContainer = container.find('#cargo_containers'),
				insertContainer = function(value){
					var data = $.parseJSON(selContainer.find('option[value="'+value+'"]').attr('data-container'));
					containerData.find('img').attr('src', BaseUrl+'imgs/containers/'+data.image);
					containerData.find('div.media-body h5').empty().append('<u>'+data.title+'</u>');
					containerData.find('div.media-body div.media-data').empty().append(data.description)
				};
			insertContainer('drv20');

			selContainer.on('change', function(){
				insertContainer($(this).val())
			})
		}

		function _setCargoSpecial(){
			form.CargoSpecials('init')
		}

		function _setCargoWarehousing(){
			form.find('#cargo-details-warehousing').HazardProducts('init')
		}

		function _setCargoMovingDetails(){
			var container = form.find('#cargo-moving-details'),
				accordion = container.find('#accordion-moving-inventory'),
				draggable = accordion.find('div.container-dragged'),
				droppable = container.find('#dropped-items'),
				tbody = droppable.find('table tbody'),
				exists = function(el){
					var exist = false;
					if(el.attr('id') != 'inv-others'){
						tbody.find('tr').each(function(){
							if($(this).attr('id') === el.attr('id')){
								exist = true
							}
						})
					}
					return exist
				},
				setInventory = function(){
					draggable.draggable({
						containment: accordion.closest('div.row'),
						cursor: 'crosshair',
						revert: true,
						revertDuration: 500,
						distance: 50,
						addClasses: false,
						
						stop: function(e, ui){
							var self = ui.helper,
								idElement = self.attr('id'),
								dataItem = $.parseJSON(self.attr('data-item')),
								hiddenRow = tbody.find('tr.hidden-row-moving');

							if(!exists(self)){
								var item,
									activeRow = hiddenRow.clone(true);
								activeRow
									.removeClass('d-none')
									.removeClass('hidden-row-moving')
									.prependTo(tbody)
									.attr('id', self.attr('id'))
									.attr('data-item', self.attr('data-item'))
									.closest('tr').find('a.btn-delete-item')
									.on('click', function(){
										$(this).closest('tr').remove()
									});
								if(activeRow.attr('id') === 'inv-others'){
									item = '<input type="text" class="form-control" maxlength="20" placeholder="Max 20 car">'
								}
								else{
									item = dataItem.name
								}
								activeRow.find('td').eq(0).append(item)
							}
							else{
								tbody.find('#'+self.attr('id')+' td').eq(1).find('input').focus()
							}
						}
					})
				};

			setInventory();
			accordion.on('shown.bs.collapse', function () {
				setInventory();
			})
		}

		function _setCargoHazard(){
			form.find('#cargo-details-hazard').HazardProducts('init')
		}

		function _send(){
			if(_validate()){
				form.find('#requirement_status').val(status);
				form.request({
					url: BaseUrl+'index.php/Requirements/Resume/set',
					type: 'GET',
					showLoadingBar: true
				}).then(
					function(response){
						var modal;
						DomRootEl.append(response);
						modal = DomRootEl.find('#modal-requirement-resume');

						modal.modal({backdrop: 'static'});

						modal.on('shown.bs.modal', function(){
							var self = $(this);
							self.find('#btn-print').on('click', function () {
								self.find('div.modal-body').print({
									iframe: self.find('div.modal-body')
								})
							});
							self.find('.btn-send').on('click', function(e){
								e.preventDefault();
								form.request({
									url: BaseUrl+'index.php/Requirements/Insert',
									showLoadingBar: true
								}).then(
									function(response){
										var r = $.parseJSON(response);
										DomRootEl.Message(r.msg, 'set');
										if(r.msg.cls === 'danger'){
											form.find('input[name="csrf_test_name"]').val(r.csrf)
										}
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

		function _validate(){
			var validExpDate = that.DTRDates({
					date: form.find('#expiration_date').val()
				}, 'validate'),
				validSchDate = that.DTRDates({
					date: form.find('#schedule_date').val()
				}, 'validate'),
				placeId,
				validAddress = true;

			// Valida fechas
			if(!validExpDate || !validSchDate){
				DomRootEl.Message(ErrorMessages['no-date'], 'set');
				DomRootEl.find('#reqTab-dates').tab('show')
				return false
			}

			// Valida direcciones
			_setAddressTypes();
			$.each(addressTypes, function(k, v){
				placeId = form.find('#'+v.container+ ' input[name="'+v.prefix+'place_id"]').val();
				if(placeId == ''){
					validAddress = false
				}
			});
			if(validAddress == false){
				DomRootEl.Message(ErrorMessages['no-address'], 'set');
				DomRootEl.find('#reqTab-address').tab('show');
				return false
			}

			// Valida inventario mudanzas si esta definido
			if(cargoMovingDetails == true){
				var container = form.find('#cargo-moving-details'),
					rows =  container.find('table tbody tr').not('.hidden-row-moving'),
					dataItem = [];
				if(rows.length == 0){
					DomRootEl.Message(ErrorMessages['no-moving-selected'], 'set');
					DomRootEl.find('#reqTab-cargo').tab('show');
					return false
				}
				else{
					rows.each(function(){
						var self = $(this),
							item = $.parseJSON(self.attr('data-item')),
							name = self.find('td').eq(0).find('input').val();

						item.name = name == undefined ? self.find('td').eq(0).html() : name;
						item.quantity = self.find('td').eq(1).find('input').val();
						item.notes = self.find('td').eq(2).find('input').val();
						dataItem.push(item)
					});
					container.find('#cargo_moving_detail').val(JSON.stringify(dataItem))
				}
			}

			if(cargoSpecial == true){
				form.CargoSpecials('set')
			}

			if(opertationType == true){
				var container = form.find('#operations'),
					rows = container.find('table tbody tr').not('.hidden-row');

				if(rows.length > 0){
					container.HsCodes({}, 'sum');
					var grandTotal = that.find('#operation_value').val();
					if($.trim(grandTotal) == '' || grandTotal == 0 || isNaN(grandTotal)){
						DomRootEl.Message(ErrorMessages['no-number'], 'set');
						DomRootEl.find('#reqTab-operation-type').tab('show').find('#operation_value').focus();
						return false
					}
					else{
						container.HsCodes({}, 'set');
					}
				}
			}

			if(cargoWarehousing == true){
				var container = form.find('#cargo-details-warehousing'),
					showHazardProducts = container.find('#hazard-products'),
					containerHazardProducts = container.find('#hazard-prods');

				if(showHazardProducts.is(':checked')){
					var elements = container.find('#dropped-products div.container-dragged');

					if(elements.length == 0){
						DomRootEl.Message(ErrorMessages['no-hazard-product-selected'], 'set');
						DomRootEl.find('#reqTab-cargo').tab('show');
						return false
					}
					container.HazardProducts('set')
				}
			}

			if(cargoHazard == true && cargoWarehousing == false){
				var container = form.find('#cargo-details-hazard'),
					elements = container.find('#dropped-products div.container-dragged');
				if(elements.length == 0){
					DomRootEl.Message(ErrorMessages['no-hazard-product-selected'], 'set');
					DomRootEl.find('#reqTab-cargo').tab('show');
					return false
				}
				container.HazardProducts('set')
			}
			
			return true
		}

		function _uploadImages(){
			var container = form.find('#requirement-images'),
				uploader = container.find('#uploader'),
				imgCfg = $.parseJSON(uploader.attr('data-img-config'));

			container.Upload(imgCfg, 'start')
		}
	}
})(jQuery);