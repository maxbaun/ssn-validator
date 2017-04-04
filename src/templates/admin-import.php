<div class="wrap">
	<h2>Import SSN Data</h2>
	<?php
		wp_enqueue_media();
	?>
	<form id="ssn_validator_import_form_media">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="ssn_validator_import_csv">Import CSV</label></th>
					<td>
						<div class="wp-uploader">
							<input type="text" name="ssn_validator_import_file_url" class="file-url regular-text" accept="csv"/>
							<input type="hidden" name="ssn_validator_import_file_id" class="fild-id" value="0"/>
							<input type="button" name="upload-btn" class="upload-btn button-secondary" value="Upload">
						</div>

						<p class="description">Select a file to upload. <br/>CSV Format: <strong>STATE,SSN,FIRSTISSUED,LASTISSUED,ESTAGE</strong></p>
					</td>
				</tr>
			</tbody>
		</table>
	</form>

	<form id="ssn_validator_import_form_data" method="post" action="<?php echo $actionUrl; ?>">
		<table class="form-table">
			<tbody class="ssn-validator-import-content">

			</tbody>
		</table>
		<p class="submit show-only-on-valid" style="display:none"><input type="submit" name="submit" id="submit" class="button button-primary" value="Import"></p>
	</form>		
</div>
