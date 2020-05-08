<?php

use \Database\DatabaseObject;
use Models\LoginModel;
use Models\MessagesModel;
use Models\TransferModel;
use Models\UserlistModel;
use Models\UserModel;

require_once "Database/DatabaseObject.php";
require_once "Models/LoginModel.php";
require_once "Models/UserModel.php";
require_once "Models/UserlistModel.php";
require_once "Models/TransferModel.php";
require_once "Models/MessagesModel.php";

ini_set('session.cookie_httponly', 1);
session_start();

$dbobject = new DatabaseObject("config/config.ini");

$url = strtok($_SERVER["REQUEST_URI"], '?');


/*** UNLOGGED ACTIONS ***/

if ($url === "/login.php") {
    if(isset($_SESSION['id_user'])) {
        header("Location: /index.php");
        exit();
    }

    if (empty($_REQUEST['login']) || empty($_REQUEST['pwd'])) {
        require("Views/login.php");
        exit();
    }

    $loginModel = new LoginModel($dbobject);
    if ($loginModel->login($_REQUEST['login'], $_REQUEST['pwd'])) {
        header("Location: /index.php");
        exit();
    } else {
        header("Location: /login.php?failed");
        exit();
    }
}

if (!isset($_SESSION['id_user'])) { // user is not connected
    header("Location: /login.php?forbidden");
    exit();
}

/*** LOGGED ACTIONS ***/

if($url === "/disconnect") {
    session_destroy();
    header("Location: /login.php?disconnected");
    exit();
}

if($url === "/index.php") {
    $userModel = new UserModel($dbobject, $_SESSION['id_user']);
    $userModel->setSession();
    require("Views/index.php");
    exit();
}

if($url === "/transfer.php") {
    $userlistModel = new UserlistModel($dbobject);
    $transferModel = new TransferModel($dbobject, $_SESSION['id_user']);
    $transferModel->setSession();

    if(isset($_REQUEST['receiver']) && $_SERVER['REQUEST_METHOD'] != "POST") {
        header("Location: /transfer.php?failed");
        exit();
    }

    if(!empty($_REQUEST['receiver']) && !empty($_REQUEST['amount'])) {
        if(!isset($_REQUEST['secure']) || $_REQUEST['secure'] != session_id()) {
            header("location: /transfer.php?failed");
            exit();
        }

        if($transferModel->transfer($_SESSION['numero_compte'], $_REQUEST['receiver'], $_REQUEST['amount'])) {
            header("location: /transfer.php?success");
            exit();
        } else {
            header("location: /transfer.php?failed");
            exit();
        }
    }

    require("Views/transfer.php");
    exit();
}

if($url === "/messages.php") {
    $messageModel = new MessagesModel($dbobject, $_SESSION['id_user']);
    $userlistModel = new UserlistModel($dbobject, $_SESSION['privileged']);

    if(!empty($_REQUEST['dest']) && !empty($_REQUEST['subject']) && !empty($_REQUEST['msg'])) {
        if(!isset($_REQUEST['secure']) || $_REQUEST['secure'] != session_id()) {
            require("Views/messages.php");
            header("location: /messages.php");
            exit();
        }

        if($messageModel->send($_REQUEST['dest'], $_REQUEST['subject'], $_REQUEST['msg'])) {
            require("Views/messages.php");
            header("location: /messages.php?success");
            exit();
        } else {
            require("Views/messages.php");
            header("location: /messages.php?failed");
            exit();
        }
    }
    require("Views/messages.php");
    exit();
}

if(!$_SESSION["privileged"]) {
    header("location: /index.php");
    exit();
}

/*** PRIVILEGED ACTIONS ***/

if($url === "/userlist.php") {
    $userlistModel = new UserlistModel($dbobject, true);
    $userlistModel->setSession();

    if(isset($_REQUEST['id'])) {
        $userModel = new UserModel($dbobject, $_REQUEST['id']);
        if(!$userModel->userdata) {
            header("location: /userlist.php");
            exit();
        }

        $userModel->setSession(false);
    }

    require("Views/userlist.php");
    exit();
}

include "Views/index.php";
//header("Location: /index.php");

