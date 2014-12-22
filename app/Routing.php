<?php

namespace App;

class Routing
{
	static private $i = -1;

	public static function getRootConfig()
	{
		self::$i ++;

		if(!isset(Config::$appEnable[self::$i])) return false;

		$appFolder = Config::$appEnable[self::$i];

		return self::getRootByApp($appFolder);
	}

	public static function getNameApp()
	{
		return Config::$appEnable[self::$i];
	}

	public static function getRootByApp($app = null)
	{
		if($app == null) $app = Config::$appEnable[0];
		$routing_name = "$app\\Config\\Routing";
		$routing = new \ReflectionClass($routing_name);
		$rootConfig = $routing->getMethod("RootConfig");

		return $rootConfig->invoke(null);
	}
}