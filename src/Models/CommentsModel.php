<?php

namespace src\Models;

use \src\Core\Model;

class CommentsModel extends Model {

    public function getAllComments() :array {
        $query = 'SELECT * FROM comments WHERE is_deleted = false';

        return $this->database->fetchAll($query);
    }

    public function getCommentsByPosts(array $submit) :array {
        $query = "SELECT * FROM comments WHERE is_deleted = false
            AND post_id= :id AND is_confirmed = 1 ORDER BY updated_at";

        return $this->database->fetchAll($query,$submit);
    }

    public function getCommentById(array $submit) :?object {
        $query = 'SELECT * FROM comments WHERE is_deleted = false AND id= :id LIMIT 1';

        $comment = $this->database->fetch($query, $submit);

        return ($comment === false) ? null : $comment;
    }


    public function getNumberOfNotConfirmedComments() :object {
        $query = 'SELECT count(*) as count FROM comments WHERE is_deleted = false AND is_confirmed = false ORDER BY updated_at';

        return $this->database->fetch($query);
    }

    public function createComment(array $submit) :void {
        $timestamp = date('Y-m-d H:i:s');

        $insert = "INSERT INTO comments (post_id, user_name, content, is_confirmed, created_at, updated_at, is_deleted)
        VALUES ( :post_id , :user_name , :content , false, '$timestamp', '$timestamp', false)";

        $this->database->create($insert, $submit);
    }

    public function confirmAllComments() :void {
        $update = "UPDATE comments SET is_confirmed = true WHERE is_confirmed = false AND is_deleted = false";

        $this->database->update($update);
    }

    public function deleteComment(array $submit) :void {
        $update = "UPDATE comments SET is_deleted=true WHERE id= :id ";

        $this->database->update($update, $submit);
    }
}