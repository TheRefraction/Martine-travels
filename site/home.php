<?php
session_start();
include("connection.php");
if (!isset($_SESSION['email'])) {
    header("Location: signin.html");
    exit();
}


$email = $_SESSION['email'];

$bdd = get_dbhandle();
$req = $bdd->prepare("SELECT First_name FROM User WHERE Email = ?");
$req->execute([$email]);
$userName = $req->fetch();


//Acquisition of data from previous packages
//$req = $bdd->prepare("SELECT * FROM `previouspackage` Pr INNER JOIN 'package' Pa ON Pr.Package_ID = Pa.ID;");
//$req->execute();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Martine Travels - Home</title>
    <link href ="css/style.css" rel="stylesheet">
</head>

<body>

<script src="draw_header.js"></script>


<section class ="login_section">

    <h1>Welcome back <?php echo htmlspecialchars($userName['First_name']);?> ! What do you want to do today?</h1>

    <label>
        <a href=settings.php>Settings</a>
        <br>
    </label> <br>
    <label>
        <input type="submit" name='home_ajout' value="Add a reservation" /><br>
    </label><br>
    <label>
        <input type="submit" name='home_modify' value="Modify a reservation" /><br><br>
    </label><br>

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