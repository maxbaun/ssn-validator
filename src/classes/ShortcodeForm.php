<?php

namespace D3\SSN\Shortcodes;

use D3\SSN\Recaptcha;

class ShortcodeForm
{
	public static function init()
	{
		add_shortcode('ssn_validator_form', array('D3\SSN\Shortcodes\ShortcodeForm', 'callback'));
	}


	// D3LB Form Shortcode
	public static function callback($args, $content = "")
	{
		$ajax_url = admin_url('admin-ajax.php');

		// setup our output variable
		$output = '
			<div class="ssn-validator">
				<form id="ssn_validator_form" name="ssn_validator_form" class="ssn-validator-form" method="post"
					action="/5-2/">
					<div class="ssn-validator-form-inner">
						<label>Enter Social Security Number</label>
						<div class="ssn-validator-input-container inline-container inputs-container">
							<input
								type="text"
								name="ssn_validator_first"
								class="ssn-validator-input ssn-validator-input-first" maxlength="3"
								/>
							<span class="ssn-validator-input-separator">-</span>
							<input
								type="text"
								name="ssn_validator_second"
								class="ssn-validator-input ssn-validator-input-second"
								maxlength="2"
								/>
							<small id="ssn_validator_form_response" class="ssn-validator-form-text"></small>
						</div>
						<div class="ssn-validator-input-container inline-container submit-container">
							<input
								class="ssn-validator-input"
								type="submit"
								name="ssn_validator_submit"
								value="Search"
								/>
						</div>
						'.Recaptcha::render().'
					</div>
				</form>
			</div>
		';

		// output the results
		return force_balance_tags($output);
	}
}
