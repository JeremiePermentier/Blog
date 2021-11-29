<?php
require_once "./models/Model.class.php";
require_once "User.class.php";
/**
 * Class UsersManager
 * Manage the Users
 */
class UsersManager extends Model {
    /**
     * @var array $user
     */
    private $user;

    /**
     * @param string Check if the email already exists in the database
     * @return object response of request SQL
     */
    protected function verifyUser($email) {
        $req = "
        SELECT * FROM users where email = :email";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":email",$email,PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $res;
    }

    /**
     * Search user for create connection
     * @param string user email
     * @param string user password
     * @return function redirect
     */
    public function findUser($email,$password) {
        $res = $this->verifyUser($email);
        if ($res['email'] != $email) {
            $_SESSION['alert'] = [
                "type" => "error",
                "msg" => "L'adresse email n'existe pas",
                'time' => time()
            ];
            http_response_code(403);
            return header('Location: /se-connecter');
        } else if (!password_verify($password, $res['password'])) { 
            $_SESSION['alert'] = [
                "type" => "error",
                "msg" => "Erreur du mot de passe",
                'time' => time()
            ];
            http_response_code(403);
            return header('Location: /se-connecter');
        } else {
            $_SESSION['alert'] = [
                "type" => "success",
                "msg" => "Vous êtes bien connecter",
                'time' => time()
            ];
            $_SESSION['user'] = [
                "auth" => 1,
                "role" => $res['role'],
                "idUser" => $res['idUser'],
                "email" => $res['email'],
                "pseudo" => $res['pseudo']
            ];
            http_response_code(200);
            return header('Location: /dashboard');
        }
    }

    /**
     * Create a request SQL for add user in database
     * @param string username
     * @param string email user
     * @param string user password
     * @return void
     */
    public function addUser($pseudo,$email,$password){

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $res = $this->verifyUser($email);
        } else {
            return $_SESSION['alert'] = [
                "type" => "error",
                "msg" => "L'email ne correspond pas au format attendu",
                'time' => time()
            ];
        }

        if (strlen($password) < 10 || strlen($password) > 200) {
            return $_SESSION['alert'] = [
                "type" => "error",
                "msg" => "Le mot de passe n'a pas le nombre de caractère attendu",
                'time' => time()
            ];
        } else if (strlen($pseudo) < 5 || strlen($pseudo) > 25) {
            return $_SESSION['alert'] = [
                "type" => "error",
                "msg" => "Le pseudo n'a pas le nombre de caractère attendu",
                'time' => time()
            ];
        }

        if ($res === false) {
            $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $req = "
            INSERT INTO users (pseudo,email,password)
            VALUES (:pseudo,:email,:password)";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":pseudo",$pseudo,PDO::PARAM_STR);
            $stmt->bindValue(":email",$email,PDO::PARAM_STR);
            $stmt->bindValue(":password",$passwordHash,PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
            $_SESSION['alert'] = [
                "type" => "success",
                "msg" => "Votre compte a bien été crée",
                'time' => time()
            ];
        } else {
            $_SESSION['alert'] = [
                "type" => "error",
                "msg" => "l'email est déjà utilisée",
                'time' => time()
            ];
        }
    }

    /**
     * Create request SQL for update the data user
     * @param string username
     * @param string user email
     * @return function redirect
     */
    public function updateUser($pseudo,$email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (strlen($pseudo) >= 5  && strlen($pseudo) <= 25) {
                $req = "UPDATE users SET pseudo = :pseudo, email = :email WHERE idUser = :userId";
                $stmt = $this->getBdd()->prepare($req);
                $stmt->bindValue(':pseudo',htmlspecialchars($pseudo),PDO::PARAM_STR);
                $stmt->bindValue(':email',htmlspecialchars($email),PDO::PARAM_STR);
                $stmt->bindValue(':userId',$_SESSION['user']['idUser'],PDO::PARAM_STR);
                $stmt->execute();
                $stmt->closeCursor();
                $_SESSION['alert'] = [
                    "type" => "success",
                    "msg" => "Votre profil à bien été modifié",
                    'time' => time()
                ];
                $_SESSION['user']['email'] = $email;
                $_SESSION['user']['pseudo'] = $pseudo;
            } else {
                $_SESSION['alert'] = [
                    "type" => "error",
                    "msg" => "Le pseudo ne correspond dispose pas du nombre de caractère attendu",
                    'time' => time()
                ];
            }
        } else {
            $_SESSION['alert'] = [
                "type" => "error",
                "msg" => "L'email ne correspond pas au format attendu",
                'time' => time()
            ];
        }
        return header('Location: /dashboard/mes-informations');
    }

    /**
     * Create a request SQL for delete a user
     * @param string int user id
     * @return function redirect
     */
    public function deleteUser($id) {

        if($_SESSION['user']['idUser'] === $id || $_SESSION['user']['role'] === "admin") {
            $req = "DELETE FROM users WHERE idUser = :id";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(':id',$id,PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
        }
        return header('Location: /');
    }
}