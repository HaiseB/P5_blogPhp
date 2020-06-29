<?php

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Bundle\FrameworkBundle\Routing\AnnotatedRouteControllerLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\AnnotationDirectoryLoader;
use Composer\Autoload\ClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;

/** @var ClassLoader $loader */
$loader = require __DIR__.'/../vendor/autoload.php';

$kernel = new App\Core\Kernel;
//$session = $kernel->session;

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$loader = new AnnotationDirectoryLoader(
    new FileLocator(__DIR__.'/../src/Controllers/'),
    new AnnotatedRouteControllerLoader(
        new AnnotationReader()
    )
);

$routes = $loader->load(__DIR__.'/../src/Controllers/');

// Init RequestContext object
$context = RequestContext::fromUri($_SERVER['REQUEST_URI']);
//$context->fromRequest(Request::createFromGlobals());  // Or use the actual Symfony Request object

$matcher = new UrlMatcher($routes, $context);
$parameters = $matcher->match($context->getPathInfo());

$controllerInfo = explode('::',$parameters['_controller']);

$controller = new $controllerInfo[0];
$action = $controllerInfo[1];

$controller->$action();

//dump($parameters);

/*
switch ($page) {
    case 'home':
        $home = new \App\Controllers\HomeController;
        $home->homePage($session);
        break;

    case 'posts':
        $post = new \App\Controllers\PostsController;
        $post->posts();
        break;

    case 'post':
        $post = new \App\Controllers\PostsController;
        $post->post($session);
        break;

    case 'login':
        $user = new \App\Controllers\UsersController;
        $user->loginPage($session);
        break;

    case 'dashboard':
        //loggedOnly();
        $user = new \App\Controllers\UsersController;
        $user->dashboard($session);
        break;

    case 'new_post':
        //loggedOnly();
        $post = new \App\Controllers\PostsController;
        $post->newPost($session);
        break;

    case 'edit_post':
        //loggedOnly();
        $post = new \App\Controllers\PostsController;
        $post->editPost($session);
        break;

    case 'delete_post':
        //loggedOnly();
        $post = new \App\Controllers\PostsController;
        $post->delete($session);
        break;

    case 'confirm_all_comments':
        //loggedOnly();
        $comment = new \App\Controllers\CommentsController;
        $comment->confirmAll($session);
        break;

    case 'delete_comment':
        //loggedOnly();
        $comment = new \App\Controllers\CommentsController;
        $comment->delete($session);
        break;

    case 'logout':
        $user = new \App\Controllers\UsersController;
        $user->logout($session);
        break;

    case 'mentions_legales':
        $home = new \App\Controllers\HomeController;
        $home->legalMentions();
        break;

    default:
        $home = new \App\Controllers\HomeController;
        $home->e404();
}
*/