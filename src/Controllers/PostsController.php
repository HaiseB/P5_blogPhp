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
use Symfony\Component\HttpFoundation\Request;

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
            $request = Request::createFromGlobals();

            if ($request->server->get('REQUEST_METHOD') === 'POST') {
                // @TODO Add a validator class
                $comment['post_id'] = $submit['id'];
                $comment['user_id'] = $_SESSION['id'];
                $comment['content'] = $request->get('content');

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

        $request = Request::createFromGlobals();

        if ($request->server->get('REQUEST_METHOD') === 'POST' && !empty($request->files->get(['picture']['tmp_name'])) ) {
            // @TODO Add a validator class
            $post['name'] = $request->get('name');
            $post['catchphrase'] = $request->get('catchphrase');
            $post['content'] = $request->get('content');

            // @TODO Add a validator class
            $picture['temp'] = $request->files->get(['picture']['tmp_name']);
            $picture['name'] = $request->files->get(['picture']['name']);

            $PostsModel->createNewPost($post, $picture);

            $this->session->setFlash('success', "<strong>L'article à bien été créé !</strong>");

            header('Location: dashboard');
        } else {
            echo $this->twig->render(
                'formPost.twig', [
                'flash' => $this->session->flash()
                ]
            );
        }
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
            $request = Request::createFromGlobals();

            if ($request->server->get('REQUEST_METHOD') === 'POST') {
                // @TODO Add a validator class
                $postSubmitted['name'] = $request->get('name');
                $postSubmitted['catchphrase'] = $request->get('catchphrase');
                $postSubmitted['content'] = $request->get('content');
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
            } else {
                echo $this->twig->render(
                    'formPost.twig', [
                    'post' => $post,
                    'flash' => $this->session->flash()
                    ]
                );
            }
        } else {
            $this->session->setFlash('danger', "<strong>Cet article n'existe pas</strong> :(");

            header('Location: ../dashboard');
        }
    }

    /**
     * Set is_deleted from a post to true
     *
     * @param integer $postId id of the post
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
        } else {
            $this->session->setFlash('danger', "<strong>Oups !</strong> Il semblerait que cet article n'existe pas :(");

            header('Location: ../dashboard');
        }
    }
}