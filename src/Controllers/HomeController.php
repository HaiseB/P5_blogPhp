<?php

require '../src/Models/Contact.php';

function homePage($twig, $Session){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $Session->setFlash('success','<strong>Message envoyé</strong>, nous vous contacterons dès que possible ! :)');

        //TODO Add a validator class
        $form['name'] = $_POST['name'];
        $form['email'] = $_POST['email'];
        $form['textarea'] = $_POST['textarea'];

        $contact = New Contact;
        $contact->sendMail($form);

        echo $twig->render('home.twig', [
            'flash' => $Session->flash()
        ]);
    } else {
        echo $twig->render('home.twig', [
            'flash' => $Session->flash()
        ]);
    }
}