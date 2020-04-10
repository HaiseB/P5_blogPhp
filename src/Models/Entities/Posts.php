<?php

function getAllPosts(){
    $pdo = getPdo();
    $posts = $pdo->query('SELECT * FROM posts ORDER BY id DESC');
    return $posts;
}