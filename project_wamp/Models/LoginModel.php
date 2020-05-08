<?php


namespace Models;


use Database\DatabaseObject;

class LoginModel
{

    /** @var DatabaseObject $dbobject */
    private $dbobject;

    function __construct($dbobject)
    {
        $this->dbobject = $dbobject;
    }

    /**
     * @param string $login
     * @param string $pwd
     * @param bool $hash
     * @return bool
     */
    function login($login, $pwd, $hash = false)
    {

        if ($hash) {
            $pwd = hash("sha3-256", $pwd);
        }

        $request = "SELECT id_user, profil_user FROM users WHERE login=? AND mot_de_passe=?";
        $params = array("ss", $login, $pwd);
        $stmt = $this->dbobject->prepare($request);
        $result = $this->dbobject->execute($stmt, $params);

        if (!$result) {
            return false;
        }

        $result = $result->fetch_assoc();
        $_SESSION["id_user"] = $result["id_user"];
        $_SESSION["privileged"] = ($result["profil_user"] === "EMPLOYE");

        return true;
    }

}