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
class Session
{

    /**
     * Session constructor
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * Save the message
     *
     * @param string $type type of message
     * @param string $message content
     *
     * @return void
     */
    public function setFlash(string $type, string $message)
    {
        $_SESSION['flash'] = array(
            'type' => $type,
            'message' => $message
        );
    }

    /**
     * Print and delete the flash message
     *
     * @return array
     */
    public function flash() :array
    {
        $flash = array();

        if (isset($_SESSION['flash'])) {

            $flash = $_SESSION['flash'];

            unset($_SESSION['flash']);
        }

        return $flash;
    }
}