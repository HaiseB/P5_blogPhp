<?php

namespace App\Core;

class Model{

    protected $database;

    public function __construct(){
        $this->database = new Database;
    }
}