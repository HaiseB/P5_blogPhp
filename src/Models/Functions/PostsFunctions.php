<?php

function getLastPosts() :object {
    $posts = searchAllInTable('posts');

    return $posts;
}