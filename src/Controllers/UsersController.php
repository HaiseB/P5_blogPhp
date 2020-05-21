<?php

require '../src/Models/Functions/UsersFunctions.php';
require '../src/Models/Functions/PostsFunctions.php';
require '../src/Models/Functions/CommentsFunctions.php';

function loginPage($twig, $Session){
    if (isset($_POST['name']) && isset($_POST['password'])) {
        $user = findUserByName($_POST['name']);

        if (!empty($user)) {
            if ( password_verify($_POST['password'], $user->password)) {
                $_SESSION['auth'] = $user->name;

                $Session->setFlash('success','Bon retour parmis nous <strong>' . $user->name . '</strong>! :)');

                header('Location: dashboard.html');
                die;

            } else {
                authentificationFailed($twig, $Session);
            }
        } else {
            authentificationFailed($twig, $Session);
        }
    } else {
        echo $twig->render('login.twig');
    }
}

function dashboard($twig, $Session){
    echo $twig->render('dashboard.twig', [
        'posts' => getAllPosts(),
        'users' => getAllUsers(),
        'flash' => $Session->flash(),
        'comments' => getAllComments(),
        'getNumberOfNotConfirmedComments' => getNumberOfNotConfirmedComments()
    ]);
}

function logout($Session){
    unset($_SESSION['auth']);

    $Session->setFlash('success','<strong>Déconnexion réussie</strong>, à bientôt ! :)');

    header('Location: index.php');
    die;
}