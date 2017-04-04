<?php

namespace D3\SSN;

use D3\SSN\Admin\AdminSettings;

class Helpers
{
	public static function buildSSNString($first, $second)
	{
		return "$first-$second-xxxx";
	}

	public static function isResultsPage()
	{
		$resultsPage = (int)AdminSettings::getOption('ssn_validator_results_page');
		return get_the_id() === $resultsPage;
	}
}
