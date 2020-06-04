<?php

require '../src/Core/Database.php';

class Model{

    protected $database;

    public function __construct(){
        $this->database = new Database;
    }
}