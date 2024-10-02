<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;

class SiteController extends Controller
{

	public function home()
	{
		$params = [
			"name" => "Ken"
		];
		return $this->render("home", $params);
		//return Application::$app->router->renderView('home', $params);
	}
	public function contact(Request $request, Response $response)
	{
		$contact = new ContactForm();
		if($request->isPost()) {
			$contact->LoadData($request->getBody());
			if($contact->validate() && $contact->send()) {
				Application::$app->session->setFlash('success', 'Thank for contacting us');
				$response->redirect("/www/mvc_framework/public/contact");
			}
		}
		return $this->render('contact', [
			'model' => $contact
		]);

	}
	public function about()
	{
		return $this->render('about');
	}
	public function handleContactForm($request): string
	{
		$body = $request->getBody();
		return 'Handling submitted data';
	}

	public function createPost()
	{
		return $this->render('post');
	}

}

