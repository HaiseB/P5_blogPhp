<?php

require '../src/Models/Model.php';

class PostsModel extends Model {

    public function getAllPosts() :array {
        $query = 'SELECT * FROM posts WHERE is_deleted = false';
        $posts = $this->pdo->fetchAll($query);

        return $posts;
    }

    function getLastPosts() :array {
        $query = 'SELECT name, picture, catchphrase, created_at FROM posts WHERE is_deleted = false ORDER BY created_at DESC LIMIT 12';
        $posts = $this->pdo->fetchAll($query);

        return $posts;
    }

    function getPostById(int $id) :?object {
        $query = 'SELECT * FROM posts WHERE is_deleted = false AND id= ' . $id . ' LIMIT 1';
        $post = $this->pdo->fetch($query);

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
    
        $lastId = $pdo->lastInsertId();
    
        addPicture($lastId);
    
    }
    
    function updatePost() :void {
        $id = $_GET['id'];
    
        $pdo = getPdo();
    
        $update = $pdo->prepare("UPDATE posts SET name=:name, catchphrase=:catchphrase, content=:content, updated_at=:updated_at WHERE id=:id ");
    
        $name = $_POST['name'];
        $update->bindParam(':name', $name);
    
        $catchphrase = $_POST['catchphrase'];
        $update->bindParam(':catchphrase', $catchphrase);
    
        $content = $_POST['content'];
        $update->bindParam(':content', $content);
    
        $timestamp = date('Y-m-d H:i:s');
        $update->bindParam(':updated_at', $timestamp);
    
        $update->bindParam(':id', $id);
    
        $update->execute();
    }
    
    function addPicture(int $lastId) :void {
        $pdo = getPdo();
    
        $pathToImages = 'posts_images/' . $lastId .'/';
    
        mkdir($pathToImages);
    
        copy($_FILES['picture']['tmp_name'], $pathToImages . $_FILES['picture']['name']);
    
        $update = "UPDATE posts SET picture ='". $_FILES['picture']['name']. "' WHERE id ='" . $lastId ."'";
        $stmt = $pdo->prepare($update);
        $stmt->execute();
    
    }
    
    function updatePicture() :void {
        $id = $_GET['id'];
    
        $pdo = getPdo();
    
        $update = $pdo->prepare("UPDATE posts SET picture=:picture WHERE id=:id ");
    
        $picture = $_FILES['picture']['name'];
        $update->bindParam(':picture', $picture);
    
        $update->bindParam(':id', $id);
    
        $update->execute();
    
        $pathToImages = 'posts_images/' . $id .'/';
    
        mkdir($pathToImages);
    
        copy($_FILES['picture']['tmp_name'], $pathToImages . $_FILES['picture']['name']);
    }
    
    function deletePost() :void {
        $id = $_GET['id'];
        $pdo = getPdo();
    
        $update = $pdo->prepare("UPDATE posts SET is_deleted=:is_deleted WHERE id=:id ");
    
        $is_deleted = true ;
        $update->bindParam(':is_deleted', $is_deleted);
    
        $update->bindParam(':id', $id);
    
        $update->execute();
    }
}