<?php

function getLastPosts() :object {
    $posts = searchAllInTable('posts');

    return $posts;
}

function getAllPosts() :object {
    $posts = searchAllInTable('posts');

    return $posts;
}