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
			$data = (object)array(
				'ssn' => $data[0]->ssn,
				'state' => $data[0]->state,
				'issued' => $data[0]->first_issued . '-' . $data[0]->last_issued,
				'age' => $data[0]->age,
				'status' => $validMessage,
				'statusClass' => 'valid',
				'valid' => true
			);
		}

		return self::renderResults($data);
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
