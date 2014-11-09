<?php

namespace App;

class Query
{
	private $string_sql;
	private $typeQuery;
	private $tableName;
	private $model;
	private $where;
	private $fields = '';
	private $values = '';
	private $nbValue = 0;

	public function __construct($model)
	{
		$entity = new \ReflectionObject($model);
		$this->model = $model;
		$this->tableName = $entity->getShortName();

		return $this;
	}

	public function select($fields = '*')
	{
		$this->typeQuery = 'select';
		$this->string_sql = "SELECT $fields FROM $this->tableName ";

		return $this;
	}

	public function Insert()
	{
		$this->typeQuery = 'insert';
		$this->string_sql = "INSERT INTO " . $this->tableName;
		$this->reset();

		return $this;
	}

	public function Update()
	{
		$this->typeQuery = 'update';
		$this->string_sql = "UPDATE " . $this->tableName . " SET ";
		$this->reset();

		return $this;
	}

	public function Delete()
	{
		$this->typeQuery = 'delete';
		$this->string_sql = "DELETE FROM $this->tableName ";
		$this->reset();

		return $this;
	}

	public function Value($field)
	{
		if(is_array($field)){
			foreach ($field as $val) $this->Value($val);
			return $this;
		}

		if($this->typeQuery == 'insert'){
			if($this->nbValue == 0){
				$this->fields .= $field;
				$this->values .= ":$field";
			}else{
				$this->fields .= ', ' . $field;
				$this->values .= ', ' . ":$field";
			}
		}
		else if($this->typeQuery == 'update'){
			if($this->nbValue == 0)
				$this->fields .= "$field = :$field";
			else
				$this->fields .= ', ' . "$field = :$field";
		}
		else throw new \Exception("Init Instruction Insert or Update missing");
		$this->nbValue ++;

		return $this;
	}

	public function Where($clause)
	{
		if($this->typeQuery != null){
			if($this->where == "") $this->where .= "WHERE $clause";
			else $this->where .= " AND $clause";
		}
		else throw new \Exception("Init Instruction missing");

		return $this;
	}

	public function getQuery()
	{
		if($this->typeQuery == 'select')
			return $this->string_sql . $this->where;
		else if($this->typeQuery == 'insert')
			return $this->string_sql . " ($this->fields)" . " VALUES " . "($this->values)";
		else if($this->typeQuery == 'update')
			return $this->string_sql . $this->fields . ' ' . $this->where;
		else if($this->typeQuery == 'delete')
			return $this->string_sql . $this->where;
	}

	private function reset()
	{
		$this->where = "";
		$this->fields = "";
		$this->values = "";
		$this->nbValue = 0;
	}
}