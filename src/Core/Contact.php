<?php

namespace App\Core;

class Contact {

    public function __construct(){
    }

    public function sendContactMail(array $form){
        $transport = $this->getTranport();
        $mailer = new \Swift_Mailer($transport);

        $body = $this->getContactMailBody($form);

        $message = (new \Swift_Message('Nouveau contact!'))
            ->setFrom([$_ENV['MAIL_NAME'] => $_ENV['MAIL_ADMIN']])
            ->setTo([$_ENV['MAIL_NAME'], $_ENV['MAIL_ADMIN'] => $_ENV['MAIL_ADMIN']])
            ->setBody($body)
            ->setContentType("text/html");

        $result = $mailer->send($message);

        return $result;
    }

    public function sendRegisterMail(array $form){
        $transport = $this->getTranport();
        $mailer = new \Swift_Mailer($transport);

        $body = $this->getRegisterMailBody($form);

        $message = (new \Swift_Message('Terminez votre inscription!'))
            ->setFrom([$_ENV['MAIL_NAME'] => $_ENV['MAIL_NAME']])
            ->setTo([$_ENV['MAIL_NAME'], $form['email'] => $form['name'] ])
            ->setBody($body)
            ->setContentType("text/html");

        $result = $mailer->send($message);

        return $result;
    }

    private function getContactMailBody(array $form) :string {
        $body = file_get_contents('../templates/mailContact.twig');

        $body = preg_replace("/NOMDUCONTACT/", $form['name'], $body);
        $body = preg_replace("/your@email.com/",  $form['email'], $body);
        $body = preg_replace("/DATETIME/", date("F j, Y"), $body);
        $body = preg_replace("/TEXTAREA/",  $form['textarea'], $body);

        return $body;
    }

    private function getRegisterMailBody(array $form) :string {
        $body = file_get_contents('../templates/mailNewAccount.twig');

        $body = preg_replace("/NOMDUCONTACT/", $form['name'], $body);
        $body = preg_replace("/URL_LINK/",  $form['url'], $body);

        return $body;
    }


    private function getTranport() {
        return (new \Swift_SmtpTransport($_ENV['MAIL_HOST'], $_ENV['MAIL_PORT']))
            ->setUsername($_ENV['MAIL_NAME'])
            ->setPassword($_ENV['MAIL_PASS']);
    }

}
