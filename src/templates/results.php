<div class="ssn-validator-results">
	<h1>ssn validator results</h1>
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
