<?php


function getAllPosts(){

    $posts = searchAllInTable('posts');

    return $posts;
}