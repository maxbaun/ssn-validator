<?php

namespace D3\SSN\Admin;

class AdminImport
{
	public static function renderPage()
	{
		ob_start();
		include_once(plugin_dir_path(dirname(__FILE__)) . 'templates/admin-import.php');
		$output = ob_get_clean();
		echo $output;
	}
}
