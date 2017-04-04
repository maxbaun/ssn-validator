<?php

namespace D3\SSN\Admin;

class AdminSettings
{
	private static $adminSettings;

	public static function init()
	{
		self::$adminSettings = array(
			array(
				'id' => 'ssn_validator_search_page',
				'default' => get_option('page_on_front')
			),
			array(
				'id' => 'ssn_validator_results_page',
				'default' => get_option('page_on_front')
			),
			array(
				'id' => 'ssn_validator_google_recaptcha',
				'default' => ''
			),
			array(
				'id' => 'ssn_validator_google_maps_api_key',
				'default' => ''
			)
		);

		add_action('admin_init', array('D3\SSN\Admin\AdminSettings', 'registerOptions'));
	}

	public static function registerOptions()
	{
		foreach (self::$adminSettings as $setting) {
			register_setting('ssn_validator_options', $setting['id']);
		}
	}

	public static function renderPage()
	{
		ob_start();
		$options = self::getCurrentOptions();
		include_once(plugin_dir_path(dirname(__FILE__)) . 'templates/admin-settings.php');
		$output = ob_get_clean();
		echo $output;
	}

	public static function pageSelect($inputName = '', $inputId = '', $parent = -1, $valueField = "id", $selectedValue = "")
	{
		// get WP pages
		$pages = get_pages(
			array(
				'sort_order' => 'asc',
				'sort_column' => 'post_title',
				'post_type' => 'page',
				'parent' => $parent,
				'status' => array('draft','publish'),
			)
		);

		// setup our select html
		$select = '<select name="'. $inputName .'" ';

		// IF $input_id was passed in
		if (strlen($inputId)) {
			$select .= 'id="'. $inputId .'" ';
		}

		// setup our first select option
		$select .= '><option value="">- Select One -</option>';

		// loop over all the pages
		foreach ($pages as &$page) {
			// get the page id as our default option value
			$value = $page->ID;

			// determine which page attribute is the desired value field
			switch ($valueField) {
				case 'slug':
					$value = $page->post_name;
					break;
				case 'url':
					$value = get_page_link($page->ID);
					break;
				default:
					$value = $page->ID;
			}

			// check if this option is the currently selected option
			$selected = '';
			if ($selectedValue == $value) {
				$selected = ' selected="selected" ';
			}

			// build our option html
			$option = '<option value="' . $value . '" '. $selected .'>';
			$option .= $page->post_title;
			$option .= '</option>';

			// append our option to the select html
			$select .= $option;
		}

		// close our select html tag
		$select .= '</select>';

		// return our new select
		return $select;
	}

	public static function getCurrentOptions()
	{
		$currentOptions = array();

		try {
			foreach (self::$adminSettings as $setting) {
				$currentOptions[$setting['id']] = self::getOption($setting['id']);
			}
		} catch (Exception $e) {

		}

		return $currentOptions;
	}

	public static function getOption($option)
	{
		$optionValue = '';

		try {
			$optionValue = (get_option($option)) ? get_option($option) : self::getDefaultOption($option);
		} catch (Exception $e) {

		}

		return $optionValue;
	}

	public static function getDefaultOption($option)
	{
		$defaultOption = '';

		try {
			foreach (self::$adminSettings as $setting) {
				if ($setting['id'] === 'option') {
					$defaultOption = $setting['default'];
				}
			}
		} catch (Exception $e) {

		}

		return $defaultOption;
	}
}
