<?php

namespace app\core;

use app\core\exceptions\NotFoundException;

class Router
{
	protected array $routes = [];
	public Request $request;
	public Response $response;

	public function __construct($request, $response)
	{
		$this->request = $request;
		$this->response = $response;
	}

	public function get($path, $callback)
	{
		$this->routes['get'][$path] = $callback;
	}

	public function post($path, $callback)
	{
		$this->routes['post'][$path] = $callback;
	}

	/**
	 * @throws NotFoundException
	 */
	public function resolve()
	{
		$path = $this->request->getPath();
		$method = $this->request->method();
		$callback = $this->routes[$method][$path] ?? false;
		if ($callback === false) {
			$this->response->setStatusCode(404);
			throw new NotFoundException();
		}
		if (is_array($callback)) {
			/** @var Controller $controller */
			$controller = new $callback[0]();
			Application::$app->controller = $controller;
			$controller->action = $callback[1];
//			echo '<pre>';
//			var_dump($controller->getMiddlewares());
//			echo '</pre>';
//			exit();
			foreach ($controller->getMiddlewares() as $middleware) {
				$middleware->execute();
			}
//			Application::$app->controller = new $callback[0]();
//			Application::$app->controller->action = $callback[1];
//			$callback[0] = Application::$app->controller;
		}
		$test = Application::$app->controller;

		return call_user_func(array($test, $callback[1]), $this->request, $this->response);
	}
}