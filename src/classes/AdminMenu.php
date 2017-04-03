<?php

namespace D3\SSN\Admin;

class AdminMenu
{
	public static function init()
	{
		add_action('admin_menu', array('D3\SSN\Admin\AdminMenu', 'adminMenus'));
	}

	public static function adminMenus()
	{
		$topMenuItem = 'ssn_validator_admin_page';

		add_menu_page(
			'',
			'SSN Validator',
			'manage_options',
			$topMenuItem,
			array('D3\SSN\Admin\AdminSettings', 'renderPage'),
			'dashicons-admin-generic'
		);
		add_submenu_page(
			$topMenuItem,
			'',
			'Import ',
			'manage_options',
			'ssn_validator_admin_page_import',
			array('D3\SSN\Admin\AdminImport', 'renderPage')
		);
	}
}
