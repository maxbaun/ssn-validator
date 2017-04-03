<?php

namespace D3\SSN\Admin;

class AdminExport
{
	public static function renderPage()
	{
		$exportPath = plugin_dir_path(dirname(__FILE__)) . 'exports/';

		ob_start();
		include_once(plugin_dir_path(dirname(__FILE__)) . 'templates/admin-export.php');
		$output = ob_get_clean();
		echo $output;
	}
}
