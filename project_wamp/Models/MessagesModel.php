<?php


namespace Models;


use Database\DatabaseObject;

class MessagesModel
{

    private $dbobjet;

    /**
     * MessagesModel constructor.
     * @param DatabaseObject $dbobject
     * @param $id_user
     */
    function __construct($dbobject, $id_user)
    {
        $this->dbobjet = $dbobject;
        $request = "SELECT u.nom, u.prenom, m.sujet_msg, m.corps_msg FROM users u, messages m WHERE m.id_user_from=u.id_user AND m.id_user_to=$id_user";

        $result = $this->dbobjet->request($request);
        if (!$result) {
            $_SESSION['messages'] = false;
        } else {
            $_SESSION['messages'] = $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    function isPrivileged($id)
    {
        $request = "SELECT profil_user FROM users WHERE id_user=$id";
        $result = $this->dbobjet->request($request);
        $result = $result->fetch_array(MYSQLI_ASSOC);
        return ($result['profil_user'] === "EMPLOYE");
    }

    function send($dest, $subject, $content)
    {
        $dest = (int)$dest;
        $from = (int)$_SESSION['id_user'];

        if (!$this->isPrivileged($dest) && !$this->isPrivileged($_SESSION['id_user'])) {
            return false;
        }

        $request = "INSERT INTO messages(id_user_to,id_user_from,sujet_msg,corps_msg) VALUES (?, $from, ?, ?)";
        $stmt = $this->dbobjet->prepare($request);

        $params = array("iss", &$dest, &$subject, &$content);
        return $this->dbobjet->execute($stmt, $params, false);
    }

}