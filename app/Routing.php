<?php

namespace App;

class Routing
{
	public static function RootConfig()
	{
		$roots["default"] =
		[
			"action" => ["home", "index"]
		];

		$roots["create"] =
		[
			"action" => ["home", "create"],
			"params" => ["str", "ok"]
		];

		return $roots;
	}
}