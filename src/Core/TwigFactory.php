<?php
/**
 * Session Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
namespace App\Core;

/**
 * Session Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
class TwigFactory
{

    private static $_twig = null ;

    /**
     * Instanciate twig
     *
     * @return void
     */
    static function get()
    {
        $loader = new \Twig\Loader\FilesystemLoader('..\templates');

        $cache = ( $_ENV['MODE'] === 'developpement' ) ? false : '../tmp' ;

        $_twig = new \Twig\Environment(
            $loader, [
            'cache' =>  $cache
            ]
        );

        $_twig->addGlobal('session', $_SESSION);

        return $_twig;
    }

}
