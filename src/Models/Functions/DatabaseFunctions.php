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

function tableExist(string $table) :bool {
    $allTables = ['posts','users'];

    return in_array($table, $allTables) ? true : false ;
}

/*function columnExist(string $table, array $columnsInTables) :bool {
    if (tableExist($table)) {

    }

    return  ? true : false ;
}*/

function searchAllInTable(string $table, array $columns = ['*'], array $options = []) :object {
    if (tableExist($table)) {
        $query = 'SELECT';

        foreach ($columns as $column) {
            if ($column === end($columns)) {
                $query .= ' ' . $column .' ';
            } else {
                $query .= ' ' . $column .' ,';
            }
        }

        $query .= ' FROM ' . $table . ' WHERE is_deleted = false ORDER BY id DESC LIMIT 12';

        $query = getPdo()->prepare($query);

        //$query->bindParam(':options', $options);

        $query->execute();

        return $query;
    }
}

/* function FindById(string $table, int $id){
} */