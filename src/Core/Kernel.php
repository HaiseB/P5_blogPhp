<?php
/**
 * Kernel Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
namespace App\Core;

use Symfony\Component\Dotenv\Dotenv;

/**
 * Kernel Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
class Kernel
{

    private $_dotenv;
    public $router;

    /**
     * Constructor of the kernel
     */
    public function __construct()
    {
        $dotenv = new Dotenv;
        $this->_dotenv = $dotenv->load('../.env');

        $this->router = new RouterController;
    }
}