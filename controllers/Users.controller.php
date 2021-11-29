<?php
require_once "models/user/UsersManager.class.php";
/**
 * Class UsersController
 * Crontrol the users
 */
class UsersController {
    /**
     * @var object $userManager
     */
    private $userManager;

    /**
     * construct for new instance
     */
    public function __construct()
    {
        $this->userManager = new UsersManager;
    }

    /**
     * @param string $email user email
     * @param string $password user password
     * @return void
     */
    public function getUser($email,$password) {
        if(!empty($email) && !empty($password)) {
            $this->userManager->findUser($email,$password);
            unset($_SESSION['alert']);
        } else {
            $_SESSION['alert'] = [
                "type" => "error",
                "msg" => "Il manque un champs"
            ];
            require "views/signin.view.php";
            unset($_SESSION['alert']);
        }
    }

    /**
     * Send the email and password data to the updateUser function
     * in the class UsersManagers
     * @param string user email
     * @param string user password
     * @return void
     */
    public function updateUser($email,$password){
        $this->userManager->updateUser($email,$password);
    }

    /**
     * Send the user ID to the deleteUser function in the
     * class UsersManagers
     * @param int $id userId
     * @return void
     */
    public function deleteUser($id) {
        $this->userManager->deleteUser($id);
    }

    /**
     * Send the data necessary to create the user for
     * function in the class UsersManagers
     * @param string $pseudo username
     * @param string $email user email
     * @param string $password user password
     * @param string $confirm_password confirm user password
     * @return void
     */
    public function createUser($pseudo,$email,$password,$confirm_password) {
        if(!empty($pseudo) && !empty($email) && !empty($password) && !empty($confirm_password)) {
            if ($password === $confirm_password) {
                $this->userManager->addUser(
                    $pseudo,
                    $email,
                    $password
                );
                require "views/signup.view.php";
                unset($_SESSION['alert']);
            } else {
                $_SESSION['alert'] = [
                    "type" => "error",
                    "msg" => "Le mot de passe ne correspond pas"
                ];
                require "views/signup.view.php";
                unset($_SESSION['alert']);
            }
        } else {
            $_SESSION['alert'] = [
                "type" => "error",
                "msg" => "Il manque un champs"
            ];
            require "views/signup.view.php";
            unset($_SESSION['alert']);
        }
    }

    /**
     * Delete cookies sessions users
     * @return void
     */
    public function logoutUser() {
        header('Location: /');
        unset($_SESSION['user']);
    }

}