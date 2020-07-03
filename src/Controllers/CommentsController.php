<?php

namespace App\Controllers;

use \App\Core\Controller;

class CommentsController extends Controller {

    public function delete($commentId) {
        $CommentsModel = new \App\Models\CommentsModel;

        // @TODO Add a validator class
        $submit['id'] = $commentId;

        $comment = $CommentsModel->getCommentById($submit);

        if (!empty($comment)) {
            $this->session->setFlash('success',"<strong> Le commentaire de : " .$comment->user_name. "</strong> A bien été supprimé! :)");
            $CommentsModel->deleteComment($submit);

            header('Location: ../dashboard');
        } else {
            $this->session->setFlash('danger',"<strong>Oups !</strong> Il semblerait que ce commentaire n'existe pas :(");

            header('Location: ../dashboard');
            die;
        }
    }

    public function confirmAll() {
        $CommentsModel = new \App\Models\CommentsModel;

        $CommentsModel->confirmAllComments();

        $this->session->setFlash('success',"<strong>Tout les commentaires on étés approuvés!</strong> :)");

        header('Location: dashboard');
    }

}
