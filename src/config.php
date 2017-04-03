<?php

namespace D3\SSN;

class Config
{
	protected static $manifest;

	public static function setManifest($m)
	{
		self::$manifest = $m;
	}

	public static function assetPath($file)
	{
		return self::$manifest->getUri($file);
	}

	public static function assetExists($file)
	{
		return self::$manifest->exists($file);
	}
}
