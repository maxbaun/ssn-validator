<?php

namespace D3\SSN\Shortcodes;

class ShortcodeForm
{
	public static function init()
	{
		add_shortcode('ssn_validator_form', array('D3\SSN\Shortcodes\ShortcodeForm', 'callback'));
	}


	// D3LB Form Shortcode
	public static function callback($args, $content = "")
	{
		$label = (isset($args['label'])) ? $args['label'] : 'Enter Social Security Number';

		$ajax_url = admin_url('admin-ajax.php');

		ob_start();
		include_once(plugin_dir_path(dirname(__FILE__)) . 'templates/form.php');
		$output = ob_get_clean();
		ob_end_clean();

		// output the results
		return force_balance_tags($output);
	}
}
