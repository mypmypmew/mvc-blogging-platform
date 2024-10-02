<?php


use app\core\Application;
use app\core\db\DotEnv;

require_once __DIR__ . '/vendor/autoload.php';

//use app\core\Application

$dotEnv = new DotEnv(__DIR__ . '/.env');
$dotEnv->load();

$config = [
	'db' => [
		'dsn' => $_ENV['DB_DSN'],
		'user' => $_ENV['DB_USER'],
		'password' => $_ENV['DB_PASSWORD'],
	]
];
$app = new Application(dirname(__DIR__), $config);

$app->db->applyMigration();



