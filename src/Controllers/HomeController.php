<?php

require '../src/Models/Entities/Posts.php';

function homepage($twig){
    echo $twig->render('home.twig', [
        'posts' => getAllPosts()
    ]);
}