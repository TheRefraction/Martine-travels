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


        <label for="options">Please select an option :</label><br>

            <!-- Custom or premade-->
        <select id="options" onchange="afficherLabel()">
            <option value="">-- Choose an option --</option>
            <option value="custom">Custom made package</option>
            <option value="premade">Package Premade</option>
        </select>


        <!-- Custom -->
        <div id="labelCustom" class="label" hidden>
            <div><br>
                <label for="pays">Choose where you want to go :</label><br>
                <select id="pays" onchange="accomodation()">
                    <option value="NULL">----- Choisissez une option ----</option>


                    <?php

                    $bdd = get_dbhandle();
                    $req = $bdd->prepare("SELECT Name, ID From Country;");
                    $req->execute();

                    while ($data = $req->fetch()) {
                        echo '<option value="' .$data["ID"]. '">' . $data["Name"] . '</option>';
                    }
                    ?>

            </select>
            <br><br>

            <div id="div_accomodation" hidden>
                <label id="label_accomodation" for="accomodation">Choose in which of the following accomodation (in the country) you want to go :</label><br>
                <select id="accomodation" onchange="transportation()">
                    <option value="NULL">-- Choisissez une option --</option>
                </select><br>

                <div id="div_type_transportation" hidden><br>
                    <label id="label_type_transportation" for="type_transportation">Choose the type of transportation :</label><br>
                    <select id="type_transportation">
                        <option value="NULL">-- Choisissez une option --</option>

                        <?php

                        $bdd = get_dbhandle();
                        $req = $bdd->prepare("SELECT Name From Transport;");
                        $req->execute();

                        while ($data = $req->fetch()) {
                            echo '<option value="' .$data["ID"]. '">' . $data["Name"] . '</option>';
                        }
                        ?>

                    </select><br><br>

                    <form method="post" onchange="">
                        <label>
                            <input type="submit" name='transportation_ajout' value="Add a transportation" /><br>
                        </label><br>
                    </form><br>

                    <form method="post" onchange="">
                        <label>
                            <input type="submit" name='transportation_Remove' value="Remove a transportation" /><br>
                        </label><br>
                    </form>

                </div>



                </form>

            </div>

            </div><br>

        </div>

            <!-- Premade-->
        <div id="labelPremade" hidden>
            <br>
            <label for="package_choice">Choose the package</label><br>
            <select id="package_choice">
                <option value="">-- Choisissez une option --</option>


                <?php
                $req = $bdd->prepare("SELECT De.Name, De.ID From Package Pa INNER JOIN Destination De ON De.ID = Pa.Destination_ID;");
                $req->execute();

                while ($data = $req->fetch()) {
                    echo '<option value="' . $data["ID"] . '">' .  $data["Name"] . '</option>';
                }

                ?>
            </select>
        </div>

        <script>
            function afficherLabel() {
                // Récupère l'élément select et les labels
                const select = document.getElementById('options');
                const labelCustom = document.getElementById('labelCustom');
                const labelPremade = document.getElementById('labelPremade');

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

            function accomodation(){

                const paysSelect = document.getElementById("pays");
                const accommodationSelect = document.getElementById("accomodation");
                const accommodationDiv = document.getElementById("div_accomodation");
                accommodationDiv.hidden =true;
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

            function transportation(){
                const accomodation = document.getElementById("accomodation");
                const TransportDiv = document.getElementById("div_type_transportation");

                TransportDiv.hidden = true;
                if(accomodation.value !== "NULL"){
                    TransportDiv.hidden = false;
                }
            }

        </script>

        </section>

    </body>

</html>