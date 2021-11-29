<?php
require_once "models/like/LikesManager.class.php";
/**
 * Class LikesController
 * Control the likes
 */
class LikesController {
    /**
     * @var object $likesManager
     */
    private $likesManager;

    /**
     * Construct for new instance
     */
    public function __construct()
    {
        $this->likesManager = new LikesManager;
        $this->likesManager->getLikes();
    }

    /**
     * Send post id
     * @param int $id post id
     * @return void
     */
    public function sendLike($id) {
        $this->likesManager->addLike($id);
        if (http_response_code() === 401) {
            $_SESSION['alert'] = [
                "type" => "error",
                "msg" => "Vous n'êtes pas connecter",
                'time' => time()
            ];
            header("Location: /post/$id");
        }
    }
}