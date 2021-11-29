<?php 
session_start();
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = [
        "auth" => 0,
        "role" => "visitor"
    ];
}
require_once "controllers/Users.controller.php";
require_once "controllers/Posts.controller.php";
require_once "controllers/Comments.controller.php";
require_once "controllers/Likes.controller.php";
require_once "controllers/Dislikes.controller.php";
require_once "controllers/Dashboard.controller.php";

$userController = new UsersController();
$postController = new PostsController();
$commentController = new CommentsController();
$likeController = new LikesController();
$dislikeController = new DislikesController();
$dashboardController = new DashboardController();


$url = '';
if(isset($_GET['url'])) {
    $url = explode('/', $_GET['url']);
}

if (isset($_SESSION['alert'])) {
    if (time() - $_SESSION['alert']['time'] > 1) {
        unset($_SESSION['alert']);
    }
}

try {
    if(empty($url)) {
        $postController->posts();
    } else {
        switch($url[0]) {
            case "se-connecter": require "views/signin.view.php";
            break;
            case "creer-un-compte": require "views/signup.view.php";
            break;
            case "logout": $userController->logoutUser();
            break;
            case "dashboard": {
                if (empty($url[1])) {
                    if($_SESSION['user']['auth'] === 1 && !empty($_SESSION['user']['idUser'])) {
                        if(isset($_POST['table']) && !empty($_POST['table'])) {
                            $dashboardController->getChoosenTable();
                        } elseif (!isset($_POST['table'])) {
                            $dashboardController->getDefaultDashBoard();
                        } else {
                            require "views/dashboard.view.php";
                        }
                    } else {
                        header('Location: /');
                    }
                } else if ($url[1] === "mes-informations") {
                    require "views/my-infos.view.php";
                } else if ($url[1] === "ajouter-un-post") {
                    require "views/add-post.view.php";
                } else if ($url[1] === "modifier-un-post") {
                    require "views/update-post.view.php";
                }
            }
            break;
            case "sendUsers": $userController->createUser(
                htmlspecialchars($_POST['pseudo']),
                htmlspecialchars($_POST['email']),
                htmlspecialchars($_POST['password']),
                htmlspecialchars($_POST['confirm_password'])
            );
            break;
            case "findUser": $userController->getUser(
                htmlspecialchars($_POST['email']),
                htmlspecialchars($_POST['password'])
            );
            break;
            case "updateUser": $userController->updateUser(
                htmlspecialchars($_POST['pseudo']),
                htmlspecialchars($_POST['email'])
            );
            break;
            case "add-post": $postController->sendPost();
            break;
            case "update-post": $postController->updatePost(
                htmlspecialchars($_POST['id'])
            );
            break;
            case "post": {
                if(isset($url[1]) && !empty($url[1]) && !empty($url[2])) {
                    switch($url[1]) {
                        case "update": $postController->updatePost($url[2]);
                        break;
                        case "delete": 
                            $postController->deletePost($url[2]);
                        break;
                    }
                } elseif(isset($url[1]) && !empty($url[1])) {
                    $postController->post($url[1]);
                } else {
                    header("Location: /");
                }
            }
            break;
            case "users": {
                if(isset($url[1]) && !empty($url[1]) && !empty($url[2])) {
                    switch($url[1]) {
                        case "delete": $userController->deleteUser($url[2]);
                        break;
                    }
                } else {

                }
            }
            break;
            case "like": $likeController->sendLike($url[1]);
            break;
            case "dislike": $dislikeController->sendDislike($url[1]);
            break;
            case "comment": {
                if (isset($url[1]) && !empty($url[1]) && !empty($url[2])) {
                    switch($url[1]) {
                        case "delete": $commentController->deleteComment($url[2]);
                        break;
                    }
                } else {
                    $commentController->sendComment($url[1]);
                }
            }
            break;
            default : throw new Exception("La page n'existe pas");
        }
    }
} catch(Exception $e) {
    $error = $e->getMessage();
    http_response_code(404);
    require "views/error.view.php";
}