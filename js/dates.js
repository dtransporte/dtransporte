(function($){
	'use strict';
	$.fn.DTRDates = function(options, method){
		var defaults = {
			date: null
		},
		settings = $.extend(true, defaults, options),
		that = this,
		icons = {},
		dbFormat = 'YYYY-MM-DD HH:mm',
		validDate = null,

		methods = {
			construct: function(){
				icons = {
					time: 'far fa-clock',
					date: 'far fa-calendar',
					up: 'fas fa-arrow-up',
					down: 'fas fa-arrow-down',
					previous: 'fas fa-chevron-left',
					next: 'fas fa-chevron-right',
					today: 'fas fa-calendar-check',
					clear: 'far fa-trash-alt',
					close: 'far fa-times-circle'
				}
			},
			setRequirement: function(){
				var expDate = that.find('#expiration_date'),
					schDate = that.find('#schedule_date'),
					hiddenExp = that.find('#requirement_expiration'),
					hiddenSch = that.find('#requirement_schedule');

				hiddenExp.val(moment().format(dbFormat));
				hiddenSch.val(moment().add(DifExpSch, 'h').format(dbFormat));

				expDate.datetimepicker({
					locale: ActiveLang,
					minDate: moment(),
					sideBySide: true,
					icons: icons,
					calendarWeeks: true,
					allowInputToggle: true,
					format: UserDtf
				}).val('');

				schDate.datetimepicker({
					locale: ActiveLang,
					minDate: moment().add(DifExpSch, 'h'),
					sideBySide: true,
					icons: icons,
					calendarWeeks: true,
					allowInputToggle: true,
					format: UserDtf
				}).val('');

				expDate.on('dp.change', function(e){
					schDate.datetimepicker('minDate', moment(e.date).add(DifExpSch, 'h'));
					hiddenExp.val(moment(e.date).format(dbFormat));
				});
				schDate.on('dp.change', function(e){
					hiddenSch.val(moment(e.date).format(dbFormat));
				})
			},
			setProgramation: function(){
				var form = DomRootEl.find('#frm-add-requirement'),
					progDate = that.find('#programation_date'),
					hiddenDate = form.find('#requirement_programation'),
					expDate = form.find('#expiration_date').datetimepicker('date'),
					maxDate = moment(expDate);
					
				progDate.datetimepicker({
					locale: ActiveLang,
					minDate: moment().add(10, 'ms'),
					maxDate: maxDate,
					sideBySide: true,
					icons: icons,
					calendarWeeks: true,
					allowInputToggle: true,
					format: UserDtf
				});
				progDate.on('dp.change', function(e){
					hiddenDate.val(moment(e.date).format(dbFormat));
				});
			},
			newProgramation: function(){
				var progDate = that.find('#programation_date'),
					expDate = progDate.attr('data-expiration'),
					maxDate = moment.unix(expDate);
				
				progDate.datetimepicker({
					locale: ActiveLang,
					minDate: moment().add(10, 'ms'),
					maxDate: maxDate,
					sideBySide: true,
					icons: icons,
					calendarWeeks: true,
					allowInputToggle: true,
					format: UserDtf
				});
				progDate.on('dp.change', function(e){
					that.find('input[name="requirement_programation"]').val(moment(e.date).format(dbFormat))
				});
			},
			quotations: function(){
				var hiddenEtd = that.find('#quotation_etd'),
					hiddenEta = that.find('#quotation_eta'),
					etdDate = that.find('#quotation-etd'),
					etaDate = that.find('#quotation-eta'),
					minDate = parseInt(etdDate.attr('data-etd'));

				etdDate.datetimepicker({
					locale: ActiveLang,
					minDate: moment.unix(minDate).add(1, 'd'),
					icons: icons,
					calendarWeeks: true,
					allowInputToggle: true,
					format: UserDtf
				});
				etdDate.datetimepicker('date', moment.unix(minDate).add(1, 'd'));

				etaDate.datetimepicker({
					locale: ActiveLang,
					minDate: moment.unix(minDate).add(2, 'd'),
					icons: icons,
					calendarWeeks: true,
					allowInputToggle: true,
					format: UserDtf
				});
				etdDate.on('dp.change', function(e){
					etaDate.datetimepicker('minDate', moment(e.date).add(1, 'd'));
					hiddenEtd.val(moment(e.date).format(dbFormat.replace('HH:mm', '')));
				});
				etaDate.on('dp.change', function(e){
					hiddenEta.val(moment(e.date).format(dbFormat.replace('HH:mm', '')));
				})
			},
			validate: function(){
				var odate = settings.date.split(' '),
					date = odate[0].split('/'),
					time = odate[1],
					parseDate;

				if(UserDtf === 'DD/MM/YYYY HH:mm'){
					parseDate = date[2]+'-'+date[1]+'-'+date[0]
				}
				else{
					parseDate = date[2]+'-'+date[0]+'-'+date[1]
				}
				parseDate += ' '+time
				if(!moment(parseDate).isValid()){
					validDate = false
				}
				else{
					validDate = true
				}
			}
		}

		methods.construct();
		if(method != undefined){
			methods[method].apply(this)
		}
		if(validDate != null){
			return validDate
		}
		return this

		/*-----------------------------------------------------------------------
		|	METODOS PRIVADOS                                                    |
		-----------------------------------------------------------------------*/
		
	}
})(jQuery);