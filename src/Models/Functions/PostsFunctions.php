<?php

function getLastPosts() :object {
    $posts = searchAllInTable('posts');

    return $posts;
}

function getAllPosts() :object {
    $posts = searchAllInTable('posts');

    return $posts;
}

function getPostById() :object {
    $query = 'SELECT * FROM posts WHERE is_deleted = false AND id= :id LIMIT 1';

    $sql = getPdo()->prepare($query);

    $sql->execute(array(':id' => $_GET['id']));

    $post = $sql->fetch();

    return $post;
}

function createNewPost() :void {
    $pdo = getPdo();

    $insert = $pdo->prepare('INSERT INTO posts (name, picture, catchphrase, content, created_at, updated_at, is_deleted)
    VALUES (:name, :picture, :catchphrase, :content, :created_at, :updated_at, :is_deleted)');

    $name = $_POST['name'];
    $insert->bindParam(':name', $name);

    $picture = ' ';
    $insert->bindParam(':picture', $picture);

    $catchphrase = $_POST['catchphrase'];
    $insert->bindParam(':catchphrase', $catchphrase);

    $content = $_POST['content'];
    $insert->bindParam(':content', $content);

    $timestamp = date('Y-m-d H:i:s');

    $insert->bindParam(':created_at', $timestamp);
    $insert->bindParam(':updated_at', $timestamp);

    $is_deleted = 0 ;
    $insert->bindParam(':is_deleted', $is_deleted);

    $insert->execute();

    /* PICTURE */
    $lastId = ($pdo->lastInsertId());

    $pathToImages = 'posts_images/' . $lastId .'/';

    mkdir($pathToImages);

    copy($_FILES['picture']['tmp_name'], $pathToImages . $_FILES['picture']['name']);

    $update = "UPDATE posts SET picture ='". $_FILES['picture']['name']. "' WHERE id ='" . $lastId ."'";
    $stmt = $pdo->prepare($update);
    $stmt->execute();
}