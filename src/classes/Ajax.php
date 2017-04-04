<?php

namespace D3\SSN;

class Ajax
{
	public static function returnJson($array)
	{
		$json = \json_encode($array);
		die($json);
		exit;
	}
}
