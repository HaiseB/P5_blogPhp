<?php

namespace App\Models;

use \App\Core\Model;

class UsersModel extends Model {

    public function getAllUsers() :array {
        $query = 'SELECT * FROM users WHERE is_deleted = false';

        return $this->database->fetchAll($query);
    }

    public function findUserById(array $submit) :?object {
        $query = "SELECT name, id, password, is_admin FROM Users WHERE is_deleted = false AND is_registered = true AND id= :id LIMIT 1";

        $user = $this->database->fetch($query, $submit);

        return ($user === false) ? null : $user;
    }

    public function findUserByName(array $submit) :?object {
        $query = "SELECT name, id, password, is_admin FROM Users WHERE is_deleted = false AND is_registered = true AND name= :name LIMIT 1";

        $user = $this->database->fetch($query, $submit);

        return ($user === false) ? null : $user;
    }

    public function findUserByNameOrMail(array $submit) :?object {
        $query = "SELECT name, email FROM Users WHERE is_deleted = false AND (name= :name OR email= :email)";

        $user = $this->database->fetch($query, $submit);

        return ($user === false) ? null : $user;
    }

    public function findUserByNameAndToken(array $submit) :?object {
        $query = "SELECT name, is_registered FROM Users WHERE is_deleted = false AND name= :name AND token= :token";

        $user = $this->database->fetch($query, $submit);

        return ($user === false) ? null : $user;
    }

    public function createNewUser(array $submit) :void {
        $data['name'] = $submit['name'];
        $data['email'] = $submit['email'];

        $timestamp = date('Y-m-d H:i:s');

        $passwordHash = password_hash($submit['password'], PASSWORD_BCRYPT);

        $alphabet = "0123456789azertyuiopqsdfghjklmwwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        $token = substr(str_shuffle(str_repeat($alphabet, 50)), 0, 50);

        $insert = "INSERT INTO users (name, email, password, token, is_registered, is_admin, created_at, updated_at, is_deleted)
            VALUES ( :name , :email , '$passwordHash', '$token', false, false, '$timestamp', '$timestamp', false)";

        $this->database->create($insert, $data);

        $data['url'] = "http://blogphp/confirme_register?token=" . $token . "&name=" . $data['name'];

        $contact = New \App\Core\Contact;
        $contact->sendRegisterMail($data);
    }

    public function activateUser(object $user) :void {
        $timestamp= date('Y-m-d H:i:s');

        $data['updated_at'] = $timestamp;
        $data['name'] = $user->name;

        $update = "UPDATE users
            SET is_registered = true, updated_at = :updated_at
            WHERE name= :name ";

        $this->database->update($update, $data);
    }

    public function deleteUser(array $submit) :void {
        $update = "UPDATE users SET is_deleted=true WHERE id= :id ";

        $this->database->update($update, $submit);
    }

    //! @TODO How to refactor it?
    public function authentificationFailed($session) :void {
        $session->setFlash('danger',"<strong>Authentification échouée</strong>, Nom d'utilisateur et/ou mot de passe incorrect");

        echo $this->twig->render('login.twig', [
            'data' => $_POST,
            'flash' => $session->flash()
        ]);

        die;
    }

    //! @TODO How to refactor it?
    public function loggedOnly() :void {
        if (!isset($_SESSION['auth'])) {
            header('Location: 404');
            die;
        }
    }

}