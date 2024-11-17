<header>
    <?php
        include_once('connection.php');
        if(session_status() === PHP_SESSION_NONE) session_start();

        echo "<img src=\"img/Logo_Martine.png\" alt=\"Martine travels logo\" class=\"logo\">";
        echo "<a href=index.php>Home</a>";

        if (!isset($_SESSION['email'])) {
            echo "<a href=signin.php>Sign in</a>";
        } else {

            echo "<a href=account.php>My account</a>";
            echo "<a href=settings.php>Settings</a>";
            echo "<a href=payment.php>Payment</a>";
            echo "<a href=signout.php>Sign out</a>";

            $pdo = get_dbhandle();
            if ($pdo) {
                try {
                    $stmt = $pdo->prepare("SELECT Loyalty_Points FROM User WHERE email = :email");
                    $stmt->bindParam(':email', $_SESSION['email']);
                    $stmt->execute();

                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($result) {
                        $loyaltyPoints = $result['Loyalty_Points'];
                        echo "<p>Loyalty Points: <strong>$loyaltyPoints</strong></p>";
                    } else {
                        echo "<p>Loyalty Points: <strong>0</strong></p>";
                    }
                } catch (PDOException $e) {
                    echo "<p>Error fetching loyalty points.</p>";
                }
            } else {
                echo "<p>Error connecting to the database.</p>";
            }

        }
    ?>
</header>


