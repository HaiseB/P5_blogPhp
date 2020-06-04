<?php

require '../src/Models/Users.php';
require '../src/Models/Posts.php';
require '../src/Models/Comments.php';


function loginPage($twig, $Session){
    //TODO Add a validator class
    if (isset($_POST['name']) && isset($_POST['password'])) {
        $UsersModel = new UsersModel;

        $name = $_POST['name'];

        $user = $UsersModel->findUserByName($name);

        if (!empty($user)) {
            if ( password_verify($_POST['password'], $user->password)) {
                $_SESSION['auth'] = $user->name;

                $Session->setFlash('success','Bon retour parmis nous <strong>' . $user->name . '</strong>! :)');

                header('Location: dashboard.html');
                die;

            } else {
                $UsersModel->authentificationFailed($twig, $Session);
            }
        } else {
            $UsersModel->authentificationFailed($twig, $Session);
        }
    } else {
        echo $twig->render('login.twig');
    }
}

function dashboard($twig, $Session){
    //TODO Add number of comments for each posts
    //TODO Add the post_id for each comments
    $UsersModel = new UsersModel;
    $PostsModel = new PostsModel;
    $CommentsModel = new CommentsModel;

    //TODO Add DataTable
    echo $twig->render('dashboard.twig', [
        'users' => $UsersModel->getAllUsers(),
        'posts' => $PostsModel->getAllPosts(),
        'flash' => $Session->flash(),
        'comments' => $CommentsModel->getAllComments(),
        'getNumberOfNotConfirmedComments' => $CommentsModel->getNumberOfNotConfirmedComments()
    ]);
}

function logout($Session){
    unset($_SESSION['auth']);

    $Session->setFlash('success','<strong>Déconnexion réussie</strong>, à bientôt ! :)');

    header('Location: index.php');
    die;
}