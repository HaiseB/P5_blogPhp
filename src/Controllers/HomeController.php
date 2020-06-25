<?php

namespace src\Controllers;

use \src\Core\Controller;

class HomeController extends Controller {

    public function homePage($session){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // @TODO Add a $_session to avoid spam
            $session->setFlash('success','<strong>Message envoyé</strong>, nous vous contacterons dès que possible ! :)');

            // @TODO Add a validator class
            $submit['name'] = $_POST['name'];
            $submit['email'] = $_POST['email'];
            $submit['textarea'] = $_POST['textarea'];

            $contact = New \src\Core\Contact;
            $contact->sendMail($submit);

            echo $this->twig->render('home.twig', [
                'flash' => $session->flash()
            ]);
        } else {
            echo $this->twig->render('home.twig', [
                'flash' => $session->flash()
            ]);
        }
    }

    public function legalMentions () {
        echo $this->twig->render('mentions_legales.twig');
    }

    public function e404(){
        header('HTTP/1.0 404 Not Found');
        echo $this->twig->render('404.twig');
    }

}
