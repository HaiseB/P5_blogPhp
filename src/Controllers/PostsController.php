<?php

namespace src\Controllers;

use \src\Core\Controller;

class PostsController extends Controller {

    public function posts(){
        $PostsModel = new \src\Models\PostsModel;

        echo $this->twig->render('posts.twig', [
            'posts' => $PostsModel->getLastPosts()
        ]);
    }

    public function post($session){
        $PostsModel = new \src\Models\PostsModel;
        $CommentsModel = new \src\Models\CommentsModel;

        //TODO Add a validator class
        $submit['id'] = $_GET['id'];

        $post = $PostsModel->getPostById($submit);

        if (!empty($post)) {
            $CommentsModel = new \src\Models\CommentsModel;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                //TODO Add a validator class
                $comment['post_id'] = $submit['id'];
                $comment['user_name'] = $_POST['user_name'];
                $comment['content'] = $_POST['content'];

                $CommentsModel->createComment($comment);

                $session->setFlash('success',"<strong>Votre commentaire a bien été pris en compte " . $_POST['user_name'] . " !</strong> Il sera ajouté une fois validé par un Administrateur");
            }

            echo $this->twig->render('post.twig', [
                'post' => $post,
                'comments' => $CommentsModel->getCommentsByPosts($submit),
                'flash' => $session->flash()
            ]);
        } else {
            header('Location: 404.html');
            die;
        }
    }

    public function newPost($session){
        $PostsModel = new \src\Models\PostsModel;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['picture']['tmp_name']) ) {
            //TODO Add a validator class
            $post['name'] = $_POST['name'];
            $post['catchphrase'] = $_POST['catchphrase'];
            $post['content'] = $_POST['content'];

            //TODO Add a validator class
            $picture['temp'] = $_FILES['picture']['tmp_name'];
            $picture['name'] = $_FILES['picture']['name'];

            $PostsModel->createNewPost($post, $picture);

            $session->setFlash('success',"<strong>L'article à bien été créé !</strong>");

            header('Location: dashboard.html');
            die;
        }

        echo $this->twig->render('formPost.twig', [
            'flash' => $session->flash()
        ]);
    }

    public function editPost($session){
        $PostsModel = new \src\Models\PostsModel;

        //TODO Add a validator class
        $submit['id'] = $_GET['id'];

        $post = $PostsModel->getPostById($submit);

        if (!empty($post) ) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                //TODO Add a validator class
                $postSubmitted['name'] = $_POST['name'];
                $postSubmitted['catchphrase'] = $_POST['catchphrase'];
                $postSubmitted['content'] = $_POST['content'];
                $postSubmitted['id'] = $post->id;

                //TODO Add a validator class
                if (!empty($_FILES['picture']['tmp_name'])) {
                    $picture['temp'] = $_FILES['picture']['tmp_name'];
                    $picture['name'] = $_FILES['picture']['name'];

                    $PostsModel->addPicture($post->id, $picture);
                }

                $PostsModel->updatePost($postSubmitted);

                $session->setFlash('success',"<strong>L'article à bien été modifié !</strong>");

                header('Location: dashboard.html');
                die;
            }

            echo $this->twig->render('formPost.twig', [
                'post' => $post,
                'flash' => $session->flash()
            ]);

        } else {
            $session->setFlash('danger',"<strong>Cet article n'existe pas</strong> :(");

            header('Location: dashboard.html');
            die;
        }
    }

    public function delete($session) {
        $PostsModel = new \src\Models\PostsModel;
        //TODO Add a validator class
        $submit['id'] = $_GET['id'];

        $post = $PostsModel->getPostById($submit);

        if (!empty($post)) {
            $session->setFlash('success',"<strong> L'article : " .$post->name. "</strong> A bien été supprimé! :)");
            $PostsModel->deletePost($submit);

            header('Location: dashboard.html');
            die;
        } else {
            $session->setFlash('danger',"<strong>Oups !</strong> Il semblerait que cet article n'existe pas :(");

            header('Location: dashboard.html');
            die;
        }
    }
}