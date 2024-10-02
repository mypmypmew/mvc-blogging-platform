<?php

namespace app\models;

use app\core\UserModel;

class User extends UserModel {

	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_DELETED = 2;
	public string $firstname = '';
	public string $lastname = '';
	public string $email = '';
	public string $password = '';
	public string $confirmPassword = '';
	public int $status = self::STATUS_INACTIVE;

	public function save(): bool
	{
		$this->status = self::STATUS_INACTIVE;
		$this->password = password_hash($this->password, PASSWORD_DEFAULT);
		return parent::save();
	}

	public function tableName(): string
	{
		return 'users';
	}

	public function primaryKey(): string
	{
		return 'id';
	}

	public function rules(): array {

		return [
			'firstname' => [self::RULE_REQUIRED],
			'lastname' => [self::RULE_REQUIRED],
			'email' => [self::RULE_EMAIL, self::RULE_REQUIRED, [self::RULE_UNIQUE,
				'class' => self::class,
				]],
			'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 25]],
			'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
		];
	}

	public function attributes() : array
	{
		return ['firstname', 'lastname', 'email', 'password', 'status'];
	}

	/**
	 * Using labels instead of properties names (html input names in register.html)
	 * @return string[]
	 */
	public function labels() : array
	{
		return [
			'firstname' => 'First name',
			'lastname' => 'Last name',
			'email' => 'Email name',
			'password' => 'Password',
			'confirmPassword' => 'Confirm password',
		];
	}

	public function getDisplayName(): string
	{
		return $this->firstname . ' ' . $this->lastname;
	}
}