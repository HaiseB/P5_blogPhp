<?php

namespace App\Core;

use Symfony\Component\Dotenv\Dotenv;

class Kernel{

    private $dotenv;
    public $router;

    public function __construct(){
        $dotenv = new Dotenv;
        $this->dotenv = $dotenv->load('../.env');

        $this->router = new RouterController;
    }
}