<?php

use D3\SSN\Admin\AdminSettings;

?>

<div class="wrap">
	<h2>SSN Validator Settings</h2>
	<p>A tool to validate Social Security Numbers</p>
	<form action="options.php" method="post">
		<?php
			settings_fields('ssn_validator_options');
		?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="ssn_validator_search_page">Search Page</label></th>
					<td>
						<?php
							echo AdminSettings::pageSelect('ssn_validator_search_page', 'ssn_validator_search_page', -1, 'id', $options['ssn_validator_search_page']);
						?>
						<p class="description">Select the page where the search form will appear</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="ssn_validator_results_page">Results Page</label></th>
					<td>
						<?php
							echo AdminSettings::pageSelect('ssn_validator_results_page', 'ssn_validator_results_page', -1, 'id', $options['ssn_validator_results_page']);
						?>
						<p class="description">Select the page where the search results will be displayed</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="ssn_validator_google_recaptcha">Google Recaptcha Site Key</label></th>
					<td>
						<input
							type="text"
							class="widefat"
							name="ssn_validator_google_recaptcha"
							id="ssn_validator_google_recaptcha"
							value="<?php echo $options['ssn_validator_google_recaptcha']; ?>"
							/>
						<p class="description">Your <a href="https://www.google.com/recaptcha/admin">Google Recaptcha</a> site key.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="ssn_validator_google_maps_api_key">Google Maps API Key</label></th>
					<td>
						<input
							type="text"
							class="widefat"
							name="ssn_validator_google_maps_api_key"
							id="ssn_validator_google_maps_api_key"
							value="<?php echo $options['ssn_validator_google_maps_api_key']; ?>"
							/>
						<p class="description">Your <a href="https://developers.google.com/maps/documentation/javascript/">Google Maps</a> API Key.</p>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" name="submit" class="button button-primary" value="Save Changes">
		</p>
	</form>
</div>
