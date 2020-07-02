<?php

namespace App\Core;

use Symfony\Component\Dotenv\Dotenv;
use App\Core\Session;

class Kernel{

    private $dotenv;
    //private $session;

    public function __construct(){
        $dotenv = new Dotenv;
        $this->dotenv = $dotenv->load('../.env');

    }
}