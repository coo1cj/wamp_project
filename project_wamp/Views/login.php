<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css" href="/css/header.css">
    <link rel="stylesheet" type="text/css" href="/css/login.css"/>

</head>

<body>

<?php //require_once('header.php') ?>

<div id="login_frame">

    <p id="image_logo"><img src="/css/money.jpg"></p>

    <form method="post" action="/login.php">
        <input type="hidden" name="action" value="authenticate">
        <p><label class="label_input">Login</label><input type="text" required="required" name="login" class="text_field"/></p>
        <p><label class="label_input">Mot de passe</label><input type="password" required="required" name="pwd" class="text_field"/></p>
        <input type="hidden" name="token" value="<?php // echo $_SESSION['token'] ?>">
        <div id="login_control">
            <button id="btn_login">Connexion</button>
        </div>
    </form>
    <div class="wrong">
        <?php
        if (isset($_REQUEST['failed'])) echo '<p>Wrong email or password</p>';
        if (isset($_REQUEST['forbidden'])) echo '<p>You must be logged in to access this!</p>';
        ?>
    </div>
    <div><?php if (isset($_REQUEST['disconnected'])) echo '<p>You disconnected successfully</p>'; ?></div>

</div>

</body>
</html>