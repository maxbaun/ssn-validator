<?php

namespace D3\SSN\Admin;

class AdminImport
{
	public static function renderPage()
	{
		$output = '
			<div class="wrap">
				<h2>SSN Validator Import</h2>
				<p>Page description....</p>
			</div>
		';

		echo force_balance_tags($output);
	}
}
