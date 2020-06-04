<?php

require '../src/Models/Posts.php';
require '../src/Models/Comments.php';

function posts($twig){
    $PostsModel = new PostsModel;

    echo $twig->render('posts.twig', [
        'posts' => $PostsModel->getLastPosts()
    ]);
}

function post($twig, $Session){
    $PostsModel = new PostsModel;
    $CommentsModel = new CommentsModel;

    //TODO Add a validator class
    $submit['id'] = $_GET['id'];


    $post = $PostsModel->getPostById($submit);

    if (!empty($post)) {
        $CommentsModel = new CommentsModel;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //TODO Add a validator class
            $comment['post_id'] = $submit['id'];
            $comment['user_name'] = $_POST['user_name'];
            $comment['content'] = $_POST['content'];

            $CommentsModel->createComment($comment);

            $Session->setFlash('success',"<strong>Votre commentaire a bien été pris en compte " . $_POST['user_name'] . " !</strong> Il sera ajouté une fois validé par un Administrateur");
        }

        echo $twig->render('post.twig', [
            'post' => $post,
            'comments' => $CommentsModel->getCommentsByPosts($submit),
            'flash' => $Session->flash()
        ]);
    } else {
        header('Location: 404.html');
        die;
    }
}

function newPost($twig, $Session){
    $PostsModel = new PostsModel;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['picture']['tmp_name']) ) {
        //TODO Add a validator class
        $post['name'] = $_POST['name'];
        $post['catchphrase'] = $_POST['catchphrase'];
        $post['content'] = $_POST['content'];
        $file = $_FILES['picture']['tmp_name'];

        $PostsModel->createNewPost($post, $file);

        $Session->setFlash('success',"<strong>L'article à bien été créé !</strong>");

        header('Location: dashboard.html');
        die;
    }

    echo $twig->render('formPost.twig', [
        'flash' => $Session->flash()
    ]);
}

function editPost($twig, $Session){
    $PostsModel = new PostsModel;
    //TODO Add a validator class
    $id = $_GET['id'];

    $post = $PostsModel->getPostById($id);

    if (!empty($post) ) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //TODO vérif données
            if (!empty($_FILES['picture']['tmp_name'])) {
                addPicture();
            }
            updatePost();

            $Session->setFlash('success',"<strong>L'article à bien été modifié !</strong>");

            header('Location: dashboard.html');
            die;
        }

        echo $twig->render('formPost.twig', [
            'post' => $post,
            'flash' => $Session->flash()
        ]);

    } else {
        $Session->setFlash('danger',"<strong>Cet article n'existe pas</strong> :(");

        header('Location: dashboard.html');
        die;
    }

}

function delete($Session) {
    $PostsModel = new PostsModel;
    //TODO Add a validator class
    $submit['id'] = $_GET['id'];

    $post = $PostsModel->getPostById($submit);

    if (!empty($post)) {
        $Session->setFlash('success',"<strong> L'article : " .$post->name. "</strong> A bien été supprimé! :)");
        $PostsModel->deletePost($submit);

        header('Location: dashboard.html');
        die;
    } else {
        $Session->setFlash('danger',"<strong>Oups !</strong> Il semblerait que cet article n'existe pas :(");

        header('Location: dashboard.html');
        die;
    }
}