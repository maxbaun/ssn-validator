<?php

/*
Plugin Name: SSN Validator
Plugin URI: http://d3applications.com
Description: A plugin for validating SSNs
Version: 1.0
Author: Max Baun
Author URI: http://github.com/maxbaun
License: GPL2
*/

require_once plugin_dir_path(__FILE__) . 'src/setup.php';
require_once plugin_dir_path(__FILE__) . 'src/config.php';
require_once plugin_dir_path(__FILE__) . 'src/assets/JsonManifest.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/ShortcodeForm.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/ShortcodeResults.php';
require_once plugin_dir_path(__FILE__) . 'src/classes/GoogleRecaptcha.php';
