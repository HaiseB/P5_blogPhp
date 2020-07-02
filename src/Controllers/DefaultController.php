<?php

namespace App\Controllers;

use \App\Core\Controller;

class DefaultController extends Controller {

    public function homePage(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // @TODO Add a $_session to avoid spam
            $this->session->setFlash('success','<strong>Message envoyé</strong>, nous vous contacterons dès que possible ! :)');

            // @TODO Add a validator class
            $submit['name'] = $_POST['name'];
            $submit['email'] = $_POST['email'];
            $submit['textarea'] = $_POST['textarea'];

            $contact = New \App\Core\Contact;
            $contact->sendMail($submit);

            echo $this->twig->render('home.twig', [
                'flash' => $this->session->flash()
            ]);
        } else {
            echo $this->twig->render('home.twig', [
                'flash' => $this->session->flash()
            ]);
        }
    }

    public function legalMentions() {
        echo $this->twig->render('mentions_legales.twig');
    }

    public function e404(){
        header('HTTP/1.0 404 Not Found');
        echo $this->twig->render('404.twig');
    }

}
