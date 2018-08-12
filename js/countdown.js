(function($){	
	$.fn.countdown = function(options){
		var defaults = {
				endTime: null,
				showSeconds: true,
				interval: 1000
			},
			settings = $.extend(defaults, options),
			that = this;
		setInterval(function(){
			var elapse = moment(settings.endTime).diff(moment());
			//console.log(that.attr('class'))
			that
				.css('min-width', '20px')
				.css('min-height', '10px')
				.html(timeElapse())
		}, settings.interval);
		return this;

		function timeElapse(){
			var date = {};
			var interv = settings.endTime - moment();
			if(interv > 0){
				date.days = Math.floor(interv/(1000*60*60*24));
				interv -= date.days*1000*60*60*24;
				date.hours = Math.floor(interv/(1000*60*60));
				interv -= date.hours*1000*60*60;
				date.min = Math.floor(interv/(1000*60));
				interv -= date.min*1000*60;
				date.sec = Math.floor(interv/(1000));
				var days = date.days > 0 ? date.days +' d ' : '';
				var hours = date.hours > 0 ? date.hours +' h ' : '';
				var min = date.min > 0 ? date.min +' m ' : '';
				var sec = '';
				if(settings.showSeconds == true){
					sec = date.sec + ' s';
				}
				return days+ hours + min + sec
			}
			else{
				that.remove()
			}
		}
	}
})(jQuery);