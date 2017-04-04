<?php

namespace D3\SSN\Shortcodes;

use D3\SSN\SSNData;
use D3\SSN\Admin\AdminSettings;

class ShortcodeResults
{
	public static function init()
	{
		add_shortcode('ssn_validator_results', array('D3\SSN\Shortcodes\ShortcodeResults', 'callback'));
	}


	// D3LB Form Shortcode
	public static function callback($args, $content = "")
	{
		$first = (isset($_POST['ssn_validator_first'])) ? $_POST['ssn_validator_first'] : '';
		$second = (isset($_POST['ssn_validator_second'])) ? $_POST['ssn_validator_second'] : '';

		$ssn = self::buildSSN($first, $second);
		$data = SSNData::getRowBySSN($ssn);

		if (!count($data)) {
			return self::renderError();
		}

		return self::renderResults($data[0]);
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

	private static function renderError()
	{
		$searchPage = AdminSettings::getOption('ssn_validator_search_page');
		$searchPageLink = get_page_link($searchPage);
		ob_start();
		include_once(plugin_dir_path(dirname(__FILE__)) . 'templates/results-error.php');
		$output = ob_get_clean();
		ob_end_clean();

		return force_balance_tags($output);
	}

	private static function buildSSN($first, $second)
	{
		return "$first-$second-xxxx";
	}
}
