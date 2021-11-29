<?php
require_once "./models/Model.class.php";
require_once "Dislike.class.php";
require_once "./models/like/LikesManager.class.php";
/**
 * Class DislikesManager
 * Manage the like
 */
class DislikesManager extends Model {
    /**
     * @var array Dislikes user
     */
    private $dislikes = array();

    /**
     * @param int $id id post
     * @return object response request SQL
     */
    public function ctrlDislike($id) {
        $req = "SELECT * FROM dislikes WHERE 
        idUsers = (:idUsers) AND idPosts = (:idPosts)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idUsers", $_SESSION['user']['idUser'],PDO::PARAM_STR);
        $stmt->bindValue(":idPosts", $id,PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch();
        $stmt->closeCursor();
        return $res;
    }

    /**
     * @param int $id post id
     * @return function response code 401
     */
    public function addDislike($id) {
        if ($_SESSION['user']['auth'] === 0) {
            return http_response_code(401);
        }

        $likes = new LikesManager;
        $dislikeExist = $this->ctrldislike($id);
        $likeExist = $likes->ctrlLike($id);

        if (!$dislikeExist) {
            if ($likeExist) {
                $likes->deleteLike($id);
            }
            $req = "INSERT INTO dislikes (idUsers, idPosts) 
            VALUES (:idUsers, :idPosts)";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":idUsers", $_SESSION['user']['idUser'],PDO::PARAM_STR);
            $stmt->bindValue(":idPosts", $id,PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
            header("Location: /post/$id");
        } else {
            $this->deleteDislike($id);
        }
    }

    /**
     * Create a request SQL for delete the like in database
     * @param int $id id post
     */
    public function deleteDislike($id) {
        $req = "DELETE FROM dislikes WHERE 
        idUsers = (:idUsers) AND idPosts = (:idPosts)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idUsers", $_SESSION['user']['idUser'],PDO::PARAM_STR);
        $stmt->bindValue(":idPosts", $id,PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
        header("Location: /post/$id");
    }

    /**
     * Return the array with all dislikes 
     * @return array dislikes users
     */
    public function getAllDislike() {
        return $this->dislikes;
    }

    /**
     * Receive the new like and append in array dislikes
     * @param object new dislikes
     */
    public function appendDislike($dislike) {
        $key = $dislike->getIdpost();
        $user = $dislike->getIdUser();

        if (array_key_exists($key, $this->dislikes)) {
            $this->dislikes[$key][] = $user;
        } else {
            $this->dislikes[$key] = array($user);
        }
    }

    /**
     * Get all likes of users, create a new instances Like and call function appenLike
     */
    public function getDislikes() {
        $req = $this->getBdd()->prepare("SELECT * FROM dislikes");
        $req->execute();
        $res = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();

        foreach($res as $dislike) {
            $newDislike = new Dislike($dislike['idUsers'],$dislike['idPosts']);
            $this->appendDislike($newDislike);
        }
    }
}