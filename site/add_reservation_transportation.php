<?php
include("connection.php");

if(session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['email'])) {
    header("Location: signin.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Martine Travels</title>
    <link href ="css/style.css" rel="stylesheet">
</head>
<body>
<?php include_once('header.php');?>

<section class ="login_section">

    <h1>Transportation reservation</h1><br>


    <label id="label_type_transportation" for="type_transportation">Choose the type of transportation :</label><br>
    <select id="type_transportation">
        <option value="NULL">-- Choisissez une option --</option>

        <?php

        $bdd = get_dbhandle();
        $req = $bdd->prepare("SELECT Name From Transportation_Type;");
        $req->execute();

        while ($data = $req->fetch()) {
            echo '<option value="' .$data["ID"]. '">' . $data["Name"] . '</option>';
        }
        ?>

    </select><br><br>

    <label id="label_type_transportation" for="date_transportation_transportation">Choose the date of departure :</label><br>
    <label id="date_transportation" onchange="transport()">
        <input type="date" name='date_departure'/><br>
    </label><br><br>

    <div id="transportation_div" hidden>

        <select id="transportation">
            <option value="NULL">-- Choisissez une option --</option>

        </select><br><br>


    </div>



    <form method="post" onchange="">
        <label>
            <input type="submit" name='transportation_ajout' value="Add a transportation" /><br>
        </label><br>
    </form><br>

    <form method="post" onchange="">
        <label>
            <input type="submit" name='transportation_Remove' value="Remove a transportation" /><br>
        </label>
    </form>



</section>

<script>

    function transport(){
        const date = document.getElementById("date_transportation");
        const transportation_div = document.getElementById("transportation_div");
        const type_transportation = document.getElementById("type_transportation");

        transportation_div.hidden = true;
        if(date.value !== "NULL"){
            transportation_div.hidden = false;


            fetch(`add_reservation_transportation_get.php?type=type_transportation&date=date`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(item => {
                        //Add the new option
                        let option = document.createElement("option");
                        option.value = item.ID;
                        option.textContent = item.Name;
                        transportation.appendChild(option);
                    });
                })


        }
    }



</script>

</body>

</html>