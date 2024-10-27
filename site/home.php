


<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Martine Travels - Home</title>
    <link href ="css/style.css" rel="stylesheet">
</head>

<body>

<script src="draw_header.js"></script>


<section class ="login_section">
    <h1> Welcome to your home page</h1><br>

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

    include("connection.php");
    $user=9; //A modifier pour avoir l'user

    $bdd = get_dbhandle();

    //Acquisition of data from previous packages
    $req = $bdd->prepare("SELECT * FROM Package_User Pr INNER JOIN Package Pa ON Pr.Package_ID = Pa.ID INNER JOIN Destination De ON De.ID = Pa.Destination_ID WHERE Status = 3 AND Pr.User_ID=$user;");
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

        </tbody>
    </table>

</section>

<?php
if(isset($_POST['home_ajout'])){
    header("location:add_reservation.php");
}
?>

</body>

</html>