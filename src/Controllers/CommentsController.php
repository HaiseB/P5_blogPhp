<?php

require '../src/Models/Functions/CommentsFunctions.php';

function delete($Session) {
    $comment = getCommentById();

    if (!empty($comment)) {
        $Session->setFlash('success',"<strong> Le commentaire de : " .$comment->user_name. "</strong> A bien été supprimé! :)");
        deleteComment();

        header('Location: dashboard.html');
        die;
    } else {
        $Session->setFlash('danger',"<strong>Oups !</strong> Il semblerait que ce commentaire n'existe pas :(");

        header('Location: dashboard.html');
        die;
    }
}

function confirmAll($Session) {
    confirmAllComments();

    $Session->setFlash('success',"<strong>Tout les commentaires on étés approuvés!</strong> :)");

    header('Location: dashboard.html');


}