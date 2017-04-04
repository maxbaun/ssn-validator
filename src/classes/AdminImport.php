<?php

namespace D3\SSN\Admin;

class AdminImport
{
	public static function renderPage()
	{
		ob_start();
		
		$actionUrl = admin_url('admin-ajax.php');
		$actionUrl .= "?action=ssn_validator_import_data";

		include_once(plugin_dir_path(dirname(__FILE__)) . 'templates/admin-import.php');
		$output = ob_get_clean();
		echo $output;
	}
}
