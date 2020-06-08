<?php

namespace src\Core;

class Contact {

    public function __construct(){
    }

    public function sendMail(array $form){
        $transport = (new \Swift_SmtpTransport($_ENV['MAIL_HOST'], $_ENV['MAIL_PORT']))
            ->setUsername($_ENV['MAIL_NAME'])
            ->setPassword($_ENV['MAIL_PASS']);

        $mailer = new \Swift_Mailer($transport);

        $body = $this->getMailBody($form);

        $message = (new \Swift_Message('Nouveau contact!'))
            ->setFrom(['contact@benjaminhaise.com' => 'BenjaminHaise.com'])
            ->setTo(['contact@benjaminhaise.com', 'benjaminhaise@gmail.com' => 'A name'])
            ->setBody($body)
            ->setContentType("text/html");

        $result = $mailer->send($message);

        return $result;
    }

    private function getMailBody(array $form) :string {
        $body = file_get_contents('../templates/mailContact.twig');

        $body = preg_replace("/NOMDUCONTACT/", $form['name'], $body);
        $body = preg_replace("/your@email.com/",  $form['email'], $body);
        $body = preg_replace("/DATETIME/", date("F j, Y"), $body);
        $body = preg_replace("/TEXTAREA/",  $form['textarea'], $body);

        return $body;
    }

}
