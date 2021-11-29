<?php 
/**
 * Class Comment
 * Manage the comment
 */
class Comment {
    /**
     * @var $id id comment
     * @var $comment comment message
     * @var $idPost id post
     * @var $idUser is user
     * @var $pseudo username
     */
    private $id;
    private $comment;
    private $idPost;
    private $idUser;
    private $pseudo;

    public function __construct($id,$comment,$idPost,$idUser,$pseudo)
    {
        $this->id = $id;
        $this->comment = $comment;
        $this->idPost = $idPost;
        $this->idUser = $idUser;
        $this->pseudo = $pseudo;
    }

    /**
     * @return int id comment
     */
    public function getId(){return $this->id;}
    /**
     * @return string comment message
     */
    public function getComment(){return $this->comment;}
    /**
     * @return int id post
     */
    public function getIdPost(){return $this->idPost;}
    /**
     * @return int id user
     */
    public function getIdUser(){return $this->idUser;}
    /**
     * @return string username
     */
    public function getPseudo(){return $this->pseudo;}
}