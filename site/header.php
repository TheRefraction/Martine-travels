<header>
    <?php
        if(session_status() === PHP_SESSION_NONE) session_start();

        echo "<img src=\"img/Logo_Martine.png\" alt=\"Martine travels logo\" class=\"logo\">";
        echo "<a href=index.php>Home</a>";

        if (!isset($_SESSION['email'])) {
            echo "<a href=signin.php>Sign in</a>";
        } else {
            echo "<a href=account.php>My account</a>";
            echo "<a href=settings.php>Settings</a>";
            echo "<a href=signout.php>Sign out</a>";
            echo "<a href=payment.php>Payment</a>";
        }
    ?>
</header>