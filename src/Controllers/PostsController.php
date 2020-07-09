<?php
/**
 * PostsController Class Doc Comment
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
 * PostsController Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
class PostsController extends Controller
{

    /**
     * Print all posts
     *
     * @return void
     */
    public function posts()
    {
        $PostsModel = new \App\Models\PostsModel;

        echo $this->twig->render(
            'posts.twig', [
            'posts' => $PostsModel->getLastPosts()
            ]
        );
    }

    /**
     * Get a post by his id
     *
     * @param integer $postId id of the post
     *
     * @return void
     */
    public function post(int $postId)
    {
        $PostsModel = new \App\Models\PostsModel;
        $CommentsModel = new \App\Models\CommentsModel;

        // @TODO Add a validator class
        $submit['id'] = $postId;

        $post = $PostsModel->getPostById($submit);

        if (!empty($post)) {
            $CommentsModel = new \App\Models\CommentsModel;

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['id'])) {
                // @TODO Add a validator class
                $comment['post_id'] = $submit['id'];
                $comment['user_id'] = $_SESSION['id'];
                $comment['content'] = $_POST['content'];

                $CommentsModel->createComment($comment);

                $this->session->setFlash('success', "<strong>Votre commentaire a bien été pris en compte " .  $_SESSION['auth'] . " !</strong> Il sera ajouté une fois validé par un Administrateur");
            }

            echo $this->twig->render(
                'post.twig', [
                'post' => $post,
                'comments' => $CommentsModel->getCommentsByPostsWithUsernames($submit),
                'flash' => $this->session->flash()
                ]
            );
        } else {
            header('Location: 404');
            die;
        }
    }

    /**
     * Create a new post
     *
     * @return void
     */
    public function newPost()
    {
        $PostsModel = new \App\Models\PostsModel;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['picture']['tmp_name']) ) {
            // @TODO Add a validator class
            $post['name'] = $_POST['name'];
            $post['catchphrase'] = $_POST['catchphrase'];
            $post['content'] = $_POST['content'];

            // @TODO Add a validator class
            $picture['temp'] = $_FILES['picture']['tmp_name'];
            $picture['name'] = $_FILES['picture']['name'];

            $PostsModel->createNewPost($post, $picture);

            $this->session->setFlash('success', "<strong>L'article à bien été créé !</strong>");

            header('Location: dashboard');
            die;
        }

        echo $this->twig->render(
            'formPost.twig', [
            'flash' => $this->session->flash()
            ]
        );
    }

    /**
     * Edit a post
     *
     * @param [type] $postId id of the post
     *
     * @return void
     */
    public function editPost($postId)
    {
        $PostsModel = new \App\Models\PostsModel;

        // @TODO Add a validator class
        $submit['id'] = $postId;

        $post = $PostsModel->getPostById($submit);

        if (!empty($post) ) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // @TODO Add a validator class
                $postSubmitted['name'] = $_POST['name'];
                $postSubmitted['catchphrase'] = $_POST['catchphrase'];
                $postSubmitted['content'] = $_POST['content'];
                $postSubmitted['id'] = $post->id;

                // @TODO Add a validator class
                if (!empty($_FILES['picture']['tmp_name'])) {
                    $picture['temp'] = $_FILES['picture']['tmp_name'];
                    $picture['name'] = $_FILES['picture']['name'];

                    $PostsModel->addPicture($post->id, $picture);
                }

                $PostsModel->updatePost($postSubmitted);

                $this->session->setFlash('success', "<strong>L'article à bien été modifié !</strong>");

                header('Location: ../dashboard');
                die;
            }

            echo $this->twig->render(
                'formPost.twig', [
                'post' => $post,
                'flash' => $this->session->flash()
                ]
            );

        } else {
            $this->session->setFlash('danger', "<strong>Cet article n'existe pas</strong> :(");

            header('Location: ../dashboard');
            die;
        }
    }

    /**
     * Set is_deleted from a post to true
     *
     * @param [type] $postId id of the post
     *
     * @return void
     */
    public function delete($postId)
    {
        $PostsModel = new \App\Models\PostsModel;
        // @TODO Add a validator class
        $submit['id'] = $postId;

        $post = $PostsModel->getPostById($submit);

        if (!empty($post)) {
            $this->session->setFlash('success', "<strong> L'article : " .$post->name. "</strong> A bien été supprimé! :)");
            $PostsModel->deletePost($submit);

            // @TODO delete comments too
            header('Location: ../dashboard');
            die;
        } else {
            $this->session->setFlash('danger', "<strong>Oups !</strong> Il semblerait que cet article n'existe pas :(");

            header('Location: ../dashboard');
            die;
        }
    }
}