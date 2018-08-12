(function($){
	'use strict';

	$.fn.HazardProducts = function(method){
		var that = this,
			//container = this.find('#cargo-details-warehousing'),
			showHazardProducts = that.find('#hazard-products'),
			showFrozenChain = that.find('#cargo_frozen_chain'),
			containerHazardProducts = that.find('#hazard-prods'),
			accordion = that.find('#accordion-hazard-products'),
			draggable = accordion.find('div.card-body div.media'),

		methods = {
			init: function(){
				var set = function(){
					draggable.Products({
						dropContainer: that.find('#dropped-products'),
						containment: accordion.closest('div.row')
					}, 'hazard')
				};
				
				if(showFrozenChain.length > 0){
					showFrozenChain.on('click', function(){
						var self = $(this);
						if(self.is(':checked')){
							self.val(1);
						}
						else{
							self.val(0);
						}
					})
				}
				if(showHazardProducts.length > 0){
					showHazardProducts.on('click', function(){
						var self = $(this);

						if(self.is(':checked')){
							containerHazardProducts.removeClass('d-none');
							self.val(1);
							set();
							accordion.on('shown.bs.collapse', function () {
								set()
							})
						}
						else{
							self.val(0);
							containerHazardProducts.addClass('d-none');
							containerHazardProducts.find('#dropped-products').empty()
						}
					})
				}
				else{
					set();
					accordion.on('shown.bs.collapse', function () {
						set()
					})
				}
			},
			set: function(){
				var elements = that.find('#dropped-products div.container-dragged'),
					hidden = that.find('#cargo_hazard_detail'),
					data = [];

				hidden.val('');
				if(elements.length > 0){
					elements.each(function(){
						var self = $(this),
							id = self.attr('data-product-id'),
							product = self.attr('data-product');
						data.push({id: id, product: product})
					})
					hidden.val(JSON.stringify(data));
				}
			}
		};

		methods[method].apply(this);
		return this;
	}
})(jQuery)