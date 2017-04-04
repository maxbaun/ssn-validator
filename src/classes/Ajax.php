<?php

namespace D3\SSN;

class Ajax
{
	public static function success($message = 'success', $data = array())
	{
		self::returnJson(array(
			'success' => true,
			'message' => $message,
			'data' => $data
		));
	}

	public static function error($error)
	{
		self::returnJson(array(
			'success' => false,
			'message' => $error
		));
	}

	private static function returnJson($array)
	{
		$json = \json_encode($array);
		die($json);
		exit;
	}
}
