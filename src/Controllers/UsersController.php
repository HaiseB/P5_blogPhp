<?php

require '../src/Models/Functions/UsersFunctions.php';

function connexionPage($twig){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        var_dump($_POST);
        login($_POST);
        echo $twig->render('login.twig');
    } else {
        echo $twig->render('login.twig');
    }
}