<?php

function findUserByName(string $name) :?object {
    $query = 'SELECT name, password FROM Users WHERE is_deleted = false AND name= :name LIMIT 1';

    $sql = getPdo()->prepare($query);

    $sql->execute(array(':name' => $name));

    $user = $sql->fetch();

    $user = ($user === false) ? null : $user ;

    return $user;
}

function getAllUsers() :object {
    $users = searchAllInTable('users');

    return $users;
}

function authentificationFailed(object $twig, $Session) :void {
    $Session->setFlash('danger',"<strong>Authentification échouée</strong>, Nom d'utilisateur et/ou mot de passe incorrect");

    echo $twig->render('login.twig', [
        'data' => $_POST,
        'flash' => $Session->flash()
    ]);

    die;
}