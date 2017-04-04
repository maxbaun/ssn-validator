<?php

namespace D3\SSN\Shortcodes;

use D3\SSN\Admin\AdminSettings;

class ShortcodeForm
{
	public static function init()
	{
		add_shortcode('ssn_validator_form', array('D3\SSN\Shortcodes\ShortcodeForm', 'callback'));
	}


	// D3LB Form Shortcode
	public static function callback($args, $content = "")
	{
		$first = (isset($_POST['ssn_validator_first'])) ? $_POST['ssn_validator_first'] : '';
		$second = (isset($_POST['ssn_validator_second'])) ? $_POST['ssn_validator_second'] : '';

		$label = (isset($args['label'])) ? $args['label'] : 'Enter Social Security Number';
		$actionPageId = AdminSettings::getOption('ssn_validator_results_page');
		$formAction = get_page_link($actionPageId);

		$ajax_url = admin_url('admin-ajax.php');

		ob_start();
		include_once(plugin_dir_path(dirname(__FILE__)) . 'templates/form.php');
		$output = ob_get_clean();
		ob_end_clean();

		// output the results
		return force_balance_tags($output);
	}
}
