<?php

namespace D3\SSN\Admin;

class AdminSettings
{
	public static function renderPage()
	{
		$output = '
			<div class="wrap">
				<h2>SSN Validator Settings</h2>
				<p>A tool to validate Social Security Numbers</p>
			</div>
		';

		echo force_balance_tags($output);
	}
}
