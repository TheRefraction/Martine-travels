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

    <label>
        <input type="submit" name='home_ajout' value="Add a reservation" /><br>
    </label><br>
    <label>
        <input type="submit" name='home_modify' value="Modify a reservation" /><br><br>
    </label><br>

    <h2>Your old reservations</h2>

    <?php
    /*
    $userid=3 ; //Ici mettre l'id de l'user de la page


    $servername = "localhost";
    $username = "root";
    $password = "";

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";

    //Connect to date base
    ////$bdd = new PDO("mysql:host=localhost;dbname=martine_travels;charset=utf8", "root", "");

    //Acquisition of data from previous packages
    //$req = $bdd->prepare("SELECT * FROM `previouspackage` Pr INNER JOIN 'package' Pa ON Pr.Package_ID = Pa.ID;");
    //$req->execute();
    */
    ?>

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