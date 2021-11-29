<?php
require_once "./models/Model.class.php";
require_once "Dashboard.class.php";
/**
 * Class DashboardManager
 * Manage the dashboard
 */
class DashboardManager extends Model {
    /**
     * @var array $tables
     */
    private $table;

    /**
     * @param string $tables table chosen by the user
     * @return object returns the result of the SQL query,
     * which are the columns chosen by the user
     */
    public function getCol($tables) {
        $sql = "SHOW COLUMNS FROM";

        switch ($tables) {
            case "users":
                $sql .= " users";
                $_SESSION['action'] = "users";
            break;
            case "posts":
                $sql .= " posts";
                $_SESSION['action'] = "post";
            break;
            case "users-posts":
                $sql .= " posts";
                $_SESSION['action'] = "post";
            break;
            case "users-comments":
                $sql .= " comments";
                $_SESSION['action'] = "comment";
            break;
            case "comment":
                $sql .= " comments";
                $_SESSION['action'] = "comment";
            break;
        }

        $req = $this->getBdd()->query($sql);
        $req->execute();
        $res = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $res;
    }   

    /**
     * @param string $tables table chosen by the user
     * @return object returns the result of the SQL query
     * which are the data chosen by the user
     */
    public function getDatas($tables) {
        $user = $_SESSION['user']['idUser'];
        $sql = "SELECT * FROM";

        switch ($tables) {
            case "users":
                $sql .= " users";
            break;
            case "posts":
                $sql .= " posts WHERE idUsers = $user";
            break;
            case "comment":
                $sql .= " comments WHERE idUser = $user ";
            break;
            case "users-posts":
                $sql .= " posts";
            break;
            case "users-comments":
                $sql .= " comments";
            break;
        }
        $req = $this->getBdd()->query($sql);
        $req->execute();
        $res = $req->fetchAll(PDO::FETCH_NUM);
        $req->closeCursor();
        return $res;
    }

    /**
     * @param string $tables table chosen by the user
     * @return array return an array with the actions available
     */
    public function getActions($tables) {
        $actions = [];

        switch ($tables) {
            case "users":
                $actions = ["Supprimer"];
            break;
            case "posts":
                $actions = ["Modifier", "Supprimer"];
            break;
            case "comment":
                $actions = ["Supprimer"];
            break;
            case "users-posts":
                $actions = ["Supprimer"];
            break;
            case "users-comments":
                $actions = ["Supprimer"];
            break;
        }
        return $actions;
    }

    /**
     * @param string $table table chosen by the user
     * retrieve the various information necessary 
     * for the creation of a new instance
     */
    public function getAllData($table) {
        $cols = $this->getCol($table);
        $datas = $this->getDatas($table);
        $actions = $this->getActions($table);

        $newTable = new Dashboard($cols,$datas,$actions);
        $this->appendTable($newTable);
    }

    /**
     * @param $newTable new instance
     * add the new instance, in the property
     * $table which is an array
     */
    public function appendTable($newTable) {
        unset($this->table);
        $this->table[] = $newTable;
    }

    /**
     * @return array returns the $table property
     */
    public function getDashBoard() {
        return $this->table;
    }

}