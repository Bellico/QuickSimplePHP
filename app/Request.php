<?php

namespace App;

class Request
{
	public static $BASE_URL;

	private $method;
	private $controller;
	private $action;
	private $params = [];

	public static function createFromUrl()
	{
		$data = Request::parseUri();
		$request = new Request;
		$request->method = $_SERVER['REQUEST_METHOD'];
		$request->controller = (isset($data[0])) ? $data[0] : null;
		$request->action = (isset($data[1])) ? $data[1] : null;
		$request->params = array_slice($data, 2);

		return $request;
	}

	public static function createFromRoot($root)
	{
		$request = new Request;
		$request->method = (isset($root['method'])) ? $root['method'] : 'GET';
		$request->controller = $root['action'][0];
		$request->action = $root['action'][1];
		$request->params = (isset($root['params'])) ? $root['params'] : [];

		return $request;
	}

	public static function parseUri()
	{
		$uri = $_SERVER['REQUEST_URI'];
		$query = substr($uri, strpos($uri, WEB_FOLDER) + strlen(WEB_FOLDER));
		self::$BASE_URL = substr($uri, 0, strpos($uri, WEB_FOLDER));
		return explode('/', $query);
	}

	public static function getResponse(Request $req)
	{
		$request = self::match($req);
		$call_controller_name = "Controller\\{$request->controller}Controller";
	//	$call = new $call_controller_name($request);
		$controller = new \ReflectionClass($call_controller_name);
		$action = $controller->getMethod("{$request->action}Action");
		$response = $action->invokeArgs($controller->newInstance($request), $request->params);
		//$response = call_user_func_array([$call, "{$request->action}Action"], $request->params);

		return $response;
	}

	public static function match(Request $request)
	{
		$roots = Routing::RootConfig();

		if($request->controller == null && $request->action == null)
			return self::createFromRoot($roots['default']);

		foreach ($roots as $name => $root) {
			$reqToTest = self::createFromRoot($roots[$name]);
			if($request->isEqual($reqToTest)) return $request;
		}

		throw new \Exception("Root not match");
	}

	public function isEqual(Request $request)
	{
		$equal = $this->method == $request->method;
		$equal += $this->controller == $request->controller;
		$equal += $this->action == $request->action;
		$equal += count($this->params) == count($request->params);

		if($equal == 4)
			return true;
		else
			return false;
	}
}