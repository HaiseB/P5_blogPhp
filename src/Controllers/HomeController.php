<?php

require '../src/Models/Functions/PostsFunctions.php';
require '../src/Models/Functions/ContactFunctions.php';

function homePage($twig){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        createMail($_POST);
        //TODO AJOUTER LES MESSAGES FLASH
        echo $twig->render('home.twig');
    } else {
        echo $twig->render('home.twig');
    }
}