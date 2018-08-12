/*
	Validacion de Formularios
*/
function _formValidation(form){
	form.validatr({
		location: 'left',
		theme: 'bootstrap',
		template: '<div>{{message}}</div>'
	});
}

function _validateRange(form, min, max){
	form.validatr('addTest', {
		checkLength: function (element) {
			var val = $.trim($(element).val()),
				valid = val.length > min && val.length < max ? true : false;

			if(valid == true){
				$(element).on('blur', function(){
					$(this).closest('div').find('.validatr-message').addClass('d-none')
				})
			}
			else{
				$(element).on('focus', function(){
					$(this).closest('div').find('.validatr-message').removeClass('d-none')
				})
			}

			return {
				valid: valid,
				message: ''
			};
		}
	})
}

function _validatePwd(form){
	form.validatr('addTest', {
		checkPwdLength: function(element){
			var val = $.trim($(element).val()),
				min = parseInt($(element).attr('data-min')),
				max = parseInt($(element).attr('data-max')),
				isValid;
			
			isValid = (val.length >= min && val.length <= max) ? true : false;

			return {
				valid: isValid,
				message: ''
			};
		}
	})
}

function _validateAddres(form){
	form.validatr('addTest', {
		checkAddress: function (element) {
			var val = $.trim($(element).val()),
				placeId = form.find('.place_id').val(),
				valid = true;

			if(placeId == ''){
				valid = false;
				$(element).on('focus', function(){
					$(this).closest('div').find('.validatr-message').removeClass('d-none')
				})
			}
			else{
				$(element).on('blur', function(){
					$(this).closest('div').find('.validatr-message').addClass('d-none')
				})
			}

			return {
				valid: valid,
				message: ''
			};
		}
	})
}