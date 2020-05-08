<?php

require '../src/Models/Class/session.class.php';

require '../vendor/autoload.php';
require '../src/Models/Functions/MainFunctions.php';

$Session = new Session();

// Rendu du template
$loader = new Twig\Loader\FilesystemLoader('..\templates');

$twig = new \Twig\Environment($loader, [
    'cache' => false // '../tmp'
]);

$twig->addGlobal('session', $_SESSION);

// Routing
$page = 'home';

if (isset($_GET['p'])){
    $page = $_GET['p'];
}

switch ($page) {
    case 'home':
        require '../src/Controllers/HomeController.php';
        homePage($twig, $Session);
        break;

    case 'posts':
        require '../src/Controllers/PostsController.php';
        posts($twig);
        break;

    case 'post':
        require '../src/Controllers/PostsController.php';
        post($twig);
        break;

    case 'login':
        require '../src/Controllers/UsersController.php';
        loginPage($twig, $Session);
        break;

    case 'dashboard':
        require '../src/Controllers/UsersController.php';
        dashboard($twig, $Session);
        break;

    case 'new_post':
        require '../src/Controllers/PostsController.php';
        newPost($twig, $Session);
        break;

    case 'logout':
        require '../src/Controllers/UsersController.php';
        logout($Session);
        break;

    case 'mentions_legales':
        echo $twig->render('mentions_legales.twig');
        break;

    default:
        header('HTTP/1.0 404 Not Found');
        echo $twig->render('404.twig');
}
