<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My online bank</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css" href="/css/header.css">
    <link rel="stylesheet" type="text/css" href="/css/index.css">

</head>
<body>

<?php require_once('header.php') ?>

<div class="center">
    <form>
        <p>ID : <?php echo $_SESSION['user']['id_user'] ?></p>
        <p>login : <?php echo $_SESSION['user']['login'] ?></p>
        <p>Profil : <?php echo $_SESSION['user']['profil_user'] ?></p>
        <p>Lastname : <?php echo $_SESSION['user']['nom'] ?></p>
        <p>Firstname : <?php echo $_SESSION['user']['prenom'] ?></p>
        <p>Account n° : <?php echo $_SESSION['user']['numero_compte'] ?></p>
        <p>Balance : <?php echo $_SESSION['user']['solde_compte'] ?></p>
    </form>
</div>



</body>
</html>
