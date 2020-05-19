<?php

require '../src/Models/Functions/PostsFunctions.php';

function posts($twig){
    echo $twig->render('posts.twig', [
        'posts' => getLastPosts()
    ]);
}

function post($twig, $Session){
    $post = getPostById();

    if (!empty($post)) {
        echo $twig->render('post.twig', [
            'post' => $post
        ]);

    } else {
        header('Location: 404.html');
        die;
    }
}

function newPost($twig, $Session){
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['picture']['tmp_name']) ) {
        //TODO vérif données
        createNewPost();

        $Session->setFlash('success',"<strong>L'article à bien été créé !</strong>");

        header('Location: dashboard.html');
        die;
    }

    echo $twig->render('formPost.twig', [
        'flash' => $Session->flash()
    ]);
}

function editPost($twig, $Session){
    $post = getPostById();

    if (!empty($post) ) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //TODO vérif données
            if (!empty($_FILES['picture']['tmp_name'])) {
                updatePicture();
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
    $post = getPostById();

    if (!empty($post)) {
        $Session->setFlash('success',"<strong> L'article : " .$post->name. "</strong> A bien été supprimé! :)");
        deletePost();

        header('Location: dashboard.html');
        die;
    } else {
        $Session->setFlash('danger',"<strong>Oups !</strong> Il semblerait que cet article n'existe pas :(");

        header('Location: dashboard.html');
        die;
    }
}