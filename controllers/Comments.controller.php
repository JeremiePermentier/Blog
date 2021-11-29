<?php
require_once "models/comment/CommentsManager.class.php";
/**
 * Class CommentsController
 * Control the comments
 */
class CommentsController {
    /**
     * @var object $commentManager
     */
    private $commentsManager;

    /**
     * construct for new instance
     */
    public function __construct()
    {
        $this->commentsManager = new CommentsManager;
        $this->commentsManager->getComments();
    }

    /**
     * Get all comments
     * @return void
     */
    public function comments() {
        $comments = $this->commentsManager->getAllComments();
    }

    /**
     * Send comment data for the function addComment in
     * the class commentsManager
     * @param $idPost post id
     * @return void 
     */
    public function sendComment($idPost) {
        $this->commentsManager->addComment($idPost);
    }

    /**
     * Send id comment for delete
     */
    public function deleteComment($id) {
        $this->commentsManager->deleteComment($id);
    }
}