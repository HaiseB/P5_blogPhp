<?php
/**
 * UsersController Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
namespace App\Controllers;

use \App\Core\Controller;
/**
 * UsersController Class Doc Comment
 *
 * @category Class
 * @package  Blogphp
 * @author   HaiseB <benjaminhaise@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/HaiseB/P5_blogPhp/
 */
class UsersController extends Controller
{
    /**
     * Print the login page and log a user if the form is submit
     *
     * @return void
     */
    public function loginPage()
    {
        // @TODO Add a validator class
        if (isset($_POST['name']) && isset($_POST['password'])) {
            $UsersModel = new \App\Models\UsersModel;

            $submit['name'] = $_POST['name'];

            $user = $UsersModel->findUserByName($submit);

            if (!empty($user)) {
                if (password_verify($_POST['password'], $user->password)) {
                    $_SESSION['auth'] = $user->name;
                    $_SESSION['id'] = $user->id;
                    $_SESSION['role'] = $user->is_admin;
                    $this->session->setFlash('success', 'Bon retour parmis nous <strong>' . $user->name . '</strong>! :)');

                    ($_SESSION['role'] === '1') ? header('Location: dashboard') : header('Location: /');
                } else {
                    $UsersModel->authentificationFailed($this->session);
                }
            } else {
                $UsersModel->authentificationFailed($this->session);
            }
        } else {
            echo $this->twig->render(
                'login.twig', [
                'flash' => $this->session->flash()
                ]
            );
        }
    }

    /**
     * Create a new user who is not admin
     *
     * @return void
     */
    public function newUser()
    {
        // @TODO Add a validator class
        $data = $_POST;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($data['password'] === $data['passwordConfirm']) {
                $UsersModel = new \App\Models\UsersModel;

                $submit['name'] = $data['name'];
                $submit['email'] = $data['email'];

                $user = $UsersModel->findUserByNameOrMail($submit);

                if ($user) {
                    $this->session->setFlash('danger', "Oups! Il semblerait que <strong>votre surnom</strong> ou <strong>votre email</strong>  soit déjà utilisé par un autre utilisateur :(");
                    echo $this->twig->render(
                        'newAccount.twig', [
                        'data' => $data,
                        'flash' => $this->session->flash()
                        ]
                    );
                } else {
                    $submit['password'] = $data['password'];
                    $UsersModel->createNewUser($submit);
                    $this->session->setFlash('success', "Félicitation, il ne reste plus qu'a <strong>activer votre compte via le mail qui vient de vous etre envoyé</strong> :)");
                    header('Location: /');
                }
            } else {
                $this->session->setFlash('danger', '<strong>Les mots de passes sont différents</strong> :(');
                echo $this->twig->render(
                    'newAccount.twig', [
                    'data' => $data,
                    'flash' => $this->session->flash()
                    ]
                );
            }
        } else {
            echo $this->twig->render('newAccount.twig');
        }
    }

    /**
     * Print the dashboard
     *
     * @return void
     */
    public function dashboard()
    {
        // @TODO Add number of comments for each posts
        // @TODO Add the post_id for each comments
        $UsersModel = new \App\Models\UsersModel;
        $PostsModel = new \App\Models\PostsModel;
        $CommentsModel = new \App\Models\CommentsModel;

        // @TODO Add DataTable
        echo $this->twig->render(
            'dashboard.twig', [
            'users' => $UsersModel->getAllUsers(),
            'posts' => $PostsModel->getAllPosts(),
            'flash' => $this->session->flash(),
            'comments' => $CommentsModel->getAllCommentsWithUsernames(),
            'getNumberOfNotConfirmedComments' => $CommentsModel->getNumberOfNotConfirmedComments()
            ]
        );
    }

    /**
     * Confirme a pending account
     *
     * @return void
     */
    public function confirmRegister()
    {
        // @TODO Add a validator class
        $data = $_GET;

        $UsersModel = new \App\Models\UsersModel;
        $user = $UsersModel->findUserByNameAndToken($data);

        if ($user) {
            if ($user->is_registered) {
                $this->session->setFlash('warning', 'Huuuummmmm, il semblerait que le compte ai déjà été <strong>activé</strong>! :[');
            } else {
                $UsersModel->activateUser($user);
                $this->session->setFlash('success', '<strong>Compte activé</strong>, connectez vous! :)');
            }
        } else {
            $this->session->setFlash('danger', 'Oups! <strong>Aucun compte ne correspond</strong>! :(');
        }
        header('Location: /login');
    }

    /**
     * Reset the user password
     *
     * @return void
     */
    public function resetPassword()
    {
        echo $this->twig->render(
            'resetPassword.twig', [
            'flash' => $this->session->flash()
            ]
        );
    }

    /**
     * Unset $_SESSION
     *
     * @return void
     */
    public function logout()
    {
        unset($_SESSION['auth']);
        unset($_SESSION['role']);

        $this->session->setFlash('success', '<strong>Déconnexion réussie</strong>, à bientôt ! :)');
        header('Location: /');
    }

    /**
     * Set is_deleted from a user to true
     *
     * @param [type] $userId user id
     *
     * @return void
     */
    public function delete($userId)
    {
        $UsersModel = new \App\Models\UsersModel;
        // @TODO Add a validator class
        $submit['id'] = $userId;

        $user = $UsersModel->findUserById($submit);

        if (!empty($user)) {
            $this->session->setFlash('success', "L'utilisateur <strong>" .$user->name. "</strong> A bien été supprimé! :)");
            $UsersModel->deleteUser($submit);

            // @TODO delete users comments too?
            header('Location: ../dashboard');
        } else {
            $this->session->setFlash('danger', "<strong>Oups !</strong> Il semblerait que cet utilisateur n'existe pas :(");

            header('Location: ../dashboard');
        }
    }

}