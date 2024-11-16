<header>
    <?php
    if(session_status() === PHP_SESSION_NONE) session_start();

    echo "<img src=\"../img/Logo_Martine.png\" alt=\"Martine travels logo\" class=\"logo\">";


    if (!isset($_SESSION['email'])) {
        echo "<a href=../signin.php>Sign in</a>";
    } else {
        echo "<a href=admin.php>Manage</a>";
        echo "<a href=../signout.php>Sign out</a>";
    }
    ?>
</header>