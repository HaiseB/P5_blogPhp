<?php

require '../src/Models/Functions/UsersFunctions.php';

function loginPage($twig){
    if (isset($_POST['name']) && isset($_POST['password'])) {
        $user = findUserByName($_POST['name']);

        if (!empty($user)) {
            if ( password_verify($_POST['password'], $user->password)) {
                $_SESSION['auth'] = $user->name;

                header('Location: dashboard.html');

                die;

            } else {
                authentificationFailed($twig);
            }
        } else {
            authentificationFailed($twig);
        }
    } else {
        echo $twig->render('login.twig');
    }
}

function dashboard($twig){
    echo $twig->render('dashboard.twig');
}

function logout(){
    //TODO AJOUTER LES MESSAGES FLASH
    unset($_SESSION['auth']);

    header('Location: index.php');

    die;
}