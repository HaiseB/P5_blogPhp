<?php

class UsersModel extends Model {

    public function getAllUsers() :array {
        $query = 'SELECT * FROM users WHERE is_deleted = false';

        return $this->pdo->fetchAll($query);
    }

    public function findUserByName(string $name) :?object {
        $query = "SELECT name, password FROM Users WHERE is_deleted = false AND name= '" . $name . "' LIMIT 1";

        $user = $this->pdo->fetch($query);

        return ($user === false) ? null : $user;
    }

    //! TODO remake it quick
    public function authentificationFailed(object $twig, $Session) :void {
        $Session->setFlash('danger',"<strong>Authentification échouée</strong>, Nom d'utilisateur et/ou mot de passe incorrect");

        echo $twig->render('login.twig', [
            'data' => $_POST,
            'flash' => $Session->flash()
        ]);

        die;
    }

    function loggedOnly() :void {
        if (!isset($_SESSION['auth'])) {
            header('Location: 404.html');
            die;
        }
    }

}