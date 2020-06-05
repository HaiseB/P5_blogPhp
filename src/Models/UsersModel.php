<?php

class UsersModel extends Model {

    public function getAllUsers() :array {
        $query = 'SELECT * FROM users WHERE is_deleted = false';

        return $this->database->fetchAll($query);
    }

    public function findUserByName(array $submit) :?object {
        $query = "SELECT name, password FROM Users WHERE is_deleted = false AND name= :name LIMIT 1";

        $user = $this->database->fetch($query, $submit);

        return ($user === false) ? null : $user;
    }

    //! TODO How to refactor it?
    public function authentificationFailed(object $twig, $session) :void {
        $session->setFlash('danger',"<strong>Authentification échouée</strong>, Nom d'utilisateur et/ou mot de passe incorrect");

        echo $twig->render('login.twig', [
            'data' => $_POST,
            'flash' => $session->flash()
        ]);

        die;
    }

    //! TODO How to refactor it?
    public function loggedOnly() :void {
        if (!isset($_SESSION['auth'])) {
            header('Location: 404.html');
            die;
        }
    }

}