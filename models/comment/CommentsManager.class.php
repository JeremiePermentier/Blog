<?php
require_once "./models/Model.class.php";
require_once "Comment.class.php";
/**
 * Class CommentsManager
 * Manage the Comment
 */
class CommentsManager extends Model {
    /**
     * @var array 
     */
    private $comments = array();

    /**
     * @param string $comment user created comment
     * @return bool
     * checks if the comment respects the number
     * of characters requested
     */
    public function ctrlData($comment) {

        if (strlen($comment) < 4 || strlen($comment) > 200) {
            $_SESSION['alert'] = [
                "type" => "error",
                "msg" => "Le commentaire ne respecte pas le nombre de caractères attendu",
                'time' => time()
            ];
            return false;
        }
        return true;
    }

    /**
     * @param $idPost
     * @return function redirect
     * Create a request SQL for insert comment
     */
    public function addComment($idPost) {
        $comment = htmlentities($_POST['message']);
        $ctrl = $this->ctrlData($comment);

        if ($ctrl === true) {
            $req = "INSERT INTO comments (comment, idPost, idUser)
            VALUES (:comment, :idPost, :idUser)";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":comment", $comment,PDO::PARAM_STR);
            $stmt->bindValue(":idPost", $idPost,PDO::PARAM_STR);
            $stmt->bindValue(":idUser", $_SESSION['user']['idUser'],PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
        }
        header("Location: /post/$idPost");

    }

    /**
     * @return array $comments
     */
    public function getAllComments() {
        return $this->comments;
    }

    /**
     * @param $id idComment
     * @return object res SQL
     */
    public function getCommentById($id) {
        $req = "SELECT comments.idUser FROM comments WHERE idComment = :idComment";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue("idComment",$id,PDO::PARAM_STR);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->execute();
        $stmt->closeCursor();
        return $res['idComment'];
    }

    /**
     * @param $id idComment
     * @return function redirect
     * Create a request SQL for delete a comment
     */
    public function deleteComment($id) {
        $idUser = $this->getCommentById($id);

        if($idUser === $_SESSION['user']['userId']) {
            $req = "DELETE FROM comments WHERE
            idComment = (:idComment)";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue("idComment", $id,PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
        }
        return header("Location: /dashboard");
    }

    /**
     * @return void
     * get all the comments from the database
     * then create new instances
     */
    public function getComments() {
        $req = $this->getBdd()->prepare(
            "SELECT idComment, comment, 
            idPost, comments.idUser, pseudo
            FROM comments INNER JOIN users
            ON comments.idUser = users.idUser
            ORDER BY idComment DESC;"
            );
        $req->execute();
        $res = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();

        foreach($res as $comment) {
            $newComment = new Comment(
                $comment['idComment'],
                $comment['comment'],
                $comment['idPost'],
                $comment['idUser'],
                $comment['pseudo']
            );
            $this->appendComment($newComment);
        }
    }

    /**
     * @param $newComment new instance
     * @return void
     * add the new instance in array $comments
     */
    public function appendComment($comment) {
        $key = $comment->getIdPost();
        if (array_key_exists($key, $this->comments)) {
            $this->comments[$key][] = $comment;
        } else {
            $this->comments[$key] = array($comment);
        }
    }

}