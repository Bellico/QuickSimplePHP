<?php

namespace App;

use App\Query;

class MyOrm
{
	private $connection;
	private $server = "localhost";
	private $base = "franck";
	private $user = "root";
	private $password = "";

	public function __construct()
	{
		$this->connection = new \PDO("mysql:host=$this->server;dbname=$this->base", $this->user, $this->password, array(\PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));
		$this->connection->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
	}

	public function save($entity)
	{
		if($entity->id != null)
			return $this->update($entity);
		else
			return $this->insert($entity);
	}

	private function insert($entity)
	{
		$query = new Query($entity);
		$query->Insert();
		$params = [];
		foreach ($entity as $field => $value) {
			if($field != 'id' && !empty($value)){
				$query->Value($field);
				$params[":$field"] = $value;
			}
		}

		return $this->executeQuery($query->getQuery(), $params);
	}

	private function update($entity)
	{
		$query = new Query($entity);
		$query->Update();
		$params = [];
		foreach ($entity as $field => $value) {
			if($field != 'id' && !empty($value)){
				$query->Value($field);
				$params[":$field"] = $value;
			}
		}
		$query->Where('id = :id');
		$params[':id'] = $entity->id;

		return $this->executeQuery($query->getQuery(), $params);
	}

	private function executeQuery($query, $params)
	{
		$query = $this->connection->prepare($query);
		return $query->execute($params);
	}
}