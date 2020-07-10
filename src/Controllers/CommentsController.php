<?php
/**
 * CommentsController Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
namespace App\Controllers;

use \App\Core\Controller;

/**
 * CommentsController Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
class CommentsController extends Controller
{

    /**
     * Update a comment set it to delete = true
     *
     * @param integer $commentId id of the comment
     *
     * @return void
     */
    public function delete(int $commentId)
    {
        $CommentsModel = new \App\Models\CommentsModel;

        // @TODO Add a validator class
        $submit['id'] = $commentId;

        $comment = $CommentsModel->getCommentById($submit);

        if (!empty($comment)) {
            $this->session->setFlash('success', "<strong> Le commentaire de : " .$comment->name. "</strong> A bien été supprimé! :)");
            $CommentsModel->deleteComment($submit);

            header('Location: ../dashboard');
        } else {
            $this->session->setFlash('danger', "<strong>Oups !</strong> Il semblerait que ce commentaire n'existe pas :(");

            header('Location: ../dashboard');
        }
    }

    /**
     * Update all comments who are not approved yet
     *
     * @return void
     */
    public function confirmAll()
    {
        $CommentsModel = new \App\Models\CommentsModel;

        $CommentsModel->confirmAllComments();

        $this->session->setFlash('success', "<strong>Tout les commentaires on étés approuvés!</strong> :)");

        header('Location: dashboard');
    }

}
