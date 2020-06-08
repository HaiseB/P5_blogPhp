<?php

namespace src\Core;

class Model{

    protected $database;

    public function __construct(){
        $this->database = new Database;
    }
}