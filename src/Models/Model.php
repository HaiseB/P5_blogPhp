<?php

require '../src/Models/Database.php';

class Model{

    protected $pdo;

    public function __construct(){
        $Database = new Database;

        $this->pdo = $Database;
    }
}