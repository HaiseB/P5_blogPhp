<?php

namespace App\Core;

class Controller{

    protected $twig;
    protected $session;

    public function __construct($session){
        $this->twig = TwigFactory::get();

        $this->session = $session;
    }
}