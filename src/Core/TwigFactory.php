<?php

class TwigFactory{

    public $twig;

    public function __construct(){
    }

    static function get(){
        $loader = new Twig\Loader\FilesystemLoader('..\templates');

        $cache = ( $_ENV['MODE'] === 'developpement' ) ? false : '../tmp' ;

        $twig = new \Twig\Environment($loader, [
            'cache' =>  $cache
        ]);

        $twig->addGlobal('session', $_SESSION);

        return $twig;
    }

}
