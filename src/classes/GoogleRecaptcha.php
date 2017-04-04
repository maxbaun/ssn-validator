<?php

namespace D3\SSN;

use D3\SSN\Admin\AdminSettings;

class Recaptcha
{
	public static function render($classes = '')
	{
		$siteKey = AdminSettings::getOption('ssn_validator_google_recaptcha');

		if (empty($siteKey)) {
			return '';
		}

		return "<div class='g-recaptcha $classes' data-sitekey='{$siteKey}'></div>";
	}
}
