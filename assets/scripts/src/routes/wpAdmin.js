export default {
	finalize() {
		const dataUploader = jQuery('.wp-uploader').first();
		const mediaForm = jQuery('#ssn_validator_import_form_media').first();
		const contentForm = jQuery('#ssn_validator_import_form_data').first();
		const elemFileId = dataUploader.find('.fild-id');
		uploader(dataUploader);
		parseCsv(elemFileId, mediaForm, contentForm);
		showSubmit('#ssn_validator_import_form_data');
		submitHandler('#ssn_validator_import_form_data');
	}
};

function showSubmit(form) {
	jQuery(document).on('change', `${form} .ssn-validator-input`, () => {
		setTimeout(() => {
			if (isValid(jQuery(form))) {
				jQuery('.show-only-on-valid', jQuery(form)).show();
			} else {
				jQuery('.show-only-on-valid', jQuery(form)).hide();
			}
		}, 300);
	});
}

function submitHandler(form) {
	jQuery(document).on('submit', form, e => {
		e.preventDefault();
		const action = `${SSNVALIDATOR.ajaxUrl}?action=ssn_validator_import_data`;
		const formData = jQuery(form).serialize();
		const uploader = jQuery('.wp-uploader').first();

		const elemFileUrl = uploader.find('.file-url');
		const elemFileId = uploader.find('.fild-id');
		const elemUploadText = uploader.find('.upload-text');

		jQuery.ajax({
			url: action,
			method: 'post',
			dataType: 'json',
			data: formData,
			success: response => {
				if (response && response.status) {
					elemFileUrl.val('');
					elemFileId.val('');
					elemUploadText.val('');
					jQuery('.show-only-on-valid', jQuery(form)).hide();
					jQuery('.ssn-validator-import-content', jQuery(form)).html('');
					alert(response.message); // eslint-disable-line
				} else {
					alert(response.error); // eslint-disable-line no-alert
				}
			}
		});
	});
}

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

function parseCsv(fileId, form, contentForm) {
	fileId.bind('change', () => {
		const elemFileUrl = form.find('.file-url');
		const formData = form.serialize();
		const action = `${SSNVALIDATOR.ajaxUrl}?action=ssn_validator_parse_csv`;
		const elemContent = contentForm.find('.ssn-validator-import-content');

		jQuery.ajax({
			url: action,
			method: 'post',
			dataType: 'json',
			data: formData,
			success: response => {
				if (response && response.status) {
					const html = getForm2Html(response.data);
					elemContent.html(html);
					contentForm.show();
				} else {
					fileId.val(0);
					elemFileUrl.val(0);
					alert(response.error); // eslint-disable-line no-alert
				}
			}
		});
	});
}

function getForm2Html(data) {
	let html = ``;

	let selectState = getSelector('ssn_validator_state_column', data);
	let selectSSN = getSelector('ssn_validator_ssn_column', data);
	let selectFirstIssued = getSelector('ssn_validator_first_issued_column', data);
	let selectLastIssued = getSelector('ssn_validator_last_issued_column', data);
	let selectAge = getSelector('ssn_validator_age_column', data);

	let assignHtml = `
		<p><label>State</label> ${selectState}</p>
		<p><label>SSN</label> ${selectSSN}</p>
		<p><label>First Issued</label> ${selectFirstIssued}</p>
		<p><label>Last Issued</label> ${selectLastIssued}</p>
		<p><label>Age</label> ${selectAge}</p>
	`;

	let row1 = formTableRow('Assign Data Column', assignHtml);

	html += row1;

	let table = `<table class="wp-list-table fixed widefat striped"><thead>`;
	let tr = `<tr>`;
	let th = `<th scope="col" class="manage-column check-column"><label><input type="checkbox" class="check-all"></label></th>`;
	tr += th;

	jQuery.each(data[0], key => {
		let currentHeader = `<th scope="col">${key}</th>`;
		tr += currentHeader;
	});

	tr += `</tr>`;

	table += `${tr}</thead><tbody id="the-list">`;

	let rowId = 0;

	jQuery.each(data, (key, row) => {
		rowId++;

		let currentRow = `
			<tr>
			<th scope="row" class=" check-column"><input type="checkbox" id="cb-select-${rowId}" name="ssn_validator_import_rows[]" class="ssn-validator-input" value="${rowId}" /></th>
		`;

		let columnId = 0;

		jQuery.each(row, (key, value) => {
			columnId++;

			let fieldName = `s_${rowId}_${columnId}`;

			let td = `<td>${value}<input type="hidden" name=${fieldName} class="ssn-validator-input" value="${value}" /></td>`;
			currentRow += td;
		});

		currentRow += `</tr>`;
		table += currentRow;
	});

	table += `</tbody></table>`;

	let row2 = formTableRow('Select Data To Import', table, 'Select all of the rows you\'d like to import.');

	html += row2;

	return html;
}

function formTableRow(label, input, description) {
	let row = `
		<tr>
			<th scope="row"><label>${label}</label></th>
			<td>${input}
	`;

	if (description) {
		row += `
			<p class="description">${description}</p>
		`;
	}

	row += `</td></tr>`;

	return row;
}

function getSelector(id, data) {
	let select = `<select name="${id}" class="ssn-validator-input">`;
	let columnId = 0;
	let option = `<option value="">- Select One -</option>`;
	select += option;

	jQuery.each(data[0], key => {
		columnId++;
		option = `<option value="${columnId}">${columnId} ${key}</option>`;
		select += option;
	});

	select += `</select>`;

	return select;
}

function isValid(form) {
	let valid = true;

	if (form.find('[name="ssn_validator_import_rows[]"]:checked').length === 0) {
		valid = false;
	}

	if (form.find('[name="ssn_validator_state_column"]').val() === '') {
		valid = false;
	}

	if (form.find('[name="ssn_validator_ssn_column"]').val() === '') {
		valid = false;
	}

	if (form.find('[name="ssn_validator_first_issued_column"]').val() === '') {
		valid = false;
	}

	if (form.find('[name="ssn_validator_last_issued_column"]').val() === '') {
		valid = false;
	}

	if (form.find('[name="ssn_validator_age_column"]').val() === '') {
		valid = false;
	}

	return valid;
}
