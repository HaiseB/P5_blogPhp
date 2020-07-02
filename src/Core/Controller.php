<?php

namespace App\Core;

class Controller{

    protected $session;
    protected $twig;

    public function __construct(){
        $this->session = new Session();

        $this->twig = TwigFactory::get();

    }
}