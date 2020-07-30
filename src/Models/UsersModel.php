<?php
/**
 * UsersModel Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
namespace App\Models;

use \App\Core\Model;

/**
 * UsersModel Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
class UsersModel extends Model
{

    /**
     * Return all users
     *
     * @return array
     */
    public function getAllUsers() :array
    {
        $query = 'SELECT * FROM users WHERE is_deleted = false';

        return $this->database->fetchAll($query);
    }

    /**
     * Find user who match the id
     *
     * @param array $submit user id
     *
     * @return object|null
     */
    public function findUserById(array $submit) :?object
    {
        $query = "SELECT name, id, password, is_admin FROM Users WHERE is_deleted = false AND id= :id LIMIT 1";

        $user = $this->database->fetch($query, $submit);

        return ($user === false) ? null : $user;
    }

    /**
     *  Find user who match the name
     *
     * @param array $submit user name
     *
     * @return object|null
     */
    public function findUserByName(array $submit) :?object
    {
        $query = "SELECT name, id, password, is_admin FROM Users WHERE is_deleted = false AND is_registered = true AND name= :name LIMIT 1";

        $user = $this->database->fetch($query, $submit);

        return ($user === false) ? null : $user;
    }

    /**
     * Find user who match the mail or name
     *
     * @param array $submit user name, user mail
     *
     * @return object|null
     */
    public function findUserByNameOrMail(array $submit) :?object
    {
        $query = "SELECT name, email FROM Users WHERE is_deleted = false AND (name= :name OR email= :email)";

        $user = $this->database->fetch($query, $submit);

        return ($user === false) ? null : $user;
    }

    /**
     *  Find user who match the token and the name
     *
     * @param array $submit user token , user name
     *
     * @return object|null
     */
    public function findUserByNameAndToken(array $submit) :?object
    {
        $query = "SELECT name, is_registered FROM Users WHERE is_deleted = false AND name= :name AND token= :token";

        $user = $this->database->fetch($query, $submit);

        return ($user === false) ? null : $user;
    }

    /**
     * Create a new non-admin user
     *
     * @param array $submit user name, user email, user passord
     *
     * @return void
     */
    public function createNewUser(array $submit) :void
    {
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

    /**
     * Set is_activate from the user to true
     *
     * @param object $user user found
     *
     * @return void
     */
    public function activateUser(object $user) :void
    {
        $timestamp= date('Y-m-d H:i:s');

        $data['updated_at'] = $timestamp;
        $data['name'] = $user->name;

        $update = "UPDATE users
            SET is_registered = true, updated_at = :updated_at
            WHERE name= :name ";

        $this->database->update($update, $data);
    }

    /**
     * Set is_deleted to true
     *
     * @param array $submit user id
     *
     * @return void
     */
    public function deleteUser(array $submit) :void
    {
        $update = "UPDATE users SET is_deleted=true WHERE id= :id ";

        $this->database->update($update, $submit);
    }

    /**
     * Set a flash message
     *
     * @param object $session session variable
     * @param array $submit submitted infos
     *
     * @return void
     */
    public function authentificationFailed(object $session, array $submit) :void
    {
        $session->setFlash('danger', "<strong>Authentification échouée</strong>, Nom d'utilisateur et/ou mot de passe incorrect");

        echo $this->twig->render(
            'login.twig', [
            'data' => $submit,
            'flash' => $session->flash()
            ]
        );
    }

    /**
     * Header to 404 if the visitor isn't logged
     *
     * @param string $auth session Infos auth
     *
     * @return void
     */
    public function loggedOnly(string $auth) :void
    {
        if (empty($auth)) {
            header('Location: /404');
        }
    }

    /**
     * Header to 404 if the visitor isn't an admin
     *
     * @param int $role session Infos role
     *
     * @return void
     */
    public function adminOnly(int $role)
    {
        if ($role === 0) {
            header('Location: /404');
        }
    }

}