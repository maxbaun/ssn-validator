<?php

namespace D3\SSN;

use D3\SSN\Config;
use D3\SSN\Helpers;
use D3\SSN\Admin\AdminSettings;

class Assets
{
	public static function init()
	{
		add_action('wp_enqueue_scripts', array('D3\SSN\Assets', 'registerAssets'), 100);
		add_action('admin_enqueue_scripts', array('D3\SSN\Assets', 'registerAdminAssets'), 100);
	}

	public static function registerAssets()
	{
		if (Config::assetExists('styles/main.css')) {
			wp_enqueue_style('sage/main.css', Config::assetPath('styles/main.css'), false, null);
		}

		if (Helpers::isResultsPage()) {
			$googleMapsApiKey = AdminSettings::getOption('ssn_validator_google_maps_api_key');
			$googleMaps = "https://maps.googleapis.com/maps/api/js?key=$googleMapsApiKey";
			wp_enqueue_script('google/maps', $googleMaps, array(), null, true);
		}

		self::registerMainScript();
		wp_enqueue_script('google/recaptcha', 'https://www.google.com/recaptcha/api.js', array(), null, true);
	}

	public static function registerAdminAssets()
	{
		wp_enqueue_script('jquery-effects-core');
		self::registerMainScript();
	}

	private static function registerMainScript()
	{
		wp_register_script('sage/main.js', Config::assetPath('scripts/main.js'), ['jquery'], null, true);
		$translation_array = array(
			'ajaxUrl' => admin_url('admin-ajax.php')
		);
		wp_localize_script('sage/main.js', 'SSNVALIDATOR', $translation_array);
		wp_enqueue_script('sage/main.js');
	}
}
