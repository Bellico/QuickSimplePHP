<?php

namespace App;

class HtmlHelper
{
	public static function link($nameRoot, $params = null)
	{
		$roots = Routing::RootConfig();
		$root = $roots[$nameRoot];

		return 'http://' . $_SERVER['SERVER_NAME'] . Request::$BASE_URL . WEB_FOLDER . $root['action'][0] . '/' . $root['action'][1];
	}
}