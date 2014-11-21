<?php

namespace App;

class Form
{
	const NAME_FORM_TYPE = 'formType';

	public static function Create($post)
	{
		if(isset($post[self::NAME_FORM_TYPE])){

			$form = new \ReflectionClass($post[self::NAME_FORM_TYPE]);

			$user = $form->newInstance();
			$user->name = "Martinne";
			$user->firstname = "Francky";

			return $user;
		}


	}
}