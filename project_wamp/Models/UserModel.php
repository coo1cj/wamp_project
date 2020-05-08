<?php


namespace Models;


use Database\DatabaseObject;

/**
 * UserModel represents a user
 * @package Models
 */
class UserModel
{
    public $id_user;

    /** @var array */
    public $userdata;


    /** @var DatabaseObject $dbobject */
    private $dbobject;

    /**
     * @param DatabaseObject $dbobject
     * @param int $id
     */
    function __construct($dbobject, $id)
    {
        $this->dbobject = $dbobject;
        if(!$this->userdata = $this->pull($id)) {
            return false;
        }
    }

    public function pull($id) {
        $request = "SELECT * FROM users WHERE id_user=$id";
        $result =  $this->dbobject->request($request);

        if($result) {
            return $result->fetch_array();
        } else {
            return false;
        }

    }

    function setSession($self = true) {
        if($self) {
            $_SESSION['user'] = $this->userdata;
        } else {
            $_SESSION['user' . $this->userdata['id_user']] = $this->userdata;
        }

    }

}