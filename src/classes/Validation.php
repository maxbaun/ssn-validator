<?php

namespace D3\SSN;

use D3\SSN\Ajax;
use D3\SSN\SSNData;
use D3\SSN\Helpers;

class Validation
{
	private static $errorMessage = 'Please enter a valid social security number.';
	public static function init()
	{
		add_action('wp_ajax_ssn_validator_validate_ssn', array('D3\\SSN\\Validation', 'validateSSN'));
		add_action('wp_ajax_nopriv_ssn_validator_validate_ssn', array('D3\\SSN\\Validation', 'validateSSN'));
	}

	public static function validateSSN()
	{
		$first = (isset($_POST['first'])) ? $_POST['first'] : null;
		$second = (isset($_POST['second'])) ? $_POST['second'] : null;

		if (!$first || !$second) {
			Ajax::error(self::$errorMessage);
		}

		$ssn = Helpers::buildSSNString($first, $second);

		$data = SSNData::getRowBySSN($ssn);

		if (!count($data)) {
			Ajax::error(self::$errorMessage);
		}

		Ajax::success('', $data[0]);
	}
}
