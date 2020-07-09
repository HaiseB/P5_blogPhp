<?php

require 'vendor/autoload.php';
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv;
$dotenv->load('.env');

$dns = 'mysql:dbname=' . $_ENV['DB_NAME'] . ';host=' . $_ENV['DB_HOST'] . ';charset=UTF8';

try {
    $pdo = new \PDO(
        $dns, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
        ]
    );
} catch (\PDOException $e) {
    echo 'Connexion failed : ' . $e->getMessage();
}

return [
    'paths' => [
        'migrations' => __DIR__ . '/db/migrations',
        'seeds' => __DIR__ . '/db/seeds'
    ],
    'environments' =>
    [
        'default_database' => 'development',
        'development' => [
            'name' => 'blogphp',
            'connection' => $pdo
        ]
    ]
];