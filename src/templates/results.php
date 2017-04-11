<div class="ssn-validator-wrapper">
	<div class="ssn-validator-result-block">
		<h5 class="ssn-validator-banner">Results</h5>
		<input
			type="hidden"
			id="ssn_validator_map_address"
			name="ssn_validator_map_address"
			value="<?php echo $data->state; ?>"
			>
		<div class="ssn-validator-results">
			<table class="table-responsive">
				<tbody>
					<tr>
						<th>Social Security Number</th>
						<td><?php echo $data->ssn; ?> </td>
					</tr>
					<tr>
						<th>Date of Report</th>
						<td><?php echo $data->date->format('F j, Y'); ?></td>
					</tr>
					<tr>
						<th>State of Issuance</th>
						<td><?php echo $data->state; ?></td>
					</tr>
					<tr>
						<th>Approximate Date of Issuance</th>
						<td><?php echo "$data->issued"; ?></td>
					</tr>
					<tr>
						<th>Estimated Age</th>
						<td><?php echo $data->age; ?></td>
					</tr>
					<tr>
						<th>Status</th>
						<td class="ssn-validator-status ssn-validator-status-<?php echo $data->statusClass; ?>"><?php echo $data->status; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="ssn-validator-result-block">
		<h5 class="ssn-validator-banner">Map</h5>
		<div class="ssn-validator-map">
			<?php if (!$data->valid) : ?>
				<span class="ssn-validator-map-error">Sorry, no map is available</span>
			<?php else : ?>
				<div id="ssn_validator_result_map"></div>
			<?php endif; ?>
		</div>
	</div>


</div>
