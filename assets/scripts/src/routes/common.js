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
	validateInput(input);
	focusNext(input);
}

function submit(form) {
	form.submit(e => {
		if (!validateForm()) {
			e.preventDefault();
		}
	});
}

function validateForm() {
	const firstInput = jQuery('.ssn-validator-form input[name="ssn_validator_first"]').first();
	const secondInput = jQuery('.ssn-validator-form input[name="ssn_validator_second"]').first();

	resetFormText();

	if (containsLetters(firstInput.val()) || firstInput.val().length !== 3) {
		firstInput.focus();
		formError(firstInput, 'Please enter a valid Social Security Number');
		return false;
	}

	if (containsLetters(secondInput.val()) || secondInput.val().length !== 2) {
		secondInput.focus();
		formError(secondInput, 'Please enter a valid Social Security Number');
		return false;
	}

	if (!getRecaptcha()) {
		formError('Please check the recaptcha');
		return false;
	}

	return true;
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

// function inputError(input, error) {
// 	const target = input.nextAll('.ssn-validator-form-text').first();
//
// 	if (!target) {
// 		return;
// 	}
//
// 	target.text(error);
// 	target.addClass('error');
// 	target.addClass('active');
// }

function resetFormText() {
	const formText = jQuery('.ssn-validator-form-text').first();
	formText.text('');
	formText.removeClass('error');
	formText.removeClass('active');
}

function validateInput(input) {
	input.keyup(e => {
		const target = e.srcElement || e.target;
		const val = target.value;

		if (containsLetters(val)) {
			// let newVal = val.replace(/\D/g, '');
			// jQuery(target).val(newVal);
		}
	});
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
