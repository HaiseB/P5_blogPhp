<?php
/**
 * DefaultController Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
namespace App\Controllers;

use \App\Core\Controller;

/**
 * DefaultController Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
class DefaultController extends Controller
{

    /**
     * Print the homepage and send a contact mail if the form is submited
     *
     * @return void
     */
    public function homePage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // @TODO Add a $_session to avoid spam
            $this->session->setFlash('success', '<strong>Message envoyé</strong>, nous vous contacterons dès que possible ! :)');

            // @TODO Add a validator class
            $submit['name'] = $_POST['name'];
            $submit['email'] = $_POST['email'];
            $submit['textarea'] = $_POST['textarea'];

            $contact = New \App\Core\Contact;
            $contact->sendContactMail($submit);

            echo $this->twig->render(
                'home.twig', [
                'flash' => $this->session->flash()
                ]
            );
        } else {
            echo $this->twig->render(
                'home.twig', [
                'flash' => $this->session->flash()
                ]
            );
        }
    }

    /**
     * Print the legal mentions page
     *
     * @return void
     */
    public function legalMentions()
    {
        echo $this->twig->render('legalMentions.twig');
    }

    /**
     * Print the 404 page
     *
     * @return void
     */
    public function e404()
    {
        header('HTTP/1.0 404 Not Found');
        echo $this->twig->render('404.twig');
    }
}
