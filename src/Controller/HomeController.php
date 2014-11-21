<?php

namespace Controller;

use App\Controller;
use App\Response;
use App\Form;
use Model\User;

class HomeController extends Controller
{
	public function indexAction()
	{
		$user = new User;

		$user->name = "Martinne";
		$user->firstname = "<script> alert('ok'); </script>";


		$userDb = $this->getContext('User');
		$listUser = $userDb->SelectAll();

		$response = $this->createResponse();

		$response->RenderHtml('home', ['list' => $listUser]);
		$response->set('userForm', $user);

		return $response;
	}

	public function createAction(User $ff)
	{

		$user = new User;
		$user->name = "Martinne";
		$user->firstname = "Francky";

		//$listUser = $this->getContext()->save($user);

		$response = new Response('createAction');

		return $response;
	}

	public function newAction()
	{



		$response = new Response('newAction');

		return $response;
	}

	public function testAction($var1, $var2)
	{
		$response = new Response('testAction : ' . $var1 . '<>' . $var2);
		return $response;
	}

}