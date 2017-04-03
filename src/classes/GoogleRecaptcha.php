<?php

namespace D3\SSN;

class Recaptcha
{
	public static function render()
	{
		$siteKey = '6LecahsUAAAAAE81LKhe9FVn0JFRGWdqdVpPhTMj';

		return "<div class='g-recaptcha' data-sitekey={$siteKey}></div>";
	}
}
