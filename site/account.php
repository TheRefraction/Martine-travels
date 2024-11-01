<?php
    include("connection.php");

    if(session_status() === PHP_SESSION_NONE) session_start();

    if (!isset($_SESSION['email'])) {
        header("Location: signin.php");
        exit();
    }

    $email = $_SESSION['email'];

    $bdd = get_dbhandle();
    $req = $bdd->prepare("SELECT First_name FROM User WHERE Email = ?");
    $req->execute([$email]);

    $userName = $req->fetch();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Martine Travels - My account</title>
        <link href ="css/style.css" rel="stylesheet">
    </head>

    <body>

        <?php include_once('header.php');?>

        <section class ="login_section">
            <h1>Welcome back <?php echo htmlspecialchars($userName['First_name']);?>! Where would you like to go?</h1>
            <br>

            <label>
                <input type="submit" name='home_ajout' value="Add a reservation" /><br>
            </label>
            <br>

            <label>
                <input type="submit" name='home_modify' value="Modify a reservation" /><br><br>
            </label>
            <br>

            <h2>Your old reservations</h2>

            <table>
                <tr>
                    <th>Destination</th>
                    <th>Duration</th>
                    <th>Price</th>
                </tr>

                <?php
                /*
                while($data = $req->fetch())
                {
                    ?>
                    <tr>
                        <td><?php echo $data["Destination_ID"]; ?></td>
                        <td><?php echo $data["Duration"]; ?></td>
                        <td><?php echo $data["Price"]; ?></td>
                    </tr>
                    <?php

                }
                */
                ?>

            </table>

        </section>
    </body>
</html>