<?php

require '../src/Models/Model.php';

class PostsModel extends Model {

    public function getAllPosts() :array {
        $query = 'SELECT * FROM posts WHERE is_deleted = false';
        $posts = $this->pdo->fetchAll($query);

        return $posts;
    }

    public function getLastPosts() :array {
        $query = 'SELECT name, picture, catchphrase, created_at FROM posts WHERE is_deleted = false ORDER BY created_at DESC LIMIT 12';
        $posts = $this->pdo->fetchAll($query);

        return $posts;
    }

    public function getPostById(int $id) :?object {
        $query = 'SELECT * FROM posts WHERE is_deleted = false AND id= ' . $id . ' LIMIT 1';
        $post = $this->pdo->fetch($query);

        return $post;
    }

    public function createNewPost(array $post) :void {
        $timestamp= date('Y-m-d H:i:s');

        $insert = 'INSERT INTO posts (name, picture, catchphrase, content, created_at, updated_at, is_deleted)
        VALUES (' . $post['name'] . ", ' ', " . $post['catchphrase']  . ', ' . $post['content']  . ", '" . $timestamp . "', '" . $timestamp . "', false)";

        $this->pdo->create($insert);
    }

    function updatePost(array $post) :void {
        $timestamp= date('Y-m-d H:i:s');

        $update = "UPDATE posts
            SET name='" . $post['name'] ."', catchphrase='" . $post['catchphrase'] . "', content='" . $post['content'] . "', updated_at= '" . $timestamp . "'
            WHERE id='" . $post['id'] . "'";

        $this->pdo->update($update);
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
    
    function deletePost(int $id) :void {
        $update = "UPDATE posts SET is_deleted=true WHERE id='" . $id . "'";

        $this->pdo->update($update);
    }
}