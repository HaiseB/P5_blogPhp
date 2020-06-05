<?php

require '../src/Models/UsersModel.php';
require '../src/Models/PostsModel.php';
require '../src/Models/CommentsModel.php';


function loginPage($twig, $session){
    //TODO Add a validator class
    if (isset($_POST['name']) && isset($_POST['password'])) {
        $UsersModel = new UsersModel;

        $submit['name'] = $_POST['name'];

        $user = $UsersModel->findUserByName($submit);

        if (!empty($user)) {
            if ( password_verify($_POST['password'], $user->password)) {
                $_SESSION['auth'] = $user->name;

                $session->setFlash('success','Bon retour parmis nous <strong>' . $user->name . '</strong>! :)');

                header('Location: dashboard.html');
                die;

            } else {
                $UsersModel->authentificationFailed($twig, $session);
            }
        } else {
            $UsersModel->authentificationFailed($twig, $session);
        }
    } else {
        echo $twig->render('login.twig');
    }
}

function dashboard($twig, $session){
    //TODO Add number of comments for each posts
    //TODO Add the post_id for each comments
    $UsersModel = new UsersModel;
    $PostsModel = new PostsModel;
    $CommentsModel = new CommentsModel;

    //TODO Add DataTable
    echo $twig->render('dashboard.twig', [
        'users' => $UsersModel->getAllUsers(),
        'posts' => $PostsModel->getAllPosts(),
        'flash' => $session->flash(),
        'comments' => $CommentsModel->getAllComments(),
        'getNumberOfNotConfirmedComments' => $CommentsModel->getNumberOfNotConfirmedComments()
    ]);
}

function logout($session){
    unset($_SESSION['auth']);

    $session->setFlash('success','<strong>Déconnexion réussie</strong>, à bientôt ! :)');

    header('Location: index.php');
    die;
}