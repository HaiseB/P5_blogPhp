<?php

define('BASE_PATH', dirname(__DIR__));

require __DIR__.'/../vendor/autoload.php';

$kernel = new App\Core\Kernel;

// Routing
$page = 'home';

if (isset($_GET['p'])){
    $page = $_GET['p'];
}

switch ($page) {
    case 'home':
        $home = new \App\Controllers\DefaultController;
        $home->homePage();
        break;

    case 'posts':
        $post = new App\Controllers\PostsController;
        $post->posts();
        break;

    case 'post':
        $post = new \App\Controllers\PostsController;
        $post->post();
        break;

    case 'login':
        $user = new \App\Controllers\UsersController;
        $user->loginPage();
        break;

    case 'dashboard':
        //loggedOnly();
        $user = new \App\Controllers\UsersController;
        $user->dashboard();
        break;

    case 'new_post':
        //loggedOnly();
        $post = new \App\Controllers\PostsController;
        $post->newPost();
        break;

    case 'edit_post':
        //loggedOnly();
        $post = new \App\Controllers\PostsController;
        $post->editPost();
        break;

    case 'delete_post':
        //loggedOnly();
        $post = new \App\Controllers\PostsController;
        $post->delete();
        break;

    case 'confirm_all_comments':
        //loggedOnly();
        $comment = new \App\Controllers\CommentsController;
        $comment->confirmAll();
        break;

    case 'delete_comment':
        //loggedOnly();
        $comment = new \App\Controllers\CommentsController;
        $comment->delete();
        break;

    case 'logout':
        $user = new \App\Controllers\UsersController;
        $user->logout();
        break;

    case 'mentions_legales':
        $home = new \App\Controllers\DefaultController;
        $home->legalMentions();
        break;

    default:
        $home = new \App\Controllers\DefaultController;
        $home->e404();
}
