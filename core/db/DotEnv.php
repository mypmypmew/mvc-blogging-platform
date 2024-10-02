<?php


namespace app\core\db;
class DotEnv
{

	protected $path;

	/**
	 * Creating DotEnv obj when .env file is present
	 * @param string $path
	 */
	public function __construct(string $path)
	{
		if (!file_exists($path)) {
			throw new \InvalidArgumentException("$path does not exist");
		}
		$this->path = $path;
	}

	/**
	 * Load all variables to $_ENV;
	 *
	 * @return void
	 */
	public function load(): void
	{
		if (!is_readable($this->path)) {
			throw new \RuntimeException("$this->path is not readable");
		}
		$lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		foreach ($lines as $line) {
			list($name, $value) = explode('=', $line, 2);
			$name = trim($name);
			$value = trim($value);

			if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
				putenv(sprintf('%s=%s', $name, $value));
				$_ENV[$name] = $value;
			}
		}
	}
}
