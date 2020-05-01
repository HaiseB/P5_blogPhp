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
    require '../src/Models/Functions/PostsFunctions.php';
    echo $twig->render('dashboard.twig', [
        'posts' => getAllPosts(),
        'users' => getAllUsers()
    ]);
}

function logout(){
    //TODO AJOUTER LES MESSAGES FLASH
    unset($_SESSION['auth']);

    header('Location: index.php');
    die;
}