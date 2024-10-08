<?php

use app\controllers\AuthController;
use app\controllers\SiteController;
use app\core\Application;
use app\core\db\DotEnv;

require_once __DIR__ . '/../vendor/autoload.php';
//use app\core\Application

$dotEnv = new DotEnv(__DIR__ . '/../.env');
$dotEnv->load();

$config = [
	'userClass' => \app\models\User::class,
	'db' => [
		'dsn' => $_ENV['DB_DSN'],
		'user' => $_ENV['DB_USER'],
		'password' => $_ENV['DB_PASSWORD'],
	]
];
$app = new Application(dirname(__DIR__), $config);

//$app->router->get('/', 'home');

$controller = new SiteController();

$app->router->get('/test', 'test');
$app->router->get('/about', [$controller, 'about']);

$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->get('/', [SiteController::class, 'home']);

$app->router->post('/contact', [SiteController::class, 'contact']);

$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);

$app->router->get('/logout', [AuthController::class, 'logout']);
$app->router->get('/profile', [AuthController::class, 'profile']);

$app->router->get('/create', [SiteController::class, 'createPost']);

$app->run();




