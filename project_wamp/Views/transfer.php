<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transfer</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css" href="/css/header.css">
    <link rel="stylesheet" type="text/css" href="/css/transfer.css"/>

</head>
<body>

<?php require_once('header.php') ?>

<div class="center">
    <form method="post" action="/transfer.php">

        <label id="receiver"> Receiver
            <select class="list" name="receiver">
                <?php
                    foreach ($_SESSION['userlist'] as $id_user => $user) {
                        $html = "<option value = " . $user['numero_compte'] . ">" . $user['prenom'] . " " . $user['nom'] . "</option>\n";
                        if ($user['id_user'] != $_SESSION['id_user']) {
                            if(!isset($_REQUEST['id']) || $_REQUEST['id'] == $user['id_user'])
                            echo $html;
                        }
                    }
                ?>
            </select>
        </label>

        <label id="amount"> Amount
            <input type="number" name="amount" placeholder="0.0" step="0.01" min="0.0" max="<?php echo $_SESSION['solde_compte']; ?>">
        </label>

        <input type="hidden" name="secure" value="<?php echo session_id(); ?>">
        <input type="submit" value="SEND">

    </form>
</div>


</body>
</html>
