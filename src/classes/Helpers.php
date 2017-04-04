<?php

namespace D3\SSN;

class Helpers
{
	public static function buildSSNString($first, $second)
	{
		return "$first-$second-xxxx";
	}
}
