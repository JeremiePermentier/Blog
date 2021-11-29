<?php
require_once "models/dislike/DislikesManager.class.php";
/**
 * Class DislikesController
 * Control the dislikes
 */
class DislikesController {
    /**
     * @var object $dislikesManager
     */
    private $dislikesManager;

    /**
     * Construct for new instance
     */
    public function __construct()
    {
        $this->dislikesManager = new DislikesManager;
        $this->dislikesManager->getAllDislike();
    }

    /**
     * Send post id
     * @param int $id post id
     * @return void
     */
    public function sendDislike($id) {
        $this->dislikesManager->addDislike($id);
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