<?php

require '../src/Core/Contact.php';

function homePage($twig, $session){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $session->setFlash('success','<strong>Message envoyé</strong>, nous vous contacterons dès que possible ! :)');

        //TODO Add a validator class
        $submit['name'] = $_POST['name'];
        $submit['email'] = $_POST['email'];
        $submit['textarea'] = $_POST['textarea'];

        $contact = New Contact;
        $contact->sendMail($submit);

        echo $twig->render('home.twig', [
            'flash' => $session->flash()
        ]);
    } else {
        echo $twig->render('home.twig', [
            'flash' => $session->flash()
        ]);
    }
}