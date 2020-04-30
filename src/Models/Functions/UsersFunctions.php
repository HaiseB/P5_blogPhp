<?php

function findUserByName(string $name) :object {
    $query = 'SELECT name, password FROM Users WHERE is_deleted = false AND name= :name LIMIT 1';

    $sql = getPdo()->prepare($query);

    $sql->execute(array(':name' => $name));

    $user = $sql->fetch();

    return $user;

    }

function authentificationFailed(object $twig) :void {
    $badReponse = "Nom d'utilisateur et/ou mot de passe incorrect";
    //TODO AJOUTER LES MESSAGES FLASH

    echo $twig->render('login.twig', [
    'data' => $_POST
    ]);
}