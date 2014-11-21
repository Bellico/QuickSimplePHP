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
			"pattern" => 'creation-user',
			"action" => ["home", "create"],
			"params" => [],
			"method" => "POST"
		];

		$roots["new"] =
		[
			"pattern" => 'creation-new',
			"action" => ["home", "new"],

		];

		$roots["test"] =
		[
			"pattern" => 'patternTest{var1}/{var2}',
			"action" => ["home", "test"],
			"params" => ['var1', 'var2'],
		];

		return $roots;
	}
}