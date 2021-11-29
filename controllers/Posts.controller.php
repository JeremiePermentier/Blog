<?php
require_once "models/post/PostsManager.class.php";
require_once "models/like/LikesManager.class.php";
require_once "models/dislike/DislikesManager.class.php";
require_once "models/comment/CommentsManager.class.php";
/**
 * Class PostsController
 * Control the posts
 */
class PostsController {
    /**
     * @var object $postsManager
     * @var object $likesManager
     * @var object $dislikesManager
     * @var object $commentsManager
     */
    private $postsManager;
    private $likesManager;
    private $dislikesManager;
    private $commentsManager;

    /**
     * construct for new instance
     */
    public function __construct()
    {
        $this->likesManager = new LikesManager;
        $this->likesManager->getLikes();
        $this->dislikesManager = new dislikesManager;
        $this->dislikesManager->getDislikes();
        $this->postsManager = new PostsManager;
        $this->postsManager->getPosts();
        $this->commentsManager = new CommentsManager;
        $this->commentsManager->getComments();
    }

    /**
     * get all the posts
     * @return void
     */
    public function posts() {
        $posts = $this->postsManager->getallpost();
        require "views/home.view.php";
    }

    /**
     * get one post by id
     * @param int post id
     * @return void
     */
    public function post($id) {
        $dislikes = $this->dislikesManager->getAllDislike();
        $likes = $this->likesManager->getAllLike();
        $post = $this->postsManager->getPostById($id);
        $comments = $this->commentsManager->getAllComments();
        require "views/single_post.view.php";
    }

    /**
     * Send the post data for create a new post
     * with the function addPost of the class postManager
     * @return void
     */
    public function sendPost() {
        $this->postsManager->addPost();
    }

    /**
     * Send id post
     * @param int id post
     */
    public function updatePost($id) {
        $this->postsManager->updatePost($id);
    }

    /**
     * Send id post
     * @param int id post
     */
    public function deletePost($id) {
        $this->postsManager->deletePost($id);
    }
}