<?php
/**
 * Class User
 */
class User {
    /**
     * @var $id id user
     * @var $pseudo username
     * @var $email user email
     * @var $password user password
     * @var $img_url user image
     */
    private $id;
    private $pseudo;
    private $email;
    private $password;
    private $url_image;

    public function __construct($id,$pseudo,$email,$password,$url_image)
    {
        $this->id = $id;
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->password = $password;
        $this->url_image = $url_image;
    }

    /**
     * @return int id user
     */
    public function getId(){return $this->id;}
    /**
     * @return string username
     */
    public function getPseudo(){return $this->pseudo;}
    /**
     * @return string user email
     */
    public function getEmail(){return $this->email;}
    /**
     * @return string user password
     */
    public function getPassword(){return $this->password;}
    /**
     * @return string url image
     */
    public function getUrl_image(){return $this->url_image;}

}