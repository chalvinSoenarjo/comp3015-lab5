<?php

namespace src\Repositories;

require_once __DIR__ . '/../../vendor/autoload.php'; // needed for Composer dependencies

use PDO;
use PDOException;

class Repository
{
	protected PDO $pdo;
	private string $hostname;
	private string $username;
	private string $databaseName;
	private string $databasePassword;
	private string $charset;

	public function __construct()
	{
		// TODO: Load the correct environment file depending on how the application is run.
		// SAPI -> Server API
		// See: https://www.php.net/manual/en/function.php-sapi-name.php

		// After loading the environment file, remove all hardcoded credentials/environment info.

		$this->hostname = 'localhost';
		$this->username = 'root';
		$this->databaseName = 'posts_web_app';
		$this->databasePassword = '';
		$this->charset = 'utf8mb4';

		$dsn = "mysql:host=$this->hostname;dbname=$this->databaseName;charset=$this->charset";
		// For options info, see: https://www.php.net/manual/en/pdo.setattribute.php
		$options = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];
		try {
			$this->pdo = new PDO($dsn, $this->username, $this->databasePassword, $options);
		} catch (PDOException $e) {
			throw new PDOException($e->getMessage(), (int)$e->getCode());
		}
	}
}
