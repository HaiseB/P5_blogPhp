<?php

namespace App\Controllers;

use \App\Core\Controller;

class UsersController extends Controller {

    public function loginPage(){
        // @TODO Add a validator class
        if (isset($_POST['name']) && isset($_POST['password'])) {
            $UsersModel = new \App\Models\UsersModel;

            $submit['name'] = $_POST['name'];

            $user = $UsersModel->findUserByName($submit);

            if (!empty($user)) {
                if ( password_verify($_POST['password'], $user->password)) {
                    $_SESSION['auth'] = $user->name;

                    $this->session->setFlash('success','Bon retour parmis nous <strong>' . $user->name . '</strong>! :)');

                    header('Location: dashboard');
                    die;

                } else {
                    $UsersModel->authentificationFailed($this->session);
                }
            } else {
                $UsersModel->authentificationFailed($this->session);
            }
        } else {
            echo $this->twig->render('login.twig');
        }
    }

    public function dashboard(){
        // @TODO Add number of comments for each posts
        // @TODO Add the post_id for each comments
        $UsersModel = new \App\Models\UsersModel;
        $PostsModel = new \App\Models\PostsModel;
        $CommentsModel = new \App\Models\CommentsModel;

        // @TODO Add DataTable
        echo $this->twig->render('dashboard.twig', [
            'users' => $UsersModel->getAllUsers(),
            'posts' => $PostsModel->getAllPosts(),
            'flash' => $this->session->flash(),
            'comments' => $CommentsModel->getAllComments(),
            'getNumberOfNotConfirmedComments' => $CommentsModel->getNumberOfNotConfirmedComments()
        ]);
    }

    public function logout(){
        unset($_SESSION['auth']);

        $this->session->setFlash('success','<strong>Déconnexion réussie</strong>, à bientôt ! :)');

        header('Location: /');
        die;
    }

}