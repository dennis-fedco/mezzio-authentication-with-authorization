<?php

declare(strict_types=1);

ini_set('display_errors', 'On');
error_reporting(E_ALL);

include 'vendor/autoload.php';

if (getenv('CI') === 'Yes') {
    $config = include 'config/autoload/local.php';
    $pdo = new PDO($config['authentication']['pdo']['dsn'], null, null);
    $pdo->exec(file_get_contents(__DIR__ . '/Fixture/' . getenv('DBENGINE'))) || die(print_r($pdo->errorInfo(), true));
}
