<?php

namespace App;

class HtmlHelper
{
	public static function link($nameRoot, $params = [], $nameApp = null)
	{
		$roots = Routing::getRootByApp($nameApp);

		if(!isset($roots[$nameRoot])) return $nameRoot;

		$root = $roots[$nameRoot];

		if(isset($root['pattern'])){
			$nbParams = (isset($root['params'])) ? count($root['params']) : 0;
			if($nbParams > 0){
				$tabPattern =  array_fill(0, $nbParams, '#{[a-z0-9]+}#');
				$relative = preg_replace($tabPattern, $params, $root['pattern'], 1);
			}else $relative = $root['pattern'];
		}
		else{
			$relative = (isset($root['pattern'])) ? $root['pattern'] : $root['action'][0] . '/' . $root['action'][1];
			$relative .= '/'. implode('/', $params);
		}

		return 'http://' . $_SERVER['SERVER_NAME'] . Request::$BASE_URL . WEB_FOLDER . $relative;
	}

	public static function script($name)
	{
		return 'http://' . $_SERVER['SERVER_NAME'] . Request::$BASE_URL . WEB_FOLDER . Routing::getNameApp() . '/js/' . $name;
	}

	public static function createForm($entity)
	{
		return Form::createForm($entity);
	}

	public static function input($name, $value = null, $type = 'text')
	{
		$value = htmlspecialchars($value);
		return '<input type="' . $type . '" name="' . $name . '" value="' . $value . '" />';
	}
}