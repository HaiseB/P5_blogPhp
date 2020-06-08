<?php

require '../vendor/autoload.php';

$kernel = new src\Core\Kernel;

$session = $kernel->session;

// Routing
$page = 'home';

if (isset($_GET['p'])){
    $page = $_GET['p'];
}

switch ($page) {
    case 'home':
        $home = new \src\Controllers\HomeController;
        $home->homePage($session);
        break;

    case 'posts':
        $post = new \src\Controllers\PostsController;
        $post->posts();
        break;

    case 'post':
        $post = new \src\Controllers\PostsController;
        $post->post($session);
        break;

    case 'login':
        $user = new \src\Controllers\UsersController;
        $user->loginPage($session);
        break;

    case 'dashboard':
        //loggedOnly();
        $user = new \src\Controllers\UsersController;
        $user->dashboard($session);
        break;

    case 'new_post':
        //loggedOnly();
        $post = new \src\Controllers\PostsController;
        $post->newPost($session);
        break;

    case 'edit_post':
        //loggedOnly();
        $post = new \src\Controllers\PostsController;
        $post->editPost($session);
        break;

    case 'delete_post':
        //loggedOnly();
        $post = new \src\Controllers\PostsController;
        $post->delete($session);
        break;

    case 'confirm_all_comments':
        //loggedOnly();
        $comment = new \src\Controllers\CommentsController;
        $comment->confirmAll($session);
        break;

    case 'delete_comment':
        //loggedOnly();
        $comment = new \src\Controllers\CommentsController;
        $comment->delete($session);
        break;

    case 'logout':
        $user = new \src\Controllers\UsersController;
        $user->logout($session);
        break;

    case 'mentions_legales':
        $home = new \src\Controllers\HomeController;
        $home->legalMentions();
        break;

    default:
        $home = new \src\Controllers\HomeController;
        $home->e404();
}
