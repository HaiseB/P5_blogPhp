<?php

require '../vendor/autoload.php';
require '../src/Models/Functions/MainFunction.php';

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
    /* case 'contact':
        echo $twig->render('contact.twig');
        break; */

    case 'home':
        require '../src/Controllers/HomeController.php';
        homepage($twig);
        break;

    default:
        header('HTTP/1.0 404 Not Found');
        echo $twig->render('404.twig');
}
