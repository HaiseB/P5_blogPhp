<?php

require '../vendor/autoload.php';
require '../src/Core/Kernel.php';

$kernel = new Kernel;

$session = $kernel->session;
$twig = $kernel->twig;

// Routing
$page = 'home';

if (isset($_GET['p'])){
    $page = $_GET['p'];
}

switch ($page) {
    case 'home':
        require '../src/Controllers/HomeController.php';
        homePage($twig, $session);
        break;

    case 'posts':
        require '../src/Controllers/PostsController.php';
        posts($twig);
        break;

    case 'post':
        require '../src/Controllers/PostsController.php';
        post($twig, $session);
        break;

    case 'login':
        require '../src/Controllers/UsersController.php';
        loginPage($twig, $session);
        break;

    case 'dashboard':
        //loggedOnly();
        require '../src/Controllers/UsersController.php';
        dashboard($twig, $session);
        break;

    case 'new_post':
        //loggedOnly();
        require '../src/Controllers/PostsController.php';
        newPost($twig, $session);
        break;

    case 'edit_post':
        //loggedOnly();
        require '../src/Controllers/PostsController.php';
        editPost($twig, $session);
        break;

    case 'delete_post':
        //loggedOnly();
        require '../src/Controllers/PostsController.php';
        delete($session);
        break;

    case 'confirm_all_comments':
        //loggedOnly();
        require '../src/Controllers/CommentsController.php';
        confirmAll($session);
        break;

    case 'delete_comment':
        //loggedOnly();
        require '../src/Controllers/CommentsController.php';
        delete($session);
        break;

    case 'logout':
        require '../src/Controllers/UsersController.php';
        logout($session);
        break;

    case 'mentions_legales':
        echo $twig->render('mentions_legales.twig');
        break;

    default:
        header('HTTP/1.0 404 Not Found');
        echo $twig->render('404.twig');
}
