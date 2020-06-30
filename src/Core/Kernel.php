<?php

namespace App\Core;

use Symfony\Component\Dotenv\Dotenv;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Bundle\FrameworkBundle\Routing\AnnotatedRouteControllerLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\AnnotationDirectoryLoader;
use Composer\Autoload\ClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class Kernel{

    private $dotenv;
    private $loader;

    public function __construct($loader){
        $dotenv = new Dotenv;
        $this->dotenv = $dotenv->load('../.env');

        $this->loader = $loader;
    }

    public function handleRequest(){
        /** @var ClassLoader $loader */
        AnnotationRegistry::registerLoader([$this->loader, 'loadClass']);

        $loader = new AnnotationDirectoryLoader(
            new FileLocator(BASE_PATH.'/src/Controllers/'),
            new AnnotatedRouteControllerLoader(
                new AnnotationReader()
            )
        );

        $routes = $loader->load(BASE_PATH.'/src/Controllers/');

        // Init RequestContext object
        $context = RequestContext::fromUri($_SERVER['REQUEST_URI']);

        $matcher = new UrlMatcher($routes, $context);
        $parameters = $matcher->match($context->getPathInfo());

        $controllerInfo = explode('::',$parameters['_controller']);

        $controller = new $controllerInfo[0](new Session);
        $action = $controllerInfo[1];

        $controller->$action();

        var_dump($routes);
        die;
    }
}