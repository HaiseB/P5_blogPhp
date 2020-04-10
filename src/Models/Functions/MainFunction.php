<?php

function getPdo(){
    $pdo = new PDO('mysql:dbname=blogphp;host=localhost', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ
        ]
    );

    return $pdo;
}