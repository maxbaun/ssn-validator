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
		formError('Please enter a valid Social Security Number');
		return false;
	}

	if (containsLetters(secondInput.val()) || secondInput.val().length !== 2) {
		secondInput.focus();
		formError('Please enter a valid Social Security Number');
		return false;
	}

	return true;
}

function formError(error) {
	const formText = jQuery('.ssn-validator-form-text').first();
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
