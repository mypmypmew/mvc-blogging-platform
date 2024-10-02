<?php

namespace app\models;

use app\core\Application;
use app\core\Model;

class LoginForm extends Model
{
	public string $email = '';
	public string $password = '';

	public function rules(): array
	{
		return [
			'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
			'password' => [self::RULE_REQUIRED]
		];
	}
	/**
	 * this function checks, if email is present in db, then checks
	 * whether password matches
	 * @return bool
	 */
	public function login(): bool
	{
		/**
		 * use dynamically call, because this method used one time
		 */
		$user = (new User)->findOne(['email' => $this->email]);
		if(!$user)
		{
			$this->addError('email', 'User does not exist with this email');
			return false;
		}
		if (!password_verify($this->password, $user->password)) {
			$this->addError('password', 'Incorrect password');
			return false;
		}

		return Application::$app->login($user);
	}
	public function labels(): array
	{
		return [
			'email' => 'Your Email',
			'password' => 'Your Password',
		];
	}
}