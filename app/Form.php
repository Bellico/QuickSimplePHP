<?php

namespace App;

class Form
{
	const NAME_FORM_TYPE = 'formType';

	public static function createModelFromPost($post)
	{
		if(isset($post[self::NAME_FORM_TYPE])){

			$form = new \ReflectionClass($post[self::NAME_FORM_TYPE]);
			$model = $form->newInstance();

			foreach ($model as $propertie => $value) {
				if(isset($post[$propertie])){
					$prop = new \ReflectionProperty(get_class($model), $propertie);
					$prop->setValue($model, $post[$propertie]);
				}
			}

			return $model;
		}
	}

	public static function createForm($entity)
	{
		$form = self::input('formType', get_class($entity), 'hidden');
		foreach ($entity as $propertie => $value) {
			if($propertie != 'id'){
				$form .= self::label($propertie);
				$form .= self::input($propertie, $value);
			}
		}
		return $form;
	}


	public static function input($name, $value = null, $type = 'text')
	{
		$value = htmlspecialchars($value);
		return '<input type="' . $type . '" name="' . $name . '" value="' . $value . '" />';
	}


	public static function label($name)
	{
		return '<label>' . $name . '</label>';
	}
}