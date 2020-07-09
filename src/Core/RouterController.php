<?php
/**
 * RouterController Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
namespace App\Core;

use AltoRouter;

/**
 * RouterController Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
class RouterController extends AltoRouter
{

    /**
     * Redirect to the right controller
     *
     * @param [type] $target name of the route
     * @param [type] $params optonal paramaters
     *
     * @return void
     */
    public function callRoute($target, $params)
    {
        if (stripos($target, ':') !== false) {
            list($controller, $method) = explode(':', $target, 2);

            $controllerPath = "App\Controllers\\" . $controller;
            $object = new $controllerPath;

            if ($params) {
                call_user_func_array(array($object, $method), array($params['id']));
            } else {
                call_user_func(array($object, $method));
            }
        } else {
            header('Location: /');
            die;
        }

    }

}