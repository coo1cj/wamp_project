<?php

namespace Database;

use mysqli;
use mysqli_result;
use mysqli_stmt;

/**
 * Database manage the connexion and the requests with the db
 * @package Database
 */
class DatabaseObject
{

    /**
     * @var mysqli $mysqli
     * @var mysqli_stmt[] $statements
     */
    public $mysqli;
    private $statements;

    function __construct($inifile)
    {
        $connection = parse_ini_file($inifile);
        $this->mysqli = new mysqli($connection["DB_HOST"], $connection["DB_USER"], $connection["DB_PASSWD"], $connection["DB_NAME"]);

        if($err = $this->mysqli->connect_error) {
            die("Failed to connect to DB : ". $err);
        }

        $this->statements = array();
    }

    function prepare($request) {

        $stmt = $this->mysqli->stmt_init();
        if(!$stmt->prepare($request)) {
            die("Failed to prepare statement");
        }

        $this->statements[] = $stmt;
        return $stmt;
    }

    function escape($str) {
        return $this->mysqli->real_escape_string($str);
    }

    /**
     * @param mysqli_stmt $stmt
     * @param array|false $params
     * @param bool $read
     * @return bool|mysqli_result
     */
    function execute($stmt, $params, $read = true) {
        if ($params) {
            $stmt->bind_param(...$params);
        }

        $success = $stmt->execute();
        if(!$success) {
            echo $stmt->error;
            return false;
        }

        $result = $stmt->get_result();

        if($stmt->affected_rows <= 0) {
            return false;
        }

        if($read) {
            return $result;
        } else {
            return true;
        }
    }

    function startTransaction() {
        $this->mysqli->begin_transaction();
    }

    function rollback() {
        $this->mysqli->rollback();
    }

    function commit() {
        $this->mysqli->commit();
    }

    function request($request, $ret = true) {
        $stmt = $this->prepare($request);
        return $this->execute($stmt, false, $ret);
    }

    function __destruct()
    {
        foreach ($this->statements as $stmt) {
            $stmt->close();
        }

        $this->mysqli->close();
    }

}