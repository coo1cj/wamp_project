<header class="golbal-header">

    <div class="menus">
        <a class="divleft" href="/index.php">
            <i class="material-icons" style="font-size: 48px; color:orange;align-self: center;">local_atm</i>
            <p class="title">MY BANK</p>
        </a>

        <a class="divleft" href="/transfer.php">
            <p class="title">TRANSFER</p>
        </a>

        <a class="divleft" href="/messages.php">
            <p class="title">MESSAGES</p>
        </a>

        <?php if (isset($_SESSION['privileged']) && $_SESSION['privileged']): ?>
            <a class="divleft" href="/userlist.php">
                <p class="title">USERS</p>
            </a>
        <?php endif; ?>

    </div>


    <div class="divright">

        <?php if (isset($_SESSION['id_user'])): ?>
            <a class="logo-right" href="/disconnect">
                <i class="material-icons" style="font-size: 48px; color:red">exit_to_app</i>
            </a>
        <?php else: ?>
            <a class="logo-right" href="/login.php">
                <p class="text-login">Login</p>
                <i class="material-icons" id="account" style="font-size: 48px">account_circle</i>
            </a>
        <?php endif; ?>

    </div>

</header>

