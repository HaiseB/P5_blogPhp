<?php

$pdo = new PDO(
    'mysql:dbname=blogphp;host=localhost',
    'root',
    '',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
);

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