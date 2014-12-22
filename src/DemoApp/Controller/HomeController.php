<?php

namespace DemoApp\Controller;

use App\Controller;
use App\Response;
use App\Form;
use DemoApp\Model\User;

class HomeController extends Controller
{
	public function indexAction()
	{
		$userDb = $this->getContext('User');
		$listUser = $userDb->SelectAll();
		$response = $this->createResponse();
		$response->RenderHtml('home', ['list' => $listUser]);

		return $response;
	}

	public function createFormAction()
	{
		$response = $this->createResponse();
		$response->RenderHtml('formUser');
		$response->set('userForm', new User);

		return $response;
	}

	public function createPostAction(User $user)
	{
		$this->getContext()->save($user);
		$response = new Response;
		$response->Redirect('default');

		return $response;
	}

	public function editAction($id)
	{
		//$user = $this->getContext('User')->find($id);

		$response = $this->createResponse();
		$response->RenderHtml('formUser');
		$response->set('userForm', new User);

		return $response;
	}

	public function deleteAction($id)
	{
		$this->getContext('User')->delete($id);
		$response = new Response;
		$response->Redirect('default');

		return $response;
	}

}