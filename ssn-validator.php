<?php

/*
Plugin Name: SSN Validator
Plugin URI: http://d3applications.com
Description: A plugin for validating SSNs
Version: 1.1.2
Author: Max Baun
Author URI: http://github.com/maxbaun
License: GPL2
*/

require_once plugin_dir_path(__FILE__) . 'src/config.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Ajax.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/JsonManifest.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/ShortcodeForm.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/ShortcodeResults.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/GoogleRecaptcha.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Assets.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Activation.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/AdminMenu.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/AdminSettings.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/AdminImport.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/AdminExport.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/SSNData.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Export.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Import.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Parser.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Validation.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/Helpers.php';

use D3\SSN;
use D3\SSN\Config;
use D3\SSN\Assets;
use D3\SSN\Export;
use D3\SSN\Import;
use D3\SSN\Activation;
use D3\SSN\JsonManifest;
use D3\SSN\SSNData;
use D3\SSN\Validation;
use D3\SSN\Shortcodes\ShortcodeForm;
use D3\SSN\Shortcodes\ShortcodeResults;
use D3\SSN\Admin\AdminMenu;
use D3\SSN\Admin\AdminSettings;

add_action('init', function () {
	$paths = [
		'dir.plugin' => plugin_dir_path(__FILE__),
		'uri.plugin' => plugins_url(null, __FILE__)
	];

	$manifest = new JsonManifest("{$paths['dir.plugin']}dist/assets.json", "{$paths['uri.plugin']}/dist");
	Config::setManifest($manifest);

	Assets::init();
	Export::init();
	Import::init();
	ShortcodeForm::init();
	ShortcodeResults::init();
	AdminMenu::init();
	AdminSettings::init();
	Validation::init();
});

register_activation_hook(__FILE__, function () {
	Activation::init();
});
