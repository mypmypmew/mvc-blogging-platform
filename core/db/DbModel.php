<?php

namespace app\core\db;

use app\core\Application;
use app\core\Model;

abstract class DbModel extends Model
{
	abstract public function tableName(): string;
	abstract public function attributes(): array;
	abstract public function primaryKey(): string;

	/**
	 * creating a new row in database
	 * @return bool
	 */
	public function save(): bool
	{
		//taking name and attributes (register data)
		$tableName = $this->tableName();
		$attributes = $this->attributes();
		//mapping all attributes to make a sql-command ? :attr
		$params = array_map(fn($attr) => ":$attr", $attributes);
		$stmt = self::prepare("INSERT INTO $tableName (".implode(',',$attributes).") VALUES (".implode(',',$params).")");

		foreach ($attributes as $attr) {
			$stmt->bindValue(":$attr", $this->{$attr});
		}
		$stmt->execute();
		return true;
	}

	public function findOne($where)
	{
		$tableName = $this::tableName();
		$attributes = array_keys($where);
		$sql = implode("AND ", array_map(fn($attr) => ":$attr", $attributes));
		// SELECT * FROM $tableName WHERE email = :email AND firstname = :firstname
		$stmt = self::prepare("SELECT * FROM $tableName WHERE $sql");
		foreach ($where as $attr => $value) {
			$stmt->bindValue(":$attr", $value);
		}
		$stmt->execute();
		return $stmt->fetchObject(static::class);
	}

	public function prepare($sql)
	{
		return Application::$app->db->pdo->prepare($sql);
	}
}