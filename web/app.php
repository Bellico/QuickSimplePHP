<?php

use App\Request;

define('APP_DIR', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('WEB_FOLDER', 'web/');

spl_autoload_register('App::autoload');

class App
{
	static public function autoload($class)
	{
		$file = APP_DIR . $class . '.php';
		if(file_exists($file))
			require_once $file;
		else
			require_once APP_DIR . 'src' . DIRECTORY_SEPARATOR . $class . '.php';
	}

    static public function main()
    {
        $request = Request::createFromUrl();
		$response = Request::getResponse($request);
		$response->send();
    }
}

App::main();
