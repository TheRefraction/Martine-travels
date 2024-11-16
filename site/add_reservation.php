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

        <h1>Reservation for your vacations</h1><br>

        <form method="post" id="form_premade_transportation" action="add_reservation_accomodation_process.php">


        <label for="options">Please select an option :</label><br>
            <!-- Custom or premade-->
        <select id="options" name="options" onchange="afficherLabel()">
            <option value="">-- Choose an option --</option>
            <option value="custom">Custom made package</option>
            <option value="premade">Package Premade</option>
        </select>


        <!-- Custom -->
        <div id="labelCustom" class="label" hidden>
            <div><br>
                <label for="pays">Choose where you want to go :</label><br>
                <select id="pays" name="pays" onchange="function_accomodation()">
                    <option value="NULL">----- Choisissez une option ----</option>


                    <?php

                    $bdd = get_dbhandle();
                    $req = $bdd->prepare("SELECT Name, ID From Address_Country;");
                    $req->execute();

                    while ($data = $req->fetch()) {
                        echo '<option value="' .$data["ID"]. '">' . $data["Name"] . '</option>';
                    }
                    ?>

            </select>
            <br><br>

            <div id="div_accomodation" hidden>
                <label id="label_accomodation" for="accomodation">Choose in which of the following accomodation (in the country) you want to go :</label><br>
                <select id="accomodation" name="accomodation" onchange="detail()">
                    <option value="NULL">-- Choisissez une option --</option>
                </select><br><br>

                <div id="div_accomodation_detail" hidden>

                    <label id="label_accomodation_detail" for="accomodation_detail">Choose the following details :</label><br>
                    <select id="accomodation_detail" name="accomodation_detail" onchange="next()">
                        <option value="NULL">-- Choisissez une option --</option>
                    </select><br><br>


                    <label>
                        <input type="submit" id="transportation_header" name='transportation_header' value="I want to add a transportation"/><br>
                    </label><br>
                    <label>
                        <input type="submit" id= "custom_no_transportation" name='custom_no_transportation' value="I don't want to add a transportation"/><br>
                    </label><br>

                </div>
            </div>
            </div><br>

        </div>

            <!-- Premade-->
        <div id="labelPremade" hidden>
            <br>
                <label for="package_choice">Choose the package</label><br>
                <select id="package_choice" name="package_choice" onchange="transportation_description()">
                    <option value="" disabled selected>-- Choisissez une option --</option>
                    <?php
                    $req = $bdd->prepare("
                    SELECT  Address_Country.Name as Country, Address_County.Name as County, Address_Town.Name as Town, Address_Street.Name as Street, Package_Type.Name as Type, Pa.*
                    FROM Package Pa
                    INNER JOIN Package_Type ON Pa.Type_ID = Package_Type.ID
                    INNER JOIN Address Ad ON Ad.ID = Pa.Address_ID
                    INNER JOIN Address_Country ON Address_Country.ID = Ad.Country_ID
                    INNER JOIN Address_County ON Address_County.ID = Ad.County_ID 
                    INNER JOIN Address_Town ON Address_Town.ID = Ad.Town_ID
                    INNER JOIN Address_Street ON Address_Street.ID = Ad.Street_ID
                    ");

                    $req->execute();

                    while ($data = $req->fetch()) {
                        $text = "{$data['Type']}, {$data['Duration']} days, {$data['Country']}, {$data['County']}, {$data['Town']}, {$data['Street']}, {$data['Price']}€";
                        echo '<option value="' .$data["ID"]. '">' . $text . '</option>';
                    }

                    ?>
                </select><br><br>

            <div id="premade_description"> <!-- Is completed with transportation_description()-->
            </div><br>



            <label>
                <input type="submit" name='premade_next_transportation' value="I want to add a transportation"/>
            </label>
            <label>
                <input type="submit" name='premade_next_no' value="I don't want to add a transportation"/>
            </label>


        </div>
        </form>
        <script>
            function afficherLabel() {
                // Récupère l'élément select et les labels
                const select = document.getElementById('options');
                const labelCustom = document.getElementById('labelCustom');
                const labelPremade = document.getElementById('labelPremade');
                const paysSelect = document.getElementById("pays");
                const accommodationSelect = document.getElementById("accomodation");

                // Réinitialise l'affichage des labels
                labelCustom.hidden = true;
                labelPremade.hidden = true;

                // Affiche le label approprié en fonction de l'option sélectionnée
                if (select.value === 'custom') {
                    labelCustom.hidden = false;
                } else if (select.value === 'premade') {
                    labelPremade.hidden = false;
                }
            }

            function function_accomodation(){

                const paysSelect = document.getElementById("pays");
                const accommodationSelect = document.getElementById("accomodation");
                const accommodationDiv = document.getElementById("div_accomodation");
                accommodationDiv.hidden =true;

                //remove precedent options
                for (let i = accommodationSelect.options.length - 1; i >= 0; i--) {
                    if (accommodationSelect.options[i].value !== "NULL") {
                        accommodationSelect.remove(i);
                    }
                }

                if (paysSelect.value!=="NULL") {
                    accommodationDiv.hidden = false;



                    fetch("add_reservation_get_accommodations.php?pays=" + paysSelect.value)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(item => {
                                //Add the new option
                                let option = document.createElement("option");
                                option.value = item.ID;
                                option.textContent = item.Name;
                                accommodationSelect.appendChild(option);
                            });
                        })

                }
            }

            function detail(){

                const accomodationprovider = document.getElementById("accomodation");
                const detailSelect = document.getElementById("accomodation_detail");
                const detailDiv = document.getElementById("div_accomodation_detail");

                detailDiv.hidden = true;

                //remove precedent options
                for (let i = detailSelect.options.length - 1; i >= 0; i--) {
                    if (detailSelect.options[i].value !== "NULL") {
                        detailSelect.remove(i);
                    }
                }

                if(accomodationprovider.value !== "NULL"){
                    detailDiv.hidden = false
                }

                fetch("add_reservation_get_accommodations_detail.php?accomodationprovider=" + accomodationprovider.value)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(item => {
                            let option = document.createElement("option");
                            const text = `${item.Price_Per_Night}€, ${item.Room_Type}, ${item.Check_In_Date} to ${item.Check_Out_Date}`;
                            option.value = item.ID;
                            option.textContent = text;
                            detailSelect.appendChild(option);
                        });
                    })
            }


            function next(){
                const accomodation_detail = document.getElementById("accomodation_detail");
                const next = document.getElementById("transportation_header");
                const no = document.getElementById("custom_no_transportation");

                no.hidden = true;
                next.hidden = true;
                if(accomodation_detail.value !== "NULL"){
                    next.hidden = false;
                    no.hidden = false;
                }
            }

            function transportation_description(){

                const package = document.getElementById("package_choice");
                const description = document.getElementById("premade_description");

                if (package.value !== "NULL"){
                    fetch(`add_reservation_transportation_get_description.php?id=` + package.value)
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
                                description.innerHTML = "There is no transportation in this package";
                                return;
                            }

                            // Clear existing content
                            description.innerHTML = "";

                            //Creation of description
                            data.forEach(item => {
                                const text = `Arrival Address: ${item.Arrival_Country}, ${item.Arrival_County}, ${item.Arrival_Town}, ${item.Arrival_Street}<br>` +
                                    `Departure Address: ${item.Departure_Country}, ${item.Departure_County}, ${item.Departure_Town}, ${item.Departure_Street}<br>` +
                                    `Ticket Number : ${item.Ticket_Num}, Seat Number : ${item.Seat_Num}<br>` +
                                    `Provider : ${item.Provider}, Price : ${item.Ticket_Price}<br>`;
                                description.innerHTML += text;
                            });
                        })
                }
            }

        </script>

        </section>

    </body>

</html>