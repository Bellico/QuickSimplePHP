<?php

namespace App;

use App\Orm;

class Controller
{
	private $request;
	private $context;

	public function __construct(Request $request)
	{
		$this->request = $request;
		$this->context = new Orm;
	}

	public function getContext($context = null)
	{
		if($context) $this->context->setEntityContext($context);
		return $this->context;
	}

	public function getRequest()
	{
		return $this->request;
	}

	public function createResponse()
	{
		$response = new Response;
		$response->setLayout('layout.php');
		$response->set('_pageTitle', $this->request->action);

		return $response;
	}
}