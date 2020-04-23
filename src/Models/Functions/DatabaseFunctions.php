<?php

use Symfony\Component\Dotenv\Dotenv;

function getDbInfo() :array {
    $dotenv = new Dotenv();
    $dotenv->load('../.env');

    $dbInfos = [
        'dbName' => $_ENV['DB_NAME'],
        'dbHost' => $_ENV['DB_HOST'],
        'dbUser' => $_ENV['DB_USER'],
        'dbPass' => $_ENV['DB_PASS']
    ];

    return $dbInfos;
}

function getPdo() :object {
    $dbInfos = getDbInfo();

    $dns = 'mysql:dbname=' . $dbInfos['dbName'] . ';host=' . $dbInfos['dbHost'] ;

    $pdo = new PDO($dns, $dbInfos['dbUser'], $dbInfos['dbPass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ
        ]
    );

    return $pdo;
}

function searchAll(string $table, array $columns = [], array $options = []) :object {
    $query = 'SELECT * FROM ' . $table . " WHERE is_deleted = false ORDER BY id DESC LIMIT 12";

    $result = getPdo()->query($query);

    return $result;
}

function searchById(int $id, string $table, array $columns = [], array $options = []) :object {
    $query = 'SELECT * FROM ' . $table . " WHERE id='" . $id . "' AND is_deleted = false LIMIT 1";

    $result = getPdo()->query($query);

    return $result;
}

/*
function searchByCondittion(int $id, string $table){
    //AND is_deleted = false
}

function updateById(int $id, string $table, array $column, array $values){

}
*/