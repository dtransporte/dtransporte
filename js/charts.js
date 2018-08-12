(function($){
	'use strict';
	$.fn.Charts = function(options, method){
		var defaults = {
			type: 'bar',
			data: {},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				},
				//events: ['click']
			}
		},
		settings = $.extend(true, defaults, options),
		that = this.empty(),
		chart = null,
		colors = [
			'rgba(92, 102, 255, 0.8)',
			'rgba(0, 255, 64, 0.8)',
			'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)'
		],
		chartOptions = {},
		select = that.closest('div.card').find('select'),

		methods = {
			construct: function(){
				chartOptions = {
					data: settings.data.data,
					options: settings.options,
					type: settings.type
				};
				
				settings.data.data.datasets[0].backgroundColor = colors;
				if(settings.type === 'pie' || settings.type === 'doughnut'){
					chartOptions.options = null
				}
			},
			set: function(){
				var plug = function(){
					select.on('change', function(e){
						e.stopImmediatePropagation();
						var val = $(this).val(),
							options = {
								type: val,
								data: settings.data
							};
						chart.destroy();
						that.Charts(options, 'set')
					})
				};
				chartOptions.plugins = {afterDraw: plug};
				chart = new Chart(that, chartOptions);
				chart.update();
			}
		}

		methods.construct();
		if(method != undefined){
			methods[method].apply(this)
		}
		return this;
	}
})(jQuery);

/* 
{
	"data":{
		"labels":["Carga Pesada","Mudanzas","Marítimo Internacional"],
		"datasets":[{
			"data":[1,1,1],
			"label":"Servicios mas requeridos por los usuarios"}]
		}
	}

	var data = {
  labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
  datasets: [{
    label: "Dataset #1",
    backgroundColor: "rgba(255,99,132,0.2)",
    borderColor: "rgba(255,99,132,1)",
    borderWidth: 2,
    hoverBackgroundColor: "rgba(255,99,132,0.4)",
    hoverBorderColor: "rgba(255,99,132,1)",
    data: [65, 59, 20, 81, 56, 55, 40],
  }]
};
*/