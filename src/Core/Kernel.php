<?php

require '../src/Core/Session.php';
require '../src/Core/Model.php';
require '../src/Core/TwigFactory.php';

use Symfony\Component\Dotenv\Dotenv;

class Kernel{

    public $session;
    public $dotenv;
    public $twig;

    public function __construct(){
        $this->session = new Session;

        $dotenv = new Dotenv;
        $this->dotenv = $dotenv->load('../.env');

        $this->twig = TwigFactory::get();
    }
}