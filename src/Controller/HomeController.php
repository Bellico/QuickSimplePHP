<?php

namespace Controller;

use App\Controller;
use App\Response;
use Model\User;

class HomeController extends Controller
{
	public function indexAction()
	{
		$user = new User;
		$user->id = 1;
		$user->name = "Martinne";
		$user->firstname = "Francky";

		//$this->getContext()->save($user);

		$response = new Response(['name' => 'franck']);
		$response->Render('home');

		return $response;
	}

	public function createAction($ok, $s)
	{
		var_dump( $ok);
		var_dump($s);
		return new Response('salut');
	}

}