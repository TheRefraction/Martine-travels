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
    <select id="type_transportation" onchange="transport()">
        <option value="NULL">-- Choisissez une option --</option>

        <?php

        $bdd = get_dbhandle();
        $req = $bdd->prepare("SELECT * From Transportation_Type;");
        $req->execute();

        while ($data = $req->fetch()) {
            echo '<option value="' .$data["ID"]. '">' . $data["Name"] . '</option>';
        }
        ?>

    </select><br><br>

    <label id="label_date" for="date_transportation">Choose the date of departure :</label><br>
    <input type="date" id="date_transportation" name="date_departure" onchange="transport()" /><br><br>

    <div id="transportation_div" hidden>

        <label id="label_transportation" for="transportation">Choose the place of Arrival :</label><br>
        <select id="transportation" onchange="button()">
            <option value="NULL">-- Choisissez une option --</option>

        </select><br><br>


    </div>


    <div id="description" hidden>

    </div><br>

    <form id="form_transportation_add" method="post" onchange="" hidden>
        <label>
            <input type="submit" name='transportation_ajout' value="Validate and add another transportation" /><br>
        </label>
    </form><br>

    <form id="form_next" method="post" onchange="" hidden>
        <label>
            <input type="submit" name='label_next' value="Validate and go to the next step" /><br>
        </label>
    </form>



</section>

<script>

    function transport() {
        const date = document.getElementById("date_transportation").value;
        const transportation_div = document.getElementById("transportation_div");
        const type_transportation = document.getElementById("type_transportation");
        const transportation = document.getElementById("transportation");

        console.log("Selected date:", date);
        console.log("Selected transportation:", type_transportation.value);

        //set invisible (in case of modification of previous select)
        transportation_div.hidden = true;

        //remove precedent option
        for (let i = transportation.options.length - 1; i >= 0; i--) {
            if (transportation.options[i].value !== "NULL") {
                transportation.remove(i);
            }
        }

        if (date) {
            transportation_div.hidden = false;

            fetch(`add_reservation_transportation_get.php?type=${type_transportation.value}&date=${date}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json(); // Attempt to parse JSON
                })
                .then(data => {
                    if (!Array.isArray(data)) {
                        throw new Error("Data format error: Expected an array");
                    }
                    // Process and add options from the fetched data
                    data.forEach(item => {
                        let option = document.createElement("option");
                        const fullAddress = `${item.Country}, ${item.County}, ${item.Town}, ${item.Street}`;
                        option.value = item.ID;
                        option.textContent = fullAddress;
                        transportation.appendChild(option);
                    });
                })
        }
    }

    function button(){

        const form_transportation_add = document.getElementById("form_transportation_add");
        const form_next = document.getElementById("form_next");
        const transportation = document.getElementById("transportation");
        const description = document.getElementById("description");
        console.log("Selected transportation ID:", transportation.value);

        //set invisible (in case of modification of previous select)
        form_transportation_add.hidden = true;
        form_next.hidden = true;
        description.hidden = true;

        if(transportation.value !== "NULL" ){
            form_transportation_add.hidden = false;
            form_next.hidden = false;
            description.hidden = false;

            fetch(`add_reservation_transportation_get_description.php?ID=${transportation.value}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (!Array.isArray(data)) {
                        throw new Error("Data format error: Expected an array");
                    }
                    //Creation of description
                    data.forEach(item => {
                        const text = `${item.Country}, ${item.County}, ${item.Town}, ${item.Street}`;
                        description.textContent = text;
                    });
                })
        }
    }



</script>

</body>

</html>