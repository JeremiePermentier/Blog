<?php
/**
 * Class Dislike
 * Manage the Dislike
 */
class Dislike {
    /**
     * @var $idUsers id user
     * @var $idPosts id post
     */
    private $idUsers;
    private $idPosts;

    public function __construct($idUsers,$idPosts)
    {
        $this->idUsers = $idUsers;
        $this->idPosts = $idPosts;
    }

    /**
     * @return int id user
     */
    public function getIdUser(){return $this->idUsers;}
    /**
     * @return int id user
     */
    public function getIdpost(){return $this->idPosts;}
}