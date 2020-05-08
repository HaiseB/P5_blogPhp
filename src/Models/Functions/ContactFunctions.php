<?php

use Symfony\Component\Dotenv\Dotenv;

function getMailInfo() :array {
    $dotenv = new Dotenv();
    $dotenv->load('../.env');

    $mailInfos = [
        'mailHost' => $_ENV['MAIL_HOST'],
        'mailPort' => $_ENV['MAIL_PORT'],
        'mailName'=> $_ENV['MAIL_NAME'],
        'mailPass' => $_ENV['MAIL_PASS']
    ];

    return $mailInfos;
}

function sendMail(array $values){
    $mailInfos = getMailInfo();

    $transport = (new Swift_SmtpTransport($mailInfos['mailHost'], $mailInfos['mailPort']))
    ->setUsername($mailInfos['mailName'])
    ->setPassword($mailInfos['mailPass'])
    ;

    $mailer = new Swift_Mailer($transport);

    $body = getMailBody($values);

    $message = (new Swift_Message('Nouveau contact!'))
    ->setFrom(['contact@benjaminhaise.com' => 'BenjaminHaise.com'])
    ->setTo(['contact@benjaminhaise.com', 'benjaminhaise@gmail.com' => 'A name'])
    ->setBody($body)
    ->setContentType("text/html");
    ;

    $result = $mailer->send($message);

    return $result;
}

function getMailBody(array $values) :string {
    $body = file_get_contents('../templates/mailContact.twig');

    $body = preg_replace("/NOMDUCONTACT/", $values['name'], $body);
    $body = preg_replace("/your@email.com/",  $values['email'], $body);
    $body = preg_replace("/DATETIME/", date("F j, Y"), $body);
    $body = preg_replace("/TEXTAREA/",  $values['textarea'], $body);

    return $body;
}

function createMail(array $values):array {
    foreach ( $values as $value){
        $value = htmlspecialchars($value);
    }

    //TODO faire des vérifications
    $errors = [];
    if (!isset($values['name']) || !isset($values['email']) || !isset($values['textarea'])) {
        $errors = 'manque des infos';
    }

    if (empty($errors)) { sendMail($values); }

    return $errors;
}