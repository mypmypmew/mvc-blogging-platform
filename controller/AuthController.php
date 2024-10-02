<?php

namespace app\controllers;

use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;
use app\core\Application;
use app\core\middlewares\BaseMiddleware;

class AuthController extends Controller
{
	public function __construct()
	{
		$this->registerMiddleware(new AuthMiddleware(['profile']));
	}

	public function login(Request $request, Response $response){
		$loginForm = new LoginForm();
		if($request->isPost()){
			$loginForm->loadData($request->getBody());
			if($loginForm->validate() && $loginForm->login()){
				$response->redirect('/www/mvc_framework/public/');
				exit();
			}
		}
		$this->setLayout('auth');
		return $this->render('login', [
			'model' => $loginForm,
		]);
	}
	public function register($request){

		$errors = [];
		$user = new User();

		$this->setLayout('auth');
		if($request->isPost()){
			$user->loadData($request->getBody());
			if($user->validate() && $user->save()) {
				Application::$app->session->setFlash("success", "Thanks for signing up!");
				Application::$app->response->redirect('/www/mvc_framework/public/');
				exit;
			}
			return $this->render("register", [
				'model' => $user,]);
		}
		return $this->render("register", ['model' => $user]);
	}

	public function logout(Request $request, Response $response) {
		Application::$app->logout();
		$response->redirect('/www/mvc_framework/public/');
	}
	public function profile()
	{

		return $this->render("profile");
	}
}