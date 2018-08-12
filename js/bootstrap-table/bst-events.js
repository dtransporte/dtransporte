window._showRequirement = {
	'click a.show-requirement': function(e, value, row, index){
		$.fn.Requirements({requirement: row}, 'show')
	}
}
window._pendingRequirement = {
	'click a.accept-visit': function(e, value, row, index){
		console.log(row)
		row.is_visit = 1;
		$.fn.Quotation({quotation: row}, 'visit')
	}
}
window._eventsRequirement = {
	'click a.send-requirement': function(e, value, row, index){
		$.fn.Requirements({requirement: row}, 'sendSaved')
	},
	'click a.delete-requirement': function(e, value, row, index){
		$.fn.Requirements({requirement: row}, 'delete')
	},
	'click a.show-related-quotations': function(e, value, row, index){
		$.fn.Requirements({requirement: row}, 'showQuotations')
	},
	'click a.prog-requirement': function(e, value, row, index){
		$.fn.Requirements({requirement: row}, 'program')
	},
	'click a.delete-programation': function(e, value, row, index){
		$.fn.Requirements({requirement: row}, 'deleteProgramation')
	},
	'click a.cancel-requirement': function(e, value, row, index){
		$.fn.Requirements({requirement: row}, 'cancel')
	} ,
	'click a.resume-quotation': function (e, value, row, index) {
		var id_quotation = $(this).attr('data-qid');
		row.id_quotation = id_quotation;
		$.fn.Quotation({ quotation: row }, 'resume')
	} ,
	'click a.rank-user': function (e, value, row, index) {
		$.fn.Ranking({ requirement: row }, 'showModal')
	}
}
window._showProgramationEvents = {
	'mouseover div.show-programation': function(e, value, row, index){
		var div = $(this).find('div.countdown'),
			time = parseInt(div.attr('data-programation'));
		div.removeClass('d-none');
		div.countdown({endTime: time})
	},
	'mouseout div.show-programation': function(e, value, row, index){
		$(this).find('div.countdown').addClass('d-none')
	}
}

window._quotationEvents = {
	'click a.send-quotation': function(e, value, row, index){
		$.fn.Quotation({quotation: row}, 'send')
	},
	'click a.delete-quotation': function(e, value, row, index){
		$.fn.Quotation({quotation: row}, 'delete')
	},
	'click a.cancel-quotation': function(e, value, row, index){
		$.fn.Quotation({quotation: row}, 'cancel')
	},
	'click a.resume-quotation': function (e, value, row, index) {
		$.fn.Quotation({ quotation: row }, 'resume')
	},
	'click a.rank-user': function (e, value, row, index) {
		$.fn.Ranking({ requirement: row }, 'showModal')
	}
}
