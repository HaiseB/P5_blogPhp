<?php

namespace App\Controllers;

use \App\Core\Controller;

class UsersController extends Controller {

    function loginPage($session){
        // @TODO Add a validator class
        if (isset($_POST['name']) && isset($_POST['password'])) {
            $UsersModel = new \App\Models\UsersModel;

            $submit['name'] = $_POST['name'];

            $user = $UsersModel->findUserByName($submit);

            if (!empty($user)) {
                if ( password_verify($_POST['password'], $user->password)) {
                    $_SESSION['auth'] = $user->name;

                    $session->setFlash('success','Bon retour parmis nous <strong>' . $user->name . '</strong>! :)');

                    header('Location: dashboard.html');
                    die;

                } else {
                    $UsersModel->authentificationFailed($session);
                }
            } else {
                $UsersModel->authentificationFailed($session);
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }

    function dashboard($session){
        // @TODO Add number of comments for each posts
        // @TODO Add the post_id for each comments
        $UsersModel = new \App\Models\UsersModel;
        $PostsModel = new \App\Models\PostsModel;
        $CommentsModel = new \App\Models\CommentsModel;

        // @TODO Add DataTable
        echo $this->twig->render('dashboard.twig', [
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

}