<?php

namespace src\Core;

use Symfony\Component\Dotenv\Dotenv;

class Kernel{

    public $session;
    public $dotenv;

    public function __construct(){
        $this->session = new Session;

        $dotenv = new Dotenv;
        $this->dotenv = $dotenv->load('../.env');
    }
}