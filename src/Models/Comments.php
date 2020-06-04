<?php

class CommentsModel extends Model {

    public function getAllComments() :array {
        $query = 'SELECT * FROM comments WHERE is_deleted = false';

        return $this->pdo->fetchAll($query);
    }

    public function getCommentsByPots(int $idPost) :array {
        $query = "SELECT * FROM comments WHERE is_deleted = false
            AND post_id='" . $idPost . "'AND is_confirmed = 1 ORDER BY updated_at";

        return $this->pdo->fetchAll($query);
    }

    public function getCommentById(int $id) :?object {
        $query = 'SELECT * FROM comments WHERE is_deleted = false AND id= ' . $id . ' LIMIT 1';

        $comment = $this->pdo->fetch($query);

        return ($comment === false) ? null : $comment;
    }


    public function getNumberOfNotConfirmedComments() :object {
        $query = 'SELECT count(*) as count FROM comments WHERE is_deleted = false AND is_confirmed = false ORDER BY updated_at';

        return $this->pdo->fetch($query);
    }

    public function createComment(array $comment) :void {
        $timestamp = date('Y-m-d H:i:s');

        $insert = 'INSERT INTO comments (post_id, user_name, content, is_confirmed, created_at, updated_at, is_deleted)
        VALUES (' . $comment['post_id'] . ", '" . $comment['user_name']  . "', '" . $comment['content']  . "', false, '" . $timestamp . "', '" . $timestamp . "', false)";

        $this->pdo->create($insert);
    }

    public function confirmAllComments() :void {
        $update = "UPDATE comments SET is_confirmed = true WHERE is_confirmed = false AND is_deleted = false";

        $this->pdo->update($update);
    }

    public function deleteComment(int $id) :void {
        $update = "UPDATE comments SET is_deleted=true WHERE id='" . $id . "'";

        $this->pdo->update($update);
    }
}