<?php


namespace Models;


use Database\DatabaseObject;

class UserlistModel
{

    private $dbobject;
    public $userlist;

    /**
     * TransferModel constructor.
     * @param DatabaseObject $dboject
     * @param bool $everyone
     */
    function __construct($dboject, $everyone = true)
    {
        $this->dbobject = $dboject;
        $this->userlist = $this->getList($everyone);
        $this->setSession();
    }

    /**
     * @param bool $everyone
     */
    function getList($everyone = true) {
        $request = "SELECT id_user, nom, prenom, numero_compte, profil_user FROM users";
        if(!$everyone) {
            $request = $request ." WHERE profil_user='EMPLOYE'";
        }
        $result = $this->dbobject->request($request);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function setSession() {
        $_SESSION['userlist'] = $this->userlist;
    }



}