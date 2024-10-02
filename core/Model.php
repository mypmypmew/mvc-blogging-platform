<?php

namespace app\core;

abstract class Model
{
	public const RULE_REQUIRED = 'required';
	public const RULE_EMAIL = 'email';
	public const RULE_MIN = 'min';
	public const RULE_MAX = 'max';
	public const RULE_MATCH = 'match';
	public const RULE_UNIQUE = 'unique';
	public function loadData($data)
	{
		foreach ($data as $key => $value) {
			if (property_exists($this, $key)) {
				$this->$key = $value;
			}
		}
	}

	abstract public function rules(): array;

	public function labels(): array
	{

		return [];
	}

	public function getLabel($attribute)
	{
		return $this->labels()[$attribute] ?? $attribute;
	}

	public function validate() : bool{
		foreach($this->rules() as $attribute => $rules){

			$value = $this->{$attribute};
			foreach($rules as $rule) {
				$ruleName = $rule;
				if (!is_string($rule)) {
					$ruleName = $rule[0];
				}
				if ($ruleName === static::RULE_REQUIRED && !$value) {
					$this->addErrorForRule($attribute, static::RULE_REQUIRED);
				} else if ($ruleName === static::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
					$this->addErrorForRule($value, static::RULE_EMAIL);
				} else if ($ruleName === static::RULE_MIN && strlen($value) < $rule["min"]) {
					$this->addErrorForRule($attribute, static::RULE_MIN, $rule);
				} else if ($ruleName === static::RULE_MAX && strlen($value) > $rule["max"]) {
					$this->addErrorForRule($attribute, static::RULE_MAX, $rule);
				} else if ($ruleName === static::RULE_MATCH && $value !== $this->{$rule["match"]}) {
					$rule['match'] = $this->getLabel($rule["match"]);
					$this->addErrorForRule($attribute, static::RULE_MATCH, $rule);
				} else if ($ruleName === static::RULE_UNIQUE) {
					$className = $rule["class"];
					$uniqueAttribute = $rule['attr'] ?? $attribute;
					$tableName = $className::tableName();
					$stmt = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttribute = :attr");
					$stmt->bindValue(":attr", $value);
					$stmt->execute();
					$record = $stmt->fetchObject();
					if($record){
						$this->addErrorForRule($attribute, static::RULE_UNIQUE, ['field' => $this->getLabel($attribute)]);
					}
				}
			}
		}
		return empty($this->errors);
	}
	public array $errors = [];
	private function addErrorForRule(string $attribute, string $rule, array $params = []){

		$message = $this->errorMessage()[$rule] ?? '';
		foreach ($params as $key => $value) {
			$message = str_replace("{{$key}}", $value, $message);
		}
		$this->errors[$attribute][] = $message;
	}

	public function addError(string $attribute, string $message)
	{

		$this->errors[$attribute][] = $message;
	}
	public function errorMessage() : array {
		return [
			static::RULE_REQUIRED => 'This field is required.',
			static::RULE_EMAIL => 'This field must be a valid email address.',
			static::RULE_MIN => 'This field must be at least {min} characters.',
			static::RULE_MAX => 'This field must be less than {max} characters.',
			static::RULE_MATCH => 'This field must be same as {match}.',
			static::RULE_UNIQUE => 'Record with this {field} already exists.'
		];
 	}

	 public function hasError(string $attribute){
		return $this->errors[$attribute] ?? false;
	 }

	 public function getFirstError(string $attribute){
		return $this->errors[$attribute][0] ?? false;
	 }

//echo '<pre>';
//echo '</pre>';
}