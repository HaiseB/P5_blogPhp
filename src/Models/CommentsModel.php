<?php
/**
 * CommentsModel Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
namespace App\Models;

use \App\Core\Model;

/**
 * CommentsModel Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
class CommentsModel extends Model
{

    /**
     * Get all comments associated to user names
     *
     * @return array
     */
    public function getAllCommentsWithUsernames() :array
    {
        $query = 'SELECT name, content, comments.created_at, is_confirmed, comments.id as id FROM comments
            JOIN users ON comments.user_id = users.id
            WHERE comments.is_deleted = false';

        return $this->database->fetchAll($query);
    }

    /**
     * Get all comments from a post with associated to user names
     *
     * @param array $submit user id, comment id
     *
     * @return array
     */
    public function getCommentsByPostsWithUsernames(array $submit) :array
    {
        $query = "SELECT name, content, comments.created_at FROM comments
            JOIN users ON comments.user_id = users.id WHERE comments.is_deleted = false
            AND post_id= :id AND is_confirmed = 1 ORDER BY comments.updated_at";

        return $this->database->fetchAll($query, $submit);
    }

    /**
     * Get a comment by his id
     *
     * @param array $submit comment id
     *
     * @return object|null
     */
    public function getCommentById(array $submit) :?object
    {
        $query = 'SELECT * FROM comments WHERE is_deleted = false AND id= :id LIMIT 1';

        $comment = $this->database->fetch($query, $submit);

        return ($comment === false) ? null : $comment;
    }

    /**
     * Get the number of comments who are not confirmed
     *
     * @return object
     */
    public function getNumberOfNotConfirmedComments() :object
    {
        $query = 'SELECT count(*) as count FROM comments WHERE is_deleted = false AND is_confirmed = false ORDER BY updated_at';

        return $this->database->fetch($query);
    }

    /**
     * Create a new comment
     *
     * @param array $submit post id, user_id, content
     *
     * @return void
     */
    public function createComment(array $submit) :void
    {
        $timestamp = date('Y-m-d H:i:s');

        $insert = "INSERT INTO comments (post_id, user_id, content, is_confirmed, created_at, updated_at, is_deleted)
        VALUES ( :post_id , :user_id , :content , false, '$timestamp', '$timestamp', false)";

        $this->database->create($insert, $submit);
    }

    /**
     * Set is_confirmed of all non-confirmed comments to true
     *
     * @return void
     */
    public function confirmAllComments() :void
    {
        $update = "UPDATE comments SET is_confirmed = true WHERE is_confirmed = false AND is_deleted = false";

        $this->database->update($update);
    }

    /**
     * Set is_deleted to true of a comment
     *
     * @param array $submit comment id
     *
     * @return void
     */
    public function deleteComment(array $submit) :void
    {
        $update = "UPDATE comments SET is_deleted=true WHERE id= :id ";

        $this->database->update($update, $submit);
    }
}