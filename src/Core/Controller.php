<?php

namespace src\Core;

class Controller{

    public $twig;

    public function __construct(){
        $this->twig = TwigFactory::get();
    }
}