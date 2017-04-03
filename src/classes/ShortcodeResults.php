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
		$first = $_POST['ssn_validator_first'];
		$second = $_POST['ssn_validator_second'];

		ob_start();
		include_once(plugin_dir_path(dirname(__FILE__)) . 'templates/results.php');
		$output = ob_get_clean();
		ob_end_clean();

		return force_balance_tags($output);
	}
}
