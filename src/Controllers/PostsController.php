<?php

require '../src/Models/Functions/PostsFunctions.php';

function posts($twig){
    echo $twig->render('posts.twig', [
        'posts' => getLastPosts()
    ]);
}