<?php

namespace App;

use App\HtmlHelper;

class Response
{
	private $view;
	private $content;
	private $varsView;

	public function __construct($varsView = [])
	{
		if(is_array($varsView))
			$this->varsView = $varsView;
		else
			$this->content = $varsView;
	}

	public function send()
	{
		if($this->view != null){
			extract($this->varsView);
			require VIEW_DIR . $this->view . '.php';
		}
		else echo $this->content;
	}

	public function Render($view)
	{
		$this->view = $view;
	}
}