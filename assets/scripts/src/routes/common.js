export default {
	init() {
		// JavaScript to be fired on all pages
	},
	finalize() {
		const firstInput = jQuery('.ssn-validator-form input[name="ssn_validator_first"]').first();
		const secondInput = jQuery('.ssn-validator-form input[name="ssn_validator_second"]').first();
		const form = jQuery('.ssn-validator-form').first();
		const mapId = 'ssn_validator_result_map';
		const state = jQuery('#ssn_validator_map_address').val();

		initMap(mapId, state);
		keyUp(firstInput);
		keyUp(secondInput);
		submit(form);
	}
};

function initMap(mapId, state) {
	if (!jQuery(`#${mapId}`).length || !state) {
		return;
	}

	const address = {
		address: state
	};

	return getLongLat(address)
		.then(renderMap(mapId))
		.then(setMapResizeListener);
}

function getLongLat(address) {
	const geocoder = new google.maps.Geocoder();

	return new Promise((resolve, reject) => {
		geocoder.geocode(address, (results, status) => {
			if (status !== 'OK') {
				reject(status);
			}
			resolve({
				center: {
					lat: results[0].geometry.location.lat(),
					lng: results[0].geometry.location.lng()
				},
				zoom: 5
			});
		});
	});
}

function renderMap(mapId) {
	return mapData => {
		return new google.maps.Map(document.getElementById(mapId), mapData);
	};
}

function setMapResizeListener(map) {
	google.maps.event.addDomListener(window, 'resize', () => {
		var center = map.getCenter();
		google.maps.event.trigger(map, 'resize');
		map.setCenter(center);
	});
}

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
			.then(() => {
				valid = true;
				form.trigger('submit');
			})
			.catch(err => {
				formError(err);
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
