<?php

namespace app\core;

use app\core\db\Database;
use app\core\db\DbModel;

class Application {

	//public Router $router for safety, but php7.4 required
	public static string $ROOT_DIR;
	public string $userClass;

	public string $layout = 'main';
	public Router $router;
	public Request $request;
	public Response $response;
	public Database $db;
	public Session $session;
	public static Application $app;
	public ?Controller $controller = null;
	public ?UserModel $user;
	public View $view;


	public function __construct($rootPath, $config) {
		self::$ROOT_DIR = $rootPath;
		self::$app = $this;

		$this->session = new Session();
		$this->request = new Request();
		$this->response = new Response();
		$this->router = new Router($this->request, $this->response);
		$this->view = new View();
		$this->db = new Database($config['db']);

		$this->userClass = $config['userClass'];

		$primaryValue = $this->session->get('user');
		if($primaryValue) {
			$primaryKey = (new $this->userClass)->primaryKey();
			$this->user = (new $this->userClass)->findOne([$primaryKey => $primaryValue]);
		} else {
			$this->user = null;
		}

	}

	public function run() {
		try {
			echo $this->router->resolve();
		} catch (\Exception $e) {
			$this->response->setStatusCode($e->getCode());
			echo $this->view->renderView('_error', [
				'exception' => $e,
			]);
		}
	}

	public function login(UserModel $user) : bool
	{
		$this->user = $user;
		$primaryKey = $user->primaryKey();
		$primaryKeyValue = $user->{$primaryKey};
		$this->session->set('user', $primaryKeyValue);
		return true;
	}
	public function logout()
	{
		$this->user = null;
		$this->session->remove('user');
	}

	public static function isGuest(): bool
	{
		return !self::$app->user;
	}

//	public function getController(): \app\core\Controller {
//		return $this->controller;
//	}
//
//	public function setController(\app\core\Controller $controller) : void{
//		$this->controller = $controller;
//	}
}