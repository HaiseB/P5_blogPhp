<?php

define('BASE_PATH', dirname(__DIR__));

$loader = require __DIR__.'/../vendor/autoload.php';

$kernel = new App\Core\Kernel($loader);

$kernel->handleRequest();

/*
switch ($page) {

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