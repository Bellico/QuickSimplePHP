<?php

namespace App;

use App\HtmlHelper;

class Response
{
	private $view;
	private $content;
	private $varsView = [];
	private $type;
	private $layout;

	public function __construct($content = null)
	{
		$this->content = $content;
	}

	public function send()
	{
		if($this->view != null){
			extract($this->varsView);
			$dir = APP_DIR . 'src' . DIRECTORY_SEPARATOR . Routing::getNameApp() . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR;
			$_pageContent = $dir . $this->view . '.php';
			require $dir . $this->layout;
		}
		else if($this->type == 'json') $this->sendJson();
		else echo $this->content;
	}

	public function set($name, $var)
	{
		$this->varsView[$name] = $var;
	}

	public function setLayout($layout)
	{
		$this->layout = $layout;
	}

	public function RenderHtml($view, $varsView = [])
	{
		$this->view = $view;
		$this->varsView += $varsView;
	}

	public function RenderJson($data)
	{
		$this->content = $data;
		$this->type = 'json';
	}

	public function Redirect($link)
	{
		$link = HtmlHelper::link($link);
		header("Location:$link");
	}

	public function NotFound()
	{
		header("HTTP/1.0 404 Not Found");
		$this->view = 'error';
	}

	private function sendJson()
	{
		header('Content-type: application/json');
		echo json_encode($this->content);
	}
}