<?php

class PostsModel extends Model {

    public function getAllPosts() :array {
        $query = 'SELECT * FROM posts WHERE is_deleted = false';

        return $this->database->fetchAll($query);
    }

    public function getLastPosts() :array {
        $query = 'SELECT id, name, picture, catchphrase, created_at FROM posts WHERE is_deleted = false ORDER BY created_at DESC LIMIT 12';

        return $this->database->fetchAll($query);
    }

    public function getPostById(array $submit) :?object {
        $query = 'SELECT * FROM posts WHERE is_deleted = false AND id= :id LIMIT 1';

        $post = $this->database->fetch($query, $submit);

        return ($post === false) ? null : $post;
    }

    public function createNewPost(array $submit, array $file) :void {
        $timestamp = date('Y-m-d H:i:s');

        $insert = "INSERT INTO posts (name, picture, catchphrase, content, created_at, updated_at, is_deleted)
        VALUES (:name, '', :catchphrase, :content, '$timestamp', '$timestamp', false)";

        $this->database->create($insert, $submit);

        $postId = $this->database->getLastId('posts');

        $this->addPicture($postId, $file);
    }

    public function updatePost(array $submit) :void {
        $timestamp= date('Y-m-d H:i:s');

        $update = "UPDATE posts
            SET name= :name, catchphrase= :catchphrase , content= :content, updated_at= '$timestamp'
            WHERE id= :id ";

        $this->database->update($update, $submit);
    }

    public function addPicture(string $postId, array $file) :void {
        $pathToImages = 'posts_images/' . $postId .'/';

        mkdir($pathToImages);

        copy($file['temp'], $pathToImages . $file['name']);

        $submit['picture'] = $file['name'];
        $submit['id'] = $postId;

        $update = "UPDATE posts SET picture = :picture WHERE id = :id ";

        $this->database->update($update, $submit);
    }

    public function deletePost(array $submit) :void {
        $update = "UPDATE posts SET is_deleted = true WHERE id = :id ";

        $this->database->update($update, $submit);
    }
}