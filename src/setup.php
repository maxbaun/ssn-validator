<?php

namespace D3\SSN;

use D3\SSN\Assets\JsonManifest;

add_action('init', function () {
	$paths = [
		'dir.plugin' => plugin_dir_path(dirname(__FILE__)),
		'uri.plugin' => plugins_url(null, dirname(__FILE__))
	];

	$manifest = new JsonManifest("{$paths['dir.plugin']}dist/assets.json", "{$paths['uri.plugin']}/dist");
	Config::setManifest($manifest);
});

add_action('wp_enqueue_scripts', function () {
	if (Config::assetExists('styles/main.css')) {
		wp_enqueue_style('sage/main.css', Config::assetPath('styles/main.css'), false, null);
	}

	wp_enqueue_script('sage/main.js', Config::assetPath('scripts/main.js'), ['jquery'], null, true);
}, 100);
