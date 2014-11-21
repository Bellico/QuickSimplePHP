<?php

namespace App;

use App\Query;

class Orm
{
	private $connection;
	private $server = "localhost";
	private $base = "franck";
	private $user = "root";
	private $password = "";
	private $entityContext;

	public function __construct()
	{
		$this->connection = new \PDO("mysql:host=$this->server;dbname=$this->base", $this->user, $this->password, array(\PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));
		$this->connection->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
	}

	public function setEntityContext($entity)
	{
		$this->entityContext = $entity;
	}

	public function save($entity)
	{
		if($entity->id != null)
			return $this->update($entity);
		else
			return $this->insert($entity);
	}

	public function selectAll()
	{
		$query = new Query($this->entityContext);
		$query->Select();

		$execute = $this->executeQuery($query);
		return $execute->fetchAll(\PDO::FETCH_OBJ);
	}

	public function find($id)
	{
		$query = new Query($this->entityContext);
		$query->Select()->Where('id = :id');
		$execute = $this->executeQuery($query, [':id' => $id]);
		return $execute->fetch(\PDO::FETCH_OBJ);
	}

	public function delete($id)
	{
		if(is_object($id)) $id = $id->id;-
		$query = new Query($this->entityContext);
		$query->Delete()->Where('id = :id');
		return $this->executeQuery($query, [':id' => $id], true);
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

		return $this->executeQuery($query, $params, true);
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

		return $this->executeQuery($query, $params, true);
	}

	private function executeQuery(Query $query, $params = null, $end = false)
	{
		$execute = $this->connection->prepare($query->getQuery());
		$res = $execute->execute($params);

		if($end) return $res;
		else return $execute;
	}
}