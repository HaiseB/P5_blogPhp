<?php

session_start();

require '../vendor/autoload.php';
require '../src/Models/Functions/MainFunctions.php';

// Routing

$page = 'home';

if (isset($_GET['p'])){
    $page = $_GET['p'];
}

// Rendu du template
$loader = new Twig\Loader\FilesystemLoader('..\templates');

$twig = new \Twig\Environment($loader, [
    'cache' => false // '../tmp'
]);

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
        connexionPage($twig);
        break;

    case 'mentions_legales':
        echo $twig->render('mentions_legales.twig');
        break;

    default:
        header('HTTP/1.0 404 Not Found');
        echo $twig->render('404.twig');
}
