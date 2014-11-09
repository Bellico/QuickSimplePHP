<?php

namespace App;

use App\MyOrm;

class Controller
{
	private $request;
	private $context;

	public function __construct(Request $request)
	{
		$this->request = $request;
		$this->context = new MyOrm;
	}

	public function getContext()
	{
		return $this->context;
	}
}