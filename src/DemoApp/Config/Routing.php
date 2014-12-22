<?php

namespace DemoApp\Config;

class Routing
{
	public static function RootConfig()
	{
		$roots["default"] =
		[
			"action" => ["home", "index"]
		];

		$roots["createForm"] =
		[
			"pattern" => 'create-user',
			"action" => ["home", "createForm"]
		];

		$roots["createPost"] =
		[
			"action" => ["home", "createPost"],
			"method" => "POST"
		];

		$roots["edit"] =
		[
			"action" => ["home", "edit"],
			"params" => ['id'],
		];

		$roots["delete"] =
		[
			"action" => ["home", "delete"],
			"params" => ['id'],
		];

		return $roots;
	}
}