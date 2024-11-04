<?php
    include("connection.php");

    if(session_status() === PHP_SESSION_NONE) session_start();

    if (!isset($_SESSION['email'])) {
        header("Location: signin.php");
        exit();
    }

    $email = $_SESSION['email'];

    $bdd = get_dbhandle();
    $req = $bdd->prepare("SELECT First_name, ID FROM User WHERE Email = ?");
    $req->execute([$email]);

    $data = $req->fetch();
    $userName = $data['First_name'];
    $userID = $data['ID'];
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
            <h1>Welcome back <?php echo htmlspecialchars($userName);?>! Where would you like to go?</h1>
            <br>

            <form method="post" action="add_reservation.php">
                <label>
                    <input type="submit" name='home_ajout' value="Add a reservation" /><br>
                </label><br>

            </form>

            <form method="post" action="modify_reservation.php">
                <label>
                    <input type="submit" name='home_modify' value="Modify a reservation" /><br><br>
                </label><br>

                <h2>Your old reservations</h2>

                <?php


                //Acquisition of data from previous packages
                $req = $bdd->prepare("SELECT * FROM Package_User Pr INNER JOIN Package Pa ON Pr.Package_ID = Pa.ID INNER JOIN Destination De ON De.ID = Pa.Destination_ID WHERE Status = 3 AND Pr.User_ID=$userID;");
                $req->execute();

                ?>

                <table class="table_design">
                    <thead>
                    <tr>
                        <th>Destination</th>
                        <th>Duration</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    while($data = $req->fetch())
                    {
                        ?>
                        <tr>
                            <td><?php echo $data["Name"]; ?></td>
                            <td><?php echo $data["Duration"]; ?> days</td>
                            <td><?php echo $data["Price"]; ?>€</td>
                        </tr>
                        <?php

                    }

                    ?>

            </table>

        </section>
    </body>
</html>