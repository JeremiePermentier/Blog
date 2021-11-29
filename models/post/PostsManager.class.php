<?php
require_once "./models/Model.class.php";
require_once "Post.class.php";
/**
 * Class PostManager
 * Manage the post
 */
class PostsManager extends Model {
    /**
     * @var array $posts 
     */
    private $posts;

    /**
     * @return string url_image
     * @return function redirect
     */
    public function getImage() {
        $path = "./public/img/";
        $img_url = basename($_FILES['file']['name']);
        if (isset($_FILES['file'])) {
            if($_FILES['file']['size'] >= 6000000) {
                $_SESSION['alert'] = [
                    "type" => "error",
                    "msg" => "L'image est trop lourde",
                    'time' => time()
                ];
                return header("Location: dashboard/ajouter-un-post");
            } else {
                move_uploaded_file($_FILES['file']['tmp_name'], $path . $img_url);
                return $img_url;
            }
        } else {
            $_SESSION['alert'] = [
                "type" => "error",
                "msg" => "problème lors du transfert",
                'time' => time()
            ];
            return header("Location: dashboard/ajouter-un-post");
        }
    }

    /**
     * @return bool 
     * @return function
     */
    public function ctrlData() {
        if (isset($_POST)) {
            switch($_POST) {
                case strlen($_POST['title']) < 5 || strlen($_POST['title']) > 25:
                    $_SESSION['alert'] = [
                        "type" => "error",
                        "msg" => "Le titre ne respecte pas le nombre de caractère attendu",
                        'time' => time()
                    ];
                    return header("Location: dashboard/ajouter-un-post");
                break;
                case strlen($_POST['message']) < 10 || strlen($_POST['message']) > 400:
                    $_SESSION['alert'] = [
                        "type" => "error",
                        "msg" => "Le message ne respecte pas le nombre de caractère attendu",
                        'time' => time()
                    ];
                    return header("Location: dashboard/ajouter-un-post");
                break;
                default : return true;
            }
        }
    }

    /**
     * @return function
     */
    public function addPost() {
        $ctrl = $this->ctrlData();

        if ($ctrl === true) {
            $img_url = $this->getImage();
            $req = "INSERT INTO posts (idUsers,title,post,url_image)
            VALUES (:idUsers,:title,:post,:url_image)";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":idUsers",htmlspecialchars($_SESSION['user']['idUser']),PDO::PARAM_STR);
            $stmt->bindValue(":title",htmlspecialchars($_POST['title']),PDO::PARAM_STR);
            $stmt->bindValue(":post",htmlspecialchars($_POST['message']),PDO::PARAM_STR);
            $stmt->bindValue(":url_image",htmlspecialchars($img_url),PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
            $_SESSION['alert'] = [
                "type" => "success",
                "msg" => "Le post à bien été ajouté",
                'time' => time()
            ];
        }
        return header("Location: dashboard/ajouter-un-post");
    }

    /**
     * @param int $id post id
     * @return void
     */
    public function deleteImage($id) {
        $req = "SELECT url_image FROM posts WHERE posts.idPosts = :id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(':id',htmlspecialchars($id),PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        unlink('./public/img/' . $res['url_image']);
        $stmt->closeCursor();
    }

    /**
     * @param int $id post id
     * @return function redirect header
     */
    public function deletePost($id) {
        $idUser = $this->getPostById($id);

        if ($idUser->getIduser() === $_SESSION['user']['idUser']) {
            $this->deleteImage($id);
            $req = "DELETE FROM posts WHERE posts.idPosts = :id";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":id",htmlspecialchars($id),PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
            $_SESSION['alert'] = [
                "type" => "success",
                "msg" => "Votre message à bien été supprimer",
                'time' => time()
            ];
        } else {
            $_SESSION['alert'] = [
                "type" => "error",
                "msg" => "Vous n'êtes pas autorisez à supprimer ce message",
                'time' => time()
            ];
        }
        return header("Location: /dashboard");
    }

    /**
     * @return function redirect header
     */
    public function updatePost() {
        $idUser = $this->getPostById($_POST['id']);

        if ($idUser->getIduser() === $_SESSION['user']['idUser']) {
            $ctrl = $this->ctrlData();
            if (isset($_FILES['file']['name']) && !empty($_FILES['file']['name']) && $ctrl === true) {
                $this->deleteImage($_POST['id']);
                $img_url = $this->getImage();
                $req = "UPDATE posts SET title = :title,post = :post, url_image = :url_image WHERE idPosts = :id";
                $stmt = $this->getBdd()->prepare($req);
                $stmt->bindValue(':url_image',$img_url,PDO::PARAM_STR);
            } else if ($ctrl === true){
                $req = "UPDATE posts SET title = :title,post = :post WHERE idPosts = :id";
                $stmt = $this->getBdd()->prepare($req);
            }
            $stmt->bindValue(':title',htmlspecialchars($_POST['title']),PDO::PARAM_STR);
            $stmt->bindValue(':post',htmlspecialchars($_POST['message']),PDO::PARAM_STR);
            $stmt->bindValue(':id',htmlspecialchars($_POST['id']),PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
            $_SESSION['alert'] = [
                "type" => "success",
                "msg" => "Le message à bien été modifié",
                'time' => time()
            ];
        } else  {
            $_SESSION['alert'] = [
                "type" => "error",
                "msg" => "Vous n'êtes pas autorisez à modifier ce message",
                'time' => time()
            ];
        }
        return header("Location: dashboard");
    }

    /**
     * Search the post in array with post id 
     * @param int $id post id
     * @return object post
     */
    public function getPostById($id) {
        for($i=0; $i < count($this->posts); $i++) {
            if($this->posts[$i]->getId() === $id) {
                return $this->posts[$i];
            }
        }
    }

    /**
     * @param instance $post
     * @return void
     */
    public function appendPost($post) {
        $this->posts[] = $post;
    }

    /**
     * @return array return all posts
     */
    public function getallpost() {
        return $this->posts;
    }

    /**
     * Create a request SQL for get all the posts
     */
    public function getPosts() {
        $req = $this->getBdd()->prepare(
            "SELECT idPosts, idUsers, title, post, url_image, users.pseudo 
            FROM posts INNER JOIN users ON posts.idUsers = users.idUser;"
        );
        $req->execute();
        $res = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        
        foreach($res as $post) {
            $newPost = new Post(
                $post['idPosts'],
                $post['idUsers'],
                $post['pseudo'],
                $post['title'],
                $post['post'],
                $post['url_image']
            );
            $this->appendPost($newPost);
        }
    }
}