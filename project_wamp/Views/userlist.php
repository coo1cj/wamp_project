<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transfer</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css" href="/css/header.css">
    <link rel="stylesheet" type="text/css" href="/css/messages.css"/>

</head>
<body>

<?php require_once('header.php') ?>

<div class="user">

    <?php if(isset($_REQUEST['id']) && $_SESSION['user' . $_REQUEST['id']]['profil_user'] === 'CLIENT') : ?>
    <?php $uid = $_REQUEST['id']; ?>

    <div class="center">
        <form>
            <p>ID : <?php echo $_SESSION['user' . $uid]['id_user'] ?></p>
            <p>login : <?php echo $_SESSION['user' . $uid]['login'] ?></p>
            <p>Profil : <?php echo $_SESSION['user' . $uid]['profil_user'] ?></p>
            <p>Lastname : <?php echo $_SESSION['user' . $uid]['nom'] ?></p>
            <p>Firstname : <?php echo $_SESSION['user' . $uid]['prenom'] ?></p>
            <p>Account n° : <?php echo $_SESSION['user' . $uid]['numero_compte'] ?></p>
            <p>Balance : <?php echo $_SESSION['user' . $uid]['solde_compte'] ?></p>
        </form>
    </div>

    <?php endif; ?>

</div>

<div class="messages">

    <table class="table">
        <tr class="top">
            <th>ID</th>
            <th>Name</th>
            <th>Access</th>
            <th>Transfer</th>
        </tr>

        <?php
        if ($_SESSION['userlist']) {
            foreach ($_SESSION['userlist'] as $user) {
                if($user['profil_user'] != 'CLIENT') {
                    continue;
                }
                echo "<tr>";
                echo "<td>" . $user['id_user'] . "</td>";
                echo "<td>" . $user['prenom'] . " " . $user['nom'] . "</td>";
                echo "<td> <a href='userlist.php?id=". $user['id_user'] . "'> SHOW </a> </td>";
                echo "<td> <a href='transfer.php?id=". $user['id_user'] . "'> TRANSFER </a> </td>";
                echo "</tr>";
            }
        }
        ?>

    </table>


</div>

</body>
</html>
