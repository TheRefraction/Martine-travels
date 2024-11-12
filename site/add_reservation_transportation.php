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
    <select id="type_transportation" onchange="transport_departure()">
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
        <label>Will only be deplayed the places where there are transportations (at any given time or type of transportation)</label><br>

        <label id="label_transportation_departure" for="transportation_departure">Choose the place of Departure:</label><br>
        <select id="transportation_departure" onchange="button()">
            <option value="NULL">-- Choisissez une option --</option>
            <?php

            $sql = "
                SELECT  Address_Country.Name as Country, Address_County.Name as County, Address_Town.Name as Town, Address_Street.Name as Street, Ad.ID
                FROM Address Ad
                INNER JOIN Address_Country ON Address_Country.ID = Ad.Country_ID
                INNER JOIN Address_County ON Address_County.ID = Ad.County_ID 
                INNER JOIN Address_Town ON Address_Town.ID = Ad.Town_ID
                INNER JOIN Address_Street ON Address_Street.ID = Ad.Street_ID
                WHERE (SELECT COUNT(*) FROM Transportation Tp WHERE Tp.Address_Depature_ID = Ad.ID) > 0;
                ";

            $req = $bdd->prepare($sql);
            $req->execute();

            while ($data = $req->fetch()) {
                $fullAddress = "{$data['Country']}, {$data['County']}, {$data['Town']}, {$data['Street']}";
                echo '<option value="' .$data["ID"]. '">' . $fullAddress . '</option>';
            }
            ?>

        </select><br><br>

        <label id="label_transportation" for="transportation_arrival">Choose the place of Arrival :</label><br>
        <select id="transportation_arrival" onchange="button()">
            <option value="NULL">-- Choisissez une option --</option>
            <?php

            $sql = "
            SELECT  Address_Country.Name as Country, Address_County.Name as County, Address_Town.Name as Town, Address_Street.Name as Street, Ad.ID
            FROM Address Ad
            INNER JOIN Address_Country ON Address_Country.ID = Ad.Country_ID
            INNER JOIN Address_County ON Address_County.ID = Ad.County_ID 
            INNER JOIN Address_Town ON Address_Town.ID = Ad.Town_ID
            INNER JOIN Address_Street ON Address_Street.ID = Ad.Street_ID
            WHERE (SELECT COUNT(*) FROM Transportation Tp WHERE Tp.Address_Arrival_ID = Ad.ID) > 0;
            ";

            $req = $bdd->prepare($sql);
            $req->execute();

            while ($data = $req->fetch()) {
                $fullAddress = "{$data['Country']}, {$data['County']}, {$data['Town']}, {$data['Street']}";
                echo '<option value="' .$data["ID"]. '">' . $fullAddress . '</option>';
            }
            ?>


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
        transportation_div.hidden = true;
        if (date) {
            transportation_div.hidden = false;
        }
    }

    // Fonction pour supprimer les options sauf celles avec la valeur "NULL"
    function clearOptionsExceptNull(selectElement) {
        for (let i = selectElement.options.length - 1; i >= 0; i--) {
            if (selectElement.options[i].value !== "NULL") {
                selectElement.remove(i);
            }
        }
    }

    // Fonction pour faire un fetch et ajouter des options à un élément select
    function fetchOptions(selectElement, url) {
        fetch(url)
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
                // Ajouter des options dans le selectElement
                data.forEach(item => {
                    let option = document.createElement("option");
                    const fullAddress = `${item.Country}, ${item.County}, ${item.Town}, ${item.Street}`;
                    option.value = item.ID;
                    option.textContent = fullAddress;
                    selectElement.appendChild(option);
                });
            })
            .catch(error => {
                console.error("Erreur lors de la récupération des données :", error);
                alert("Une erreur est survenue lors de la récupération des données. Veuillez réessayer.");
            });
    }

    function button(){

        const type = document.getElementById("type_transportation");
        const date = document.getElementById("date_transportation");
        const transportation_departure = document.getElementById("transportation_departure");
        const transportation_arrival = document.getElementById("transportation_arrival");
        const form_transportation_add = document.getElementById("form_transportation_add");
        const form_next = document.getElementById("form_next");
        const description = document.getElementById("description");

        //set invisible (in case of modification of previous select)
        form_transportation_add.hidden = true;
        form_next.hidden = true;
        description.hidden = true;

        if(transportation_arrival.value !== "NULL" ){
            form_transportation_add.hidden = false;
            form_next.hidden = false;
            description.hidden = false;
            console.log("type:", type.value, "date:", date.value, "departure:", transportation_departure.value, "arrival:", transportation_arrival.value);
            fetch(`add_reservation_transportation_get_description.php?departure=${transportation_departure.value}&arrival=${transportation_arrival.value}&type=${type.value}&date=${date.value}`)
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
                    if (data.length === 0) {
                        // Display message if no transportation is found
                        description.innerHTML = "There is no transportation with those parameters";
                        return;
                    }
                    //Creation of description
                    data.forEach(item => {
                            const text = `Arrival Address: ${item.Arrival_Country}, ${item.Arrival_County}, ${item.Arrival_Town}, ${item.Arrival_Street}<br>` +
                                `Departure Address: ${item.Departure_Country}, ${item.Departure_County}, ${item.Departure_Town}, ${item.Departure_Street}<br>`+
                                `Ticket Number : ${item.Ticket_Num}, Seat Number : ${item.Seat_Num}<br>`+
                                `Provider : ${item.Provider}, Price : ${item.Ticket_Price}<br>`;
                            description.innerHTML = text;
                    });
                })
        }
    }



</script>

</body>

</html>