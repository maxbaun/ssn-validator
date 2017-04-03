<?php

namespace D3\SSN;

use D3\SSN\Config;

class Assets
{
	public static function init()
	{
		add_action('wp_enqueue_scripts', array('D3\SSN\Assets', 'registerAssets'), 100);
	}

	public static function registerAssets()
	{
		if (Config::assetExists('styles/main.css')) {
			wp_enqueue_style('sage/main.css', Config::assetPath('styles/main.css'), false, null);
		}

		wp_enqueue_script('sage/main.js', Config::assetPath('scripts/main.js'), ['jquery'], null, true);
		wp_enqueue_script('google/recaptcha', 'https://www.google.com/recaptcha/api.js', null, true);
	}
}
