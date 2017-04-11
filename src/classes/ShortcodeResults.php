<?php

namespace D3\SSN\Shortcodes;

use D3\SSN\SSNData;
use D3\SSN\Admin\AdminSettings;
use D3\SSN\Helpers;

class ShortcodeResults
{
	public static function init()
	{
		add_shortcode('ssn_validator_results', array('D3\SSN\Shortcodes\ShortcodeResults', 'callback'));
	}


	// D3LB Form Shortcode
	public static function callback($args, $content = "")
	{
		if (!isset($_POST['ssn_validator_first']) && !isset($_POST['ssn_validator_second'])) {
			return false;
		}

		$first = (isset($_POST['ssn_validator_first'])) ? $_POST['ssn_validator_first'] : '';
		$second = (isset($_POST['ssn_validator_second'])) ? $_POST['ssn_validator_second'] : '';
		$validMessage = (isset($args['valid_message'])) ? $args['valid_message'] : 'This SSN has been validated';
		$invalidMessage = (isset($args['invalid_message'])) ? $args['invalid_message'] : 'Unable to validate this SSN';

		$ssn = Helpers::buildSSNString($first, $second);
		$data = SSNData::getRowBySSN($ssn);

		if (!count($data)) {
			$data = (object)array(
				'ssn' => $first . '-' . $second . '-' . 'xxxx',
				'state' => 'None Available',
				'issued' => 'None Available',
				'age' => 'None Available',
				'status' => $invalidMessage,
				'statusClass' => 'invalid',
				'valid' => false
			);
		} else {
			$issued = self::getIssuedByRange($data[0]->first_issued, $data[0]->last_issued);
			$age = self::getAgeByRange($data[0]->first_issued, $data[0]->last_issued);

			$data = (object)array(
				'ssn' => $data[0]->ssn,
				'state' => $data[0]->state,
				'issued' => $issued,
				'age' => $age,
				'status' => $validMessage,
				'statusClass' => 'valid',
				'valid' => true
			);
		}

		return self::renderResults($data);
	}

	public static function getIssuedByRange($firstIssued = null, $lastIssued = null)
	{
		if (empty($lastIssued) || $lastIssued === 'unknown') {
			return $firstIssued;
		}

		if (empty($firstIssued) || $firstIssued === 'unknown') {
			return $lastIssued;
		}

		return "$firstIssued - $lastIssued";
	}

	public static function getAgeByRange($firstIssued = null, $lastIssued = null)
	{
		$currentYear = date("Y");

		if ((empty($firstIssued) || $firstIssued === 'unknown') && (empty($lastIssued) || $lastIssued === 'unknown')) {
			return "Not Available";
		}

		if (empty($firstIssued) || $firstIssued === 'unknown') {
			return (int)$currentYear - (int)$lastIssued;
		}

		if (empty($lastIssued) || $lastIssued === 'unknown') {
			return (int)$currentYear - (int)$firstIssued;
		}

		return ((int)$currentYear - (int)$lastIssued) . ' to ' . ((int)$currentYear - (int)$firstIssued) . ' yrs';
	}

	private static function renderResults($data)
	{
		$data->date = new \DateTime('now');

		ob_start();
		include_once(plugin_dir_path(dirname(__FILE__)) . 'templates/results.php');
		$output = ob_get_clean();
		ob_end_clean();

		return force_balance_tags($output);
	}
}
