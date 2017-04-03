<?php

namespace D3\SSN\Shortcodes;

class ShortcodeResults
{
	public static function init()
	{
		add_shortcode('ssn_validator_results', array('D3\SSN\Shortcodes\ShortcodeResults', 'callback'));
	}


	// D3LB Form Shortcode
	public static function callback($args, $content = "")
	{
		$list_id = 0;
		$ajax_url = admin_url('admin-ajax.php');

		if (isset($args['id'])) {
			$list_id = (int)$args['id'];
		}

		// setup our output variable
		$output = '
			<div class="ssn-validator-results">
				<h1>ssn validator results</h1>
				<ul class="sn-validator-results-list">
					<li><strong>Date of Report: </strong>Date</li>
					<li><strong>State of Issuance: </strong> MA</li>
					<li><strong>Approximate Date of Issuance: </strong>2004-2005</li>
				</ul>
			</div>
		';

		// output the results
		return force_balance_tags($output);
	}
}
