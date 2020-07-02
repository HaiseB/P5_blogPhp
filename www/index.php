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
$router->map('GET', '/post/[i:id]', 'PostsController:post' );
$router->map('GET|POST', '/new_post', 'PostsController:newPost' );
$router->map('GET|POST', '/edit_post', 'PostsController:editPost()' );
$router->map('POST', '/delete_post', 'PostsController:delete()' );
$router->map('POST', '/confirm_all_comments', 'CommentsController:confirmAll()' );
$router->map('POST', '/delete_comment', 'CommentsController:delete()' );

$match = $router->match();

if (is_array($match)) {
    $router->callRoute($match['target'], $match['params']);
} else {
    $home = new \App\Controllers\DefaultController;
    $home->e404();
}
