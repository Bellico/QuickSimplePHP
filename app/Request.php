<?php

namespace App;

class Request
{
	public static $BASE_URL;

	public $method;
	public $pattern;
	public $controller;
	public $action;
	public $params = [];
	public $post;
	public $formType;

	public static function createFromUrl()
	{
		$data = Request::parseUri();
		$request = new Request;
		$request->method = $_SERVER['REQUEST_METHOD'];
		$request->pattern = self::getUri();
		$request->controller = (isset($data[0])) ? $data[0] : null;
		$request->action = (isset($data[1])) ? $data[1] : null;
		$request->params = (!empty($data[2])) ? array_slice($data, 2) : [];
		$request->post = $_POST;
		$request->formType = Form::createModelFromPost($request->post);

		return $request;
	}

	public static function createFromRoot($root)
	{
		$request = new Request;
		$request->method = (isset($root['method'])) ? $root['method'] : 'GET';
		$request->pattern = (isset($root['pattern'])) ? $root['pattern'] : null;
		$request->controller = $root['action'][0];
		$request->action = $root['action'][1];
		$request->params = (isset($root['params'])) ? $root['params'] : [];

		return $request;
	}

	public static function parseUri()
	{
		$uri = $_SERVER['REQUEST_URI'];
		$uriString = self::getUri();
		self::$BASE_URL = substr($uri, 0, strpos($uri, WEB_FOLDER));

		return explode('/', $uriString);
	}

	public static function getUri()
	{
		$uri = $_SERVER['REQUEST_URI'];
		$uriString = substr($uri, strpos($uri, WEB_FOLDER) + strlen(WEB_FOLDER));
		$uriString = ( strpos($uriString, '?') !== false ) ? substr($uriString, 0, strpos($uriString, '?')) : $uriString;

		return $uriString;
	}

	public static function getResponse(Request $req)
	{
		$request = self::match($req);
		$controller_name = "Controller\\{$request->controller}Controller";
		$controller = new \ReflectionClass($controller_name);
		$action = $controller->getMethod("{$request->action}Action");
		$response = $action->invokeArgs($controller->newInstance($request), $request->params + [$request->formType]);

		return $response;
	}

	public static function match(Request $request)
	{
		$roots = Routing::RootConfig();

		if($request->controller == null && $request->action == null)
			return self::createFromRoot($roots['default']);

		foreach($roots as $name => $root) {
			$reqToTest = self::createFromRoot($roots[$name]);

			if($request->isEqual($reqToTest)) {
				$request->controller = $reqToTest->controller;
				$request->action = $reqToTest->action;

				return $request;
			}
		}

		throw new \Exception("Root not match");
	}

	public function isEqual(Request $request)
	{
		$equal = $this->method == $request->method;

		if($this->hasPattern($request->pattern, $request->params)){
			$equal += 2;
			$equal += count($this->params) == count($request->params);
		}
		else if($request->pattern == null){
			$equal += $this->controller == $request->controller;
			$equal += $this->action == $request->action;

			if(count($this->params) == count($request->params)){
				$equal +=1;
				$this->params = array_combine($request->params, $this->params);
			}
		}

		if($equal === 4) return true;
		else return false;
	}

	public function hasPattern($patternTarget, $paramsTarget)
	{
		if($patternTarget == null) return false;

		$patternSource = (substr($this->pattern, -1) == '/') ? substr($this->pattern, 0, -1) : $this->pattern;
		$patternTarget = (substr($patternTarget, -1) == '/') ? substr($patternTarget, 0, -1) : $patternTarget;

		if($patternSource == $patternTarget) return true;

		if(count($paramsTarget) > 0){
			preg_match_all("#{([a-z0-9]+)}#", $patternTarget, $matches);
			$paramsToset = $matches[1];

			if($paramsToset != $paramsTarget) return false;

			$regex = preg_replace('#{[a-z0-9]+}#', '(.+)', $patternTarget);
			preg_match("#$regex#", $patternSource, $matches);

			if(count($matches) > 0){
				$data = array_slice($matches, 1);
				$this->params = array_combine($paramsToset, $data);

				return true;

			}
			else return false;

		}else return false;
	}
}