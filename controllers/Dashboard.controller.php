<?php
require_once "models/dashboard/DashboardManager.class.php";
/**
 * Class DashboardController
 * Control the dashboard
 */
class DashboardController {
    /**
     * @var object $dashboardManager
     */
    private $dashboardManager;

    /**
     * construct for new instance
     */
    public function __construct()
    {
        $this->dashboardManager = new DashboardManager;
        if (isset($_SESSION['user']['idUser']) && !empty($_SESSION['user']['idUser'])) {
            $this->dashboardManager->getAllData("posts");
        }
    }

    /**
     * Send the taable choosen
     */
    public function getChoosenTable() {
        $this->dashboardManager->getAllData($_POST["table"]);
        $table = $this->dashboardManager->getDashBoard();
        require "views/dashboard.view.php";
    }

    /**
     * Function for init the dashboard
     */
    public function getDefaultDashBoard() {
        $table = $this->dashboardManager->getDashBoard();
        require "views/dashboard.view.php";
    }
}