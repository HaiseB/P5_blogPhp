<?php

require '../src/Models/CommentsModel.php';

function delete($Session) {
    $CommentsModel = new CommentsModel;

    //TODO Add a validator class
    $submit['id'] = $_GET['id'];

    $comment = $CommentsModel->getCommentById($submit);

    if (!empty($comment)) {
        $Session->setFlash('success',"<strong> Le commentaire de : " .$comment->user_name. "</strong> A bien été supprimé! :)");
        $CommentsModel->deleteComment($submit);

        header('Location: dashboard.html');
    } else {
        $Session->setFlash('danger',"<strong>Oups !</strong> Il semblerait que ce commentaire n'existe pas :(");

        header('Location: dashboard.html');
        die;
    }
}

function confirmAll($Session) {
    $CommentsModel = new CommentsModel;

    $CommentsModel->confirmAllComments();

    $Session->setFlash('success',"<strong>Tout les commentaires on étés approuvés!</strong> :)");

    header('Location: dashboard.html');


}