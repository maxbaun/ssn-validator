<div class="ssn-validator-wrapper">
	<div class="ssn-validator-result-block">
		<h5 class="ssn-validator-banner">Results</h5>
		<div class="ssn-validator-results">
			<table class="table-responsive">
				<tbody>
					<tr>
						<th>Date of Report</th>
						<td><?php echo $data->date->format('F j, Y'); ?></td>
					</tr>
					<tr>
						<th>Sate of Issuance</th>
						<td><?php echo $data->state; ?></td>
					</tr>
					<tr>
						<th>Approximate Date of Issuance</th>
						<td><?php echo "$data->first_issued - $data->last_issued"; ?></td>
					</tr>
					<tr>
						<th>Estimated Age</th>
						<td><?php echo $data->age; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="ssn-validator-result-block">
		<h5 class="ssn-validator-banner">Map</h5>
		<div class="ssn-validator-map">
			<div id="ssn_validator_result_map"></div>
		</div>
	</div>


</div>
