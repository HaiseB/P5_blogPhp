<?php
/**
 * Contact Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
namespace App\Core;

/**
 * Contact Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
class Contact
{

    /**
     * Undocumented function
     */
    public function __construct()
    {
    }

    /**
     * Send a contact mail
     *
     * @param array $form name, email, content
     *
     * @return void
     */
    public function sendContactMail(array $form)
    {
        $transport = $this->_getTranport();
        $mailer = new \Swift_Mailer($transport);

        $body = $this->_getContactMailBody($form);

        $message = (new \Swift_Message('Nouveau contact!'))
            ->setFrom([$_ENV['MAIL_NAME'] => $_ENV['MAIL_ADMIN']])
            ->setTo([$_ENV['MAIL_NAME'], $_ENV['MAIL_ADMIN'] => $_ENV['MAIL_ADMIN']])
            ->setBody($body)
            ->setContentType("text/html");

        $result = $mailer->send($message);

        return $result;
    }

    /**
     * Send a register mail
     *
     * @param array $form name, email, token
     *
     * @return void
     */
    public function sendRegisterMail(array $form)
    {
        $transport = $this->_getTranport();
        $mailer = new \Swift_Mailer($transport);

        $body = $this->_getRegisterMailBody($form);

        $message = (new \Swift_Message('Terminez votre inscription!'))
            ->setFrom([$_ENV['MAIL_NAME'] => $_ENV['MAIL_NAME']])
            ->setTo([$_ENV['MAIL_NAME'], $form['email'] => $form['name'] ])
            ->setBody($body)
            ->setContentType("text/html");

        $result = $mailer->send($message);

        return $result;
    }

    /**
     * Send a reset password mail
     *
     * @param array $form name, email, token
     *
     * @return void
     */
    public function sendResetPasswordMail(array $form)
    {
        $transport = $this->_getTranport();
        $mailer = new \Swift_Mailer($transport);

        $body = $this->_getResetMailBody($form);

        $message = (new \Swift_Message('Demande de réinitialisation de mot de passe'))
            ->setFrom([$_ENV['MAIL_NAME'] => $_ENV['MAIL_NAME']])
            ->setTo([$_ENV['MAIL_NAME'], $form['email'] => $form['name'] ])
            ->setBody($body)
            ->setContentType("text/html");

        $result = $mailer->send($message);

        return $result;
    }

    /**
     * Return the completed contact mail body
     *
     * @param array $form name, email, content
     *
     * @return string
     */
    private function _getContactMailBody(array $form) :string
    {
        $body = file_get_contents('../templates/mailContact.twig');

        $body = preg_replace("/NOMDUCONTACT/", $form['name'], $body);
        $body = preg_replace("/your@email.com/",  $form['email'], $body);
        $body = preg_replace("/DATETIME/", date("F j, Y"), $body);
        $body = preg_replace("/TEXTAREA/",  $form['textarea'], $body);

        return $body;
    }

    /**
     * Return the completed registerer mail body
     *
     * @param array $form name, email, token
     *
     * @return string
     */
    private function _getRegisterMailBody(array $form) :string
    {
        $body = file_get_contents('../templates/mailNewAccount.twig');

        $body = preg_replace("/NOMDUCONTACT/", $form['name'], $body);
        $body = preg_replace("/URL_LINK/",  $form['url'], $body);

        return $body;
    }

    /**
     * Return the reset password mail body
     *
     * @param array $form name, email, token
     *
     * @return string
     */
    private function _getResetMailBody(array $form) :string
    {
        $body = file_get_contents('../templates/mailResetPassword.twig');

        $body = preg_replace("/NOMDUCONTACT/", $form['name'], $body);
        $body = preg_replace("/URL_LINK/",  $form['url'], $body);

        return $body;
    }

    /**
     * Return transporter of the mail
     *
     * @return object
     */
    private function _getTranport() :object
    {
        return (new \Swift_SmtpTransport($_ENV['MAIL_HOST'], $_ENV['MAIL_PORT']))
            ->setUsername($_ENV['MAIL_NAME'])
            ->setPassword($_ENV['MAIL_PASS']);
    }

}
