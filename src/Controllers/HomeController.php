<?php

require '../src/Models/Functions/PostsFunctions.php';
require '../src/Models/Functions/ContactFunctions.php';

function homePage($twig, $Session){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $Session->setFlash('success','<strong>Message envoyé</strong>, nous vous contacterons dès que possible! :)');

        createMail($_POST);

        echo $twig->render('home.twig', [
            'flash' => $Session->flash()
        ]);
    } else {
        echo $twig->render('home.twig', [
            'flash' => $Session->flash()
        ]);
    }
}