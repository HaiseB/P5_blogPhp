<?php

function getAllComments() :object {
    $comments = searchAllInTable('comments');

    return $comments;
}

function getCommentById() :?object {
    $query = 'SELECT * FROM comments WHERE is_deleted = false AND id= :id LIMIT 1';

    $sql = getPdo()->prepare($query);

    $sql->execute(array(':id' => $_GET['id']));

    $result = $sql->fetch();

    $comment = (is_bool($result)) ? null : $result ;

    return $comment;
}

function getCommentsByPots() :array {
    $query = 'SELECT * FROM comments WHERE is_deleted = false AND post_id= :post_id AND is_confirmed = 1 ORDER BY updated_at';

    $sql = getPdo()->prepare($query);

    $sql->execute(array(':post_id' => $_GET['id']));

    $comments = $sql->fetchAll();

    return $comments;
}

function getNumberOfNotConfirmedComments() :object {
    $query = 'SELECT count(*) as count FROM comments WHERE is_deleted = false AND is_confirmed = false ORDER BY updated_at';

    $sql = getPdo()->prepare($query);

    $sql->execute();

    $comments = $sql->fetch();

    return $comments;
}

function createComment() :void {
    $pdo = getPdo();

    $insert = $pdo->prepare('INSERT INTO comments (post_id, user_name, content, is_confirmed, created_at, updated_at, is_deleted)
    VALUES (:post_id, :user_name, :content, :is_confirmed, :created_at, :updated_at, :is_deleted)');

    $post_id = $_GET['id'];
    $insert->bindParam(':post_id', $post_id);

    $user_name = $_POST['user_name'];
    $insert->bindParam(':user_name', $user_name);

    $content = $_POST['content'];
    $insert->bindParam(':content', $content);

    $is_confirmed = 0 ;
    $insert->bindParam(':is_confirmed', $is_confirmed);

    $timestamp = date('Y-m-d H:i:s');

    $insert->bindParam(':created_at', $timestamp);
    $insert->bindParam(':updated_at', $timestamp);


    $is_deleted = 0 ;
    $insert->bindParam(':is_deleted', $is_deleted);

    $insert->execute();
}

function confirmAllComments() :void {
    $pdo = getPdo();

    $update = $pdo->prepare("UPDATE comments SET is_confirmed = true WHERE is_confirmed = false AND is_deleted = false ");

    $update->execute();
}

function deleteComment() :void {
    $id = $_GET['id'];
    $pdo = getPdo();

    $update = $pdo->prepare("UPDATE comments SET is_deleted= true WHERE id=:id ");

    $update->bindParam(':id', $id);

    $update->execute();
}