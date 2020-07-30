<?php
/**
 * Index Doc Comment
 *
 * @category Index
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
define('BASE_PATH', dirname(__DIR__));

require __DIR__.'/../vendor/autoload.php';

$kernel = new App\Core\Kernel;
$router = $kernel->router;

/**
 * Routes
 */
$router->map('GET|POST', '/', 'DefaultController:homePage');
$router->map('GET', '/mentions_legales', 'DefaultController:legalMentions');
$router->map('GET|POST', '/login', 'UsersController:loginPage');
$router->map('GET', '/logout', 'UsersController:logout');
$router->map('GET|POST', '/create_account', 'UsersController:newUser');
$router->map('GET', '/confirme_register', 'UsersController:confirmRegister');
$router->map('GET|POST', '/forgot_password', 'UsersController:forgotPassword');
$router->map('GET|POST', '/new_password', 'UsersController:confirmPasswordReset');
$router->map('GET', '/posts', 'PostsController:posts');
$router->map('GET|POST', '/post/[i:id]', 'PostsController:post');
$router->map('GET', '/dashboard', 'UsersController:dashboard');
$router->map('GET|POST', '/new_post', 'PostsController:newPost');
$router->map('GET|POST', '/edit_post/[i:id]', 'PostsController:editPost');
$router->map('GET', '/delete_post/[i:id]', 'PostsController:delete');
$router->map('GET', '/confirm_all_comments', 'CommentsController:confirmAll');
$router->map('GET', '/delete_comment/[i:id]', 'CommentsController:delete');
$router->map('GET', '/delete_user/[i:id]', 'UsersController:delete');

$match = $router->match();

if (is_array($match)) {
    $router->callRoute($match['target'], $match['params']);
} else {
    $home = new \App\Controllers\DefaultController;
    $home->e404();
}
