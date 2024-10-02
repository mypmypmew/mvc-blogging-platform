<?php

namespace app\core\db;

use app\core\Application;

class Database
{
	public \PDO $pdo;

	public function __construct(array $config)
	{
		$dsn = $config['dsn'] ?? '';
		$user = $config['user'] ?? '';
		$pass = $config['password'] ?? '';

		try {
			$this->pdo = new \PDO($dsn, $user, $pass);
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		} catch (\PDOException $e) {
			echo $e->getMessage();
		}
	}

	/**
	 *
	 *
	 * @return void
	 */
	public function applyMigration()
	{

		$this->createMigrationTable();
		//get data from migration table and compare with migration files in migration folder
		$appliedMigrations = $this->getAppliedMigration();
		$newMigrations = [];
		$files = scandir(Application::$ROOT_DIR . '/mvc_framework/migrations/');
		$toApplyMigrations = array_diff($files, $appliedMigrations);

		//create an instance of every migration "file" and launch the method
		foreach ($toApplyMigrations as $migration) {
			if ($migration === '.' || $migration === '..') {
				continue;
			}
			require_once Application::$ROOT_DIR . '/mvc_framework/migrations/' . $migration;
			$className = pathinfo($migration, PATHINFO_FILENAME);
			$instance = new $className();
			$this->log("Applying migration $migration");
			$instance->up();
			$this->log("Applied migration $migration");
			$newMigrations[] = $migration;
			//array_push($newMigrations, $migration);
		}
		//if some migrations happened - save to db, otherwise - do nothing
		if (!empty($newMigrations)) {
			$this->saveMigration($newMigrations);
		} else {
			$this->log("All migrations applied");
		}
	}

	public function createMigrationTable()
	{
		$this->pdo->exec("
		CREATE TABLE IF NOT EXISTS migrations (
		    id INT AUTO_INCREMENT PRIMARY KEY,
		    migration VARCHAR(255),
		    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		) ENGINE=InnoDB");
	}

	public function getAppliedMigration()
	{
		$stmt = $this->pdo->prepare("SELECT migration FROM migrations");
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_COLUMN);
	}

	public function saveMigration(array $migrations)
	{
		//converting an array of migrations that saved after applying to make a sql-statement
		/*
		 * from
		 *  array(2) { [0]=> string(17) "m0001_initial.php" [1]=> string(29) "m0002_add_password_column.php" }
		 * to
		 *  string(55) "('m0001_initial.php'),('m0002_add_password_column.php')"
		 */
		var_dump($migrations);
		$str = implode(",", array_map(fn($m) => "('$m')", $migrations));
		//try to make it easier to read TO DO
		var_dump($str);
		$stmt = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES 
				$str
				");
		$stmt->execute();
	}
	protected function log($message)
	{
		echo '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;

	}

	public function prepare($qsl)
	{
		return $this->pdo->prepare($qsl);
	}

}