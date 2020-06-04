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

    public function createNewPost(array $submit, string $file) :void {
        $timestamp = date('Y-m-d H:i:s');

        $insert = "INSERT INTO posts (name, picture, catchphrase, content, created_at, updated_at, is_deleted)
        VALUES (:name, '', :catchphrase, :content, '$timestamp', '$timestamp', false)";

        //! TODO a retirer après le débug
        //$this->database->create($insert, $submit);

        //$postId = $this->database->getLastId('posts');

        //$this->addPicture($postId, $file);
    }

    public function updatePost(array $post) :void {
        $timestamp= date('Y-m-d H:i:s');

        $update = "UPDATE posts
            SET name='" . $post['name'] ."', catchphrase='" . $post['catchphrase'] . "', content='" . $post['content'] . "', updated_at= '" . $timestamp . "'
            WHERE id='" . $post['id'] . "'";

        $this->database->update($update);
    }

    public function addPicture(string $postId, string $file) :void {
        $pathToImages = 'posts_images/' . $postId .'/';

        //! TODO a retirer après le débug
        //mkdir($pathToImages);

        copy($file, $pathToImages . 'mainPicture');

        $update = "UPDATE posts SET picture ='". $_FILES['picture']['tmp_name'] . "' WHERE id ='" . $postId ."'";

        $this->database->update($update);

        var_dump($pathToImages);
        var_dump($update);
        var_dump($postId);
        var_dump($file);
        var_dump($_FILES['picture']['tmp_name']);

        die;
    }

    public function deletePost(array $submit) :void {
        $update = "UPDATE posts SET is_deleted = true WHERE id = :id ";

        $this->database->update($update, $submit);
    }
}