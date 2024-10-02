<?php

namespace app\core;

class Request
{
	//temporary base url
	public string $base_url = 'www/mvc_framework/public/';
	public function getPath()
	{
		$path = $_SERVER['REQUEST_URI'] ?? '/';
		$position = strpos($path, '?');

		if($position === false){
			return str_replace($this->base_url, '', $path);
		}
		return substr($path, 0, $position);
	}
	public function method(): string
	{
		return strtolower($_SERVER['REQUEST_METHOD']);
	}
	public function isGet(): bool
	{
		return $this->method() == 'get';
	}
	public function isPost(): bool
	{
		return $this->method() == 'post';
	}
	public function getBody(): array
	{
		$body = [];
		if($this->method() == 'get'){
			foreach($_GET as $key => $value){
				$body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}
		if($this->method() == 'post'){
			foreach($_POST as $key => $value){
				$body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}
		return $body;
	}
}