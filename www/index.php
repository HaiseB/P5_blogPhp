<?php

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
        homepage($twig);
        break;

    case 'posts':
        require '../src/Controllers/PostsController.php';
        posts($twig);
        break;

    default:
        //TODO ajouter le formulaire de contact
        header('HTTP/1.0 404 Not Found');
        echo $twig->render('404.twig');
}
