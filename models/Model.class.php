<?php
/**
 * Class Model
 * Allows you to generate a connection with the SQL database
 */
abstract class Model {
    /**
     * @var $pdo Declare a property to store the connection
     */
    private static $pdo;

    /**
     * Create a new connexion
     */
    private static function setBdd() {
        self::$pdo = new PDO("mysql:host=localhost;dbname=blog;charset=utf8","root","");
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    }

    /**
     * @return new instances
     */
    protected function getBdd() {
        if(self::$pdo === null){
            self::setBdd();
        }
        return self::$pdo;
    }
}