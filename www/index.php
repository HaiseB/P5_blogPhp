<?php

session_start();

require '../vendor/autoload.php';
require '../src/Models/Functions/MainFunctions.php';

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
        homePage($twig);
        break;

    case 'posts':
        require '../src/Controllers/PostsController.php';
        posts($twig);
        break;

    case 'connexion':
        require '../src/Controllers/UsersController.php';
        loginPage($twig);
        break;

    case 'dashboard':
        require '../src/Controllers/UsersController.php';
        dashboard($twig);
        break;

    case 'logout':
        require '../src/Controllers/UsersController.php';
        logout();
        break;

    case 'mentions_legales':
        echo $twig->render('mentions_legales.twig');
        break;

    default:
        header('HTTP/1.0 404 Not Found');
        echo $twig->render('404.twig');
}
