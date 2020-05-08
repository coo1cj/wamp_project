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

<div class="send">

    <form class="newmsg" method="post" action="messages.php">
        <label> Send to
            <select class="select" name="dest">
                <?php
                foreach ($_SESSION['userlist'] as $id_user => $user) {
                    if($user['id_user'] != $_SESSION['id_user']) {
                        $html = "<option value = ".$user['id_user'] .">" .$user['prenom'] ." " .$user['nom'] ."</option>\n";
                        echo $html;
                    }
                }
                ?>
            </select>
        </label>

        <input type="text" required="required" placeholder="Subject" name="subject">
        <input type="hidden" name="secure" value="<?php echo session_id(); ?>">
        <textarea name="msg" required="required" cols="40" rows="6"></textarea>
        <input type="submit">

        <?php
        if (isset($_REQUEST['success'])) echo "Message sent";
        if (isset($_REQUEST['failed'])) echo "Failed to send message";
        ?>

    </form>

</div>

<div class="messages">

    <table class="table">
        <tr class="top">
            <th>From</th>
            <th>Subject</th>
            <th>Content</th>
        </tr>

        <?php
        if($_SESSION['messages']) {
            foreach ($_SESSION['messages'] as $msg) {
                echo "<tr>";
                echo "<td>" .$msg['prenom'] ." " .$msg['nom'] ."</td>";
                echo "<td>" . htmlspecialchars($msg['sujet_msg']) ."</td>";
                echo "<td>" . htmlspecialchars($msg['corps_msg']) ."</td>";
                echo "</tr>";
            }
        }
        ?>

    </table>
</div>

</body>
</html>