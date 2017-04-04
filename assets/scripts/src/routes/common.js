export default {
	init() {
		// JavaScript to be fired on all pages
	},
	finalize() {
		const firstInput = jQuery('.ssn-validator-form input[name="ssn_validator_first"]').first();
		const secondInput = jQuery('.ssn-validator-form input[name="ssn_validator_second"]').first();
		const form = jQuery('.ssn-validator-form').first();

		keyUp(firstInput);
		keyUp(secondInput);
		submit(form);
	}
};

function keyUp(input) {
	focusNext(input);
}

function submit(form) {
	let valid = false;
	form.submit(e => {
		if (valid) {
			return true;
		}

		e.preventDefault();

		return validateForm()
			.then(validateSsn)
			.then(() => {
				valid = true;
				form.trigger('submit');
			})
			.catch(err => {
				formError(err);
			});
	});
}

function validateSsn() {
	const first = jQuery('.ssn-validator-form input[name="ssn_validator_first"]').first().val();
	const second = jQuery('.ssn-validator-form input[name="ssn_validator_second"]').first().val();

	const action = `${SSNVALIDATOR.ajaxUrl}`;
	const formData = {
		first,
		second,
		action: 'ssn_validator_validate_ssn'
	};
	return new Promise((resolve, reject) => {
		jQuery.ajax({
			url: action,
			method: 'post',
			dataType: 'json',
			data: formData,
			success: response => {
				return (response.success) ? resolve(response.data) : reject(response.message);
			}
		});
	});
}

function validateForm() {
	const firstInput = jQuery('.ssn-validator-form input[name="ssn_validator_first"]').first();
	const secondInput = jQuery('.ssn-validator-form input[name="ssn_validator_second"]').first();

	resetFormText();
	return new Promise((resolve, reject) => {
		if (containsLetters(firstInput.val()) || firstInput.val().length !== 3) {
			firstInput.focus();
			reject('Please enter a valid Social Security Number');
			return false;
		}

		if (containsLetters(secondInput.val()) || secondInput.val().length !== 2) {
			secondInput.focus();
			reject('Please enter a valid Social Security Number');
			return false;
		}

		if (!getRecaptcha()) {
			reject('Please check the recaptcha');
			return false;
		}

		resolve(true);
	});
}

function getRecaptcha() {
	if (grecaptcha && grecaptcha.getResponse() !== '') {
		return grecaptcha.getResponse();
	}

	return null;
}

function formError(error) {
	const formText = jQuery('#ssn_validator_form_response').first();
	formText.text(error);
	formText.addClass('error');
	formText.addClass('active');
}

function resetFormText() {
	const formText = jQuery('.ssn-validator-form-text').first();
	formText.text('');
	formText.removeClass('error');
	formText.removeClass('active');
}

function containsLetters(value) {
	return value.match(/[a-z]/i);
}

function focusNext(input) {
	input.keyup(e => {
		const target = e.srcElement || e.target;
		const maxLength = parseInt(target.attributes.maxlength.value, 10);
		const currentLength = target.value.length;

		if (currentLength >= maxLength) {
			let next = findNext(target);
			next.focus();
		}
	});
}

function findNext(target) {
	return jQuery(target).nextAll('input').first();
}
