import AjaxManager from '../utils/ajaxManager';

export default {
	finalize() {
		let manager = null;
		const dataUploader = jQuery('.wp-uploader').first();
		const mediaForm = jQuery('#ssn_validator_import_form_media').first();
		const elemFileId = dataUploader.find('.fild-id');
		const submitButton = jQuery('input[type="submit"]', mediaForm);

		elemFileId.change(e => {
			const elem = jQuery(e.target);

			if (manager) {
				manager.stop();
				updateProgress(0);
			}

			if (isValid(elem)) {
				submitButton.show();
			} else {
				submitButton.hide();
			}
		});

		mediaForm.submit(e => {
			manager = new AjaxManager(updateProgress);
			e.preventDefault();
			const elem = jQuery(e.target);
			totalRequest(elem.serialize())
				.then(buildChunks)
				.then(buildRequests(manager));
		});

		uploader(dataUploader);
	}
};

function uploader(uploader) {
	if (!uploader) {
		return;
	}

	const elemUploadBtn = uploader.find('.upload-btn');
	const elemFileUrl = uploader.find('.file-url');
	const elemFileId = uploader.find('.fild-id');
	const elemUploadText = uploader.find('.upload-text');

	elemUploadBtn.click(e => {
		e.preventDefault();
		let file = wp.media({
			title: 'Upload',
			multiple: false
		})
		.open()
		.on('select', () => {
			let uploadedFile = file.state().get('selection').first();
			let fileUrl = uploadedFile.attributes.url;
			let fileId = uploadedFile.id;

			if (elemFileUrl.attr('accept') !== 'undefined') {
				let fileType = elemFileUrl.attr('accept');

				if (fileType && fileType !== uploadedFile.attributes.subtype) {
					elemUploadText.val('');
					alert(`The file must be of type: ${fileType}`); // eslint-disable-line no-alert
				} else {
					elemFileUrl.val(fileUrl).trigger('change');
					elemFileId.val(fileId).trigger('change');
				}
			}
		});
	});
}

function totalRequest(formData) {
	const action = `${SSNVALIDATOR.ajaxUrl}?action=ssn_validator_get_total_csv_rows`;
	return new Promise((resolve, reject) => {
		jQuery.ajax({
			url: action,
			method: 'post',
			dataType: 'json',
			data: formData,
			success: response => {
				return (response.data) ? resolve(response.data) : reject(response.error);
			}
		});
	});
}

function buildChunks(total) {
	let perPage = 1000;

	if (total < perPage) {
		perPage = total;
	}

	let groups = Math.ceil(total / perPage);
	let chunks = [];

	for (let x = 0; x < groups; x++) {
		let chunk = {
			min: (x * perPage),
			max: (x + 1) * perPage
		};

		if (chunk.max > total) {
			chunk.max = total;
		}

		chunks.push(chunk);
	}

	return chunks;
}

function buildRequests(manager) {
	return chunks => {
		if (!chunks.length) {
			return null;
		}

		updateProgress(0);

		chunks.forEach(chunk => {
			manager.addRequest(getUploadOptions(chunk));
		});

		manager.run();
	};
}

function updateProgress(progress) {
	const mediaForm = jQuery('#ssn_validator_import_form_media').first();
	const progressBar = jQuery('.progress-bar', mediaForm);
	const progressLabel = jQuery('.progress-label', mediaForm);
	const percentage = `${Math.floor(progress)}%`;
	const submitButton = jQuery('input[type="submit"]', mediaForm);

	if (progress < 100) {
		submitButton.attr('disabled', 'disabled');
	} else {
		submitButton.removeAttr('disabled');
	}

	progressLabel.text(percentage);
	progressBar.progressbar({
		value: progress,
		change: () => {
			progressLabel.text(percentage);
		}
	});
}

function getUploadOptions(chunk) {
	const action = `${SSNVALIDATOR.ajaxUrl}?action=ssn_validator_parse_csv`;
	const mediaForm = jQuery('#ssn_validator_import_form_media').first();
	const fileid = jQuery('[name="ssn_validator_import_file_id"]', mediaForm);

	return {
		url: action,
		method: 'post',
		dataType: 'json',
		data: {
			fileid: fileid.val(),
			start: chunk.min,
			end: chunk.max
		}
	};
}

function isValid(elem) {
	return Boolean(elem.val());
}
