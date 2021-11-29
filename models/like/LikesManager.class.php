<?php
require_once "./models/Model.class.php";
require_once "Like.class.php";
require_once "./models/dislike/DislikesManager.class.php";
/**
 * Class LikesManager
 * Manage the like
 */
class LikesManager extends Model {
    /**
     * @var array Likes user
     */
    private $likes = array();

    /**
     * @param int $id id post
     * @return object response request SQL
     */
    public function ctrlLike($id) {
        $req = "SELECT * FROM likes WHERE 
        idUsers = (:idUsers) AND idPosts = (:idPosts)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idUsers", $_SESSION['user']['idUser'],PDO::PARAM_STR);
        $stmt->bindValue(":idPosts", $id,PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $res;
    }

    /**
     * @param int $id post id
     * @return function response code 401
     */
    public function addLike($id) {
        if ($_SESSION['user']['auth'] === 0) {
            return http_response_code(401);
        }

        $dislikes = new DislikesManager;
        $likeExist = $this->ctrlLike($id);
        $dislikeExist = $dislikes->ctrlDislike($id);


        if (!$likeExist) {
            if ($dislikeExist) {
                $dislikes->deleteDislike($id);
            }
            $req = "INSERT INTO likes (idUsers, idPosts) 
            VALUES (:idUsers, :idPosts)";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":idUsers", $_SESSION['user']['idUser'],PDO::PARAM_STR);
            $stmt->bindValue(":idPosts", $id,PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
            header("Location: /post/$id");
        } else {
            $this->deleteLike($id);
        }
    }

    /**
     * Create a request SQL for delete the like in database
     * @param int $id id post
     */
    public function deleteLike($id) {
        $req = "DELETE FROM likes WHERE 
        idUsers = (:idUsers) AND idPosts = (:idPosts)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idUsers", $_SESSION['user']['idUser'],PDO::PARAM_STR);
        $stmt->bindValue(":idPosts", $id,PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
        header("Location: /post/$id");
    }

    /**
     * Return the array with all likes 
     * @return array likes users
     */
    public function getAllLike() {
        return $this->likes;
    }

    /**
     * Receive the new like and append in array likes
     * @param object new like
     */
    public function appendLike($like) {
        $key = $like->getIdpost();
        $user = $like->getIdUser();
        if (array_key_exists($key, $this->likes)) {
            $this->likes[$key][] = $user;
        } else {
            $this->likes[$key] = array($user);
        }
    }

    /**
     * Get all likes of users, create a new instances Like and call function appenLike
     */
    public function getLikes() {
        $req = $this->getBdd()->prepare("SELECT * FROM likes");
        $req->execute();
        $res = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();

        foreach($res as $like) {
            $newLike = new Like($like['idUsers'],$like['idPosts']);
            $this->appendLike($newLike);
        }
    }
}