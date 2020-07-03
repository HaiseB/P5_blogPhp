<?php

define('BASE_PATH', dirname(__DIR__));

require __DIR__.'/../vendor/autoload.php';

$kernel = new App\Core\Kernel;
$router = $kernel->router;

/**
 * Routes
 */
$router->map('GET|POST', '/', 'DefaultController:homePage' );
$router->map('GET', '/mentions_legales', 'DefaultController:legalMentions' );
$router->map('GET|POST', '/login', 'UsersController:loginPage' );
$router->map('GET', '/dashboard', 'UsersController:dashboard' );
$router->map('GET', '/logout', 'UsersController:logout' );
$router->map('GET', '/posts', 'PostsController:posts' );
$router->map('GET|POST', '/post/[i:id]', 'PostsController:post' );
$router->map('GET|POST', '/new_post', 'PostsController:newPost' );
$router->map('GET|POST', '/edit_post/[i:id]', 'PostsController:editPost' );
$router->map('GET', '/delete_post/[i:id]', 'PostsController:delete' );
$router->map('GET', '/confirm_all_comments', 'CommentsController:confirmAll' );
$router->map('GET', '/delete_comment/[i:id]', 'CommentsController:delete' );

// ADD
// create user
// send mail token user
// validate token
// delete user

$match = $router->match();

if (is_array($match)) {
    $router->callRoute($match['target'], $match['params']);
} else {
    $home = new \App\Controllers\DefaultController;
    $home->e404();
}
