<?php

class PostsModel extends Model {

    public function getAllPosts() :array {
        $query = 'SELECT * FROM posts WHERE is_deleted = false';

        return $this->pdo->fetchAll($query);
    }

    public function getLastPosts() :array {
        $query = 'SELECT id, name, picture, catchphrase, created_at FROM posts WHERE is_deleted = false ORDER BY created_at DESC LIMIT 12';

        return $this->pdo->fetchAll($query);
    }

    public function getPostById(int $id) :?object {
        $query = 'SELECT * FROM posts WHERE is_deleted = false AND id= ' . $id . ' LIMIT 1';

        $post = $this->pdo->fetch($query);

        return ($post === false) ? null : $post;
    }

    public function createNewPost(array $post, string $file) :void {
        $timestamp = date('Y-m-d H:i:s');

        $insert = "INSERT INTO posts (name, picture, catchphrase, content, created_at, updated_at, is_deleted)
        VALUES ('" . $post['name'] . "', '', '" . $post['catchphrase']  . "', '" . $post['content']  . "', '" . $timestamp . "', '" . $timestamp . "', false)";

        //! TODO a retirer après le débug
        //$this->pdo->create($insert);

        $postId = $this->pdo->getLastId('posts');

        $this->addPicture($postId, $file);
    }

    public function updatePost(array $post) :void {
        $timestamp= date('Y-m-d H:i:s');

        $update = "UPDATE posts
            SET name='" . $post['name'] ."', catchphrase='" . $post['catchphrase'] . "', content='" . $post['content'] . "', updated_at= '" . $timestamp . "'
            WHERE id='" . $post['id'] . "'";

        $this->pdo->update($update);
    }

    public function addPicture(string $postId, string $file) :void {
        $pathToImages = 'posts_images/' . $postId .'/';

        //! TODO a retirer après le débug
        //mkdir($pathToImages);

        copy($_FILES['picture']['tmp_name'], $pathToImages . 'mainPicture');

        $update = "UPDATE posts SET picture ='". $_FILES['picture']['tmp_name'] . "' WHERE id ='" . $postId ."'";

        $this->pdo->update($update);

        var_dump($pathToImages);
        var_dump($update);
        var_dump($postId);
        var_dump($file);
        var_dump($_FILES['picture']['tmp_name']);

        die;
    }

    public function deletePost(int $id) :void {
        $update = "UPDATE posts SET is_deleted=true WHERE id='" . $id . "'";

        $this->pdo->update($update);
    }
}