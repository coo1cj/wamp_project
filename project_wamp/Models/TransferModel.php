<?php


namespace Models;


use Database\DatabaseObject;

class TransferModel
{

    private $dbobject;
    public $solde_compte;
    public $numero_compte;

    /**
     * TransferModel constructor.
     * @param DatabaseObject $dboject
     * @param $id_user
     */
    function __construct($dboject, $id_user)
    {
        $this->dbobject = $dboject;
        $this->loadData($id_user);
    }

    function loadData($id_user) {
        $request = "SELECT numero_compte, solde_compte FROM users WHERE id_user = $id_user";
        $result = $this->dbobject->request($request);
        if(!$result) {
            session_destroy();
            header("location: /login.php");
            exit();
        }
        $result = $result->fetch_array(MYSQLI_ASSOC);
        $this->numero_compte = $result['numero_compte'];
        $this->solde_compte =  $result['solde_compte'];
    }

    function setSession() {
        $_SESSION['solde_compte'] = $this->solde_compte;
        $_SESSION['numero_compte'] = $this->numero_compte;
    }

    function transfer($from, $to, $amount) {
        $amount = (float)$amount;
        $amount = round($amount, 2);
        if($amount < 0) {
            return false;
        }

        $to = (int)$to;
        $from = (int)$from;

        if($from == $to) {
            return false;
        }

        $this->loadData($from);
        if($this->solde_compte < $amount) {
            return false;
        }

        $request = "UPDATE users SET solde_compte = solde_compte + ? WHERE numero_compte = ?";
        $stmt = $this->dbobject->prepare($request);

        $params = array("di", &$amount, &$to);
        $this->dbobject->startTransaction();

        if(!$this->dbobject->execute($stmt, $params, false)) {
            $this->dbobject->rollback();
            return false;
        }

        $amount = -$amount;
        $params = array("di", &$amount, &$from);
        if(!$this->dbobject->execute($stmt, $params, false)) {
            $this->dbobject->rollback();
            return false;
        }

        $this->dbobject->commit();

        return true;
    }

}