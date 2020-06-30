<?php

namespace App\Controllers;

use Symfony\Component\Routing\Annotation\Route;
use \App\Core\Controller;

class CommentsController extends Controller {

    public function delete($session) {
        $CommentsModel = new \App\Models\CommentsModel;

        // @TODO Add a validator class
        $submit['id'] = $_GET['id'];

        $comment = $CommentsModel->getCommentById($submit);

        if (!empty($comment)) {
            $session->setFlash('success',"<strong> Le commentaire de : " .$comment->user_name. "</strong> A bien été supprimé! :)");
            $CommentsModel->deleteComment($submit);

            header('Location: dashboard.html');
        } else {
            $session->setFlash('danger',"<strong>Oups !</strong> Il semblerait que ce commentaire n'existe pas :(");

            header('Location: dashboard.html');
            die;
        }
    }

    public function confirmAll($session) {
        $CommentsModel = new \App\Models\CommentsModel;

        $CommentsModel->confirmAllComments();

        $session->setFlash('success',"<strong>Tout les commentaires on étés approuvés!</strong> :)");

        header('Location: dashboard.html');
    }

}
