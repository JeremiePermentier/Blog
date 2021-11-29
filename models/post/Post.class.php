<?php
/**
 * Class Post
 */
class Post {
    /**
     * @var $id post id
     * @var $idUser ID user
     * @var $pseudo username
     * @var $title title post
     * @var $post message post
     * @var $url_image image post
     */
    private $id;
    private $idUser;
    private $pseudo;
    private $title;
    private $post;
    private $url_image;

    public function __construct($id,$idUser,$pseudo,$title,$post,$url_image)
    {
        $this->id = $id;
        $this->idUser = $idUser;
        $this->pseudo = $pseudo;
        $this->title = $title;
        $this->post = $post;
        $this->url_image = $url_image;
    }

    /**
     * @return int id post
     */
    public function getId(){return $this->id;}
    /**
     * @return int id user
     */
    public function getIduser(){return $this->idUser;}
    /**
     * @return string username
     */
    public function getPseudo(){return $this->pseudo;}
    /**
     * @return string title post
     */
    public function getTitle(){return $this->title;}
    /**
     * @return string message post
     */
    public function getPost(){return $this->post;}
    /**
     * @return string url image
     */
    public function getUrl_image(){return $this->url_image;}

}