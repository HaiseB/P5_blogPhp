<?php
/**
 * PostsModel Class Doc Comment
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
 * PostsModel Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
class PostsModel extends Model
{

    /**
     * Return all posts
     *
     * @return array
     */
    public function getAllPosts() :array
    {
        $query = 'SELECT * FROM posts WHERE is_deleted = false';

        return $this->database->fetchAll($query);
    }

    /**
     * Get posts with limit for posts page
     *
     * @return array
     */
    public function getLastPosts() :array
    {
        $query = 'SELECT id, name, picture, catchphrase, created_at FROM posts WHERE is_deleted = false ORDER BY created_at DESC LIMIT 12';

        return $this->database->fetchAll($query);
    }

    /**
     * Get a post by his id
     *
     * @param array $submit post id
     *
     * @return object|null
     */
    public function getPostById(array $submit) :?object
    {
        $query = 'SELECT * FROM posts WHERE is_deleted = false AND id= :id LIMIT 1';

        $post = $this->database->fetch($query, $submit);

        return ($post === false) ? null : $post;
    }

    /**
     * Create a new post
     *
     * @param array $submit name, catchphrase, content
     *
     * @return void
     */
    public function createNewPost(array $submit) :void
    {
        $timestamp = date('Y-m-d H:i:s');

        $insert = "INSERT INTO posts (name, picture, catchphrase, content, created_at, updated_at, is_deleted, user_id)
        VALUES (:name, '', :catchphrase, :content, '$timestamp', '$timestamp', false, :user_id)";

        $this->database->create($insert, $submit);
    }

    /**
     * Update a post
     *
     * @param array $submit name, catchphrase, content
     *
     * @return void
     */
    public function updatePost(array $submit) :void
    {
        $timestamp= date('Y-m-d H:i:s');

        $update = "UPDATE posts
            SET name= :name, catchphrase= :catchphrase, content= :content, updated_at= '$timestamp'
            WHERE id= :id ";

        $this->database->update($update, $submit);
    }

    /**
     * Add a picture
     *
     * @param string $postId post id
     * @param array $file the post's picture info
     *
     * @return void
     */
    public function addPicture(string $postId, array $file) :void
    {
        $pathToImages = 'posts_images/' . $postId .'/';

        mkdir($pathToImages);

        copy($file['temp'], $pathToImages . $file['name']);

        $submit['picture'] = $file['name'];
        $submit['id'] = $postId;

        $update = "UPDATE posts SET picture = :picture WHERE id = :id ";

        $this->database->update($update, $submit);
    }

    /**
     * Set is_deleted from post to true
     *
     * @param array $submit post id
     *
     * @return void
     */
    public function deletePost(array $submit) :void
    {
        $update = "UPDATE posts SET is_deleted = true WHERE id = :id ";

        $this->database->update($update, $submit);
    }
}