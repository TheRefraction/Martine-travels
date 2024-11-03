<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Martine travels-Admin</title>
        <link href ="css/style.css" rel="stylesheet">
    </head>

    <body>
        <section>
            <form action="admin.php" method="POST">
                <input type="hidden" name="formulaire_id" value="Package">
                <h1>Package:</h1>
                <label for="package_type">Package Type:</label><br>
                <select id="package_type" name="package_type_id" required>
                    <option value="">-- Select Package Type --</option>

                    <?php
                    include("connection.php");

                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }

                    if (!isset($_SESSION['email'])) {
                        header("Location: signin.php");
                        exit();
                    }

                    $bdd = get_dbhandle();

                    $req = $bdd->prepare("SELECT ID, Name FROM PackageType");
                    $req->execute();


                    while ($row = $req->fetch()) {
                        echo '<option value="' . htmlspecialchars($row['ID']) . '">' . htmlspecialchars($row['Name']) . '</option>';
                    }

                    $req->closeCursor();
                    ?>
                </select><br><br>
                <label for="package_destination">Destination</label><br>
                <select id="package_destination" name="package_destination_id" required>
                    <option value="">-- Select destination --</option>

                    <?php


                    $bdd = get_dbhandle();

                    $req = $bdd->prepare("SELECT ID, Name FROM Destination");
                    $req->execute();


                    while ($row = $req->fetch()) {
                        echo '<option value="' . htmlspecialchars($row['ID']) . '">' . htmlspecialchars($row['Name']) . '</option>';
                    }

                    $req->closeCursor();
                    ?>
                </select><br><br>
                <label>
                    Duration in day : <input type="number" name="duration" class="input-field" required="required"/>
                </label> <br>
                <label>
                    Price : <input type="number" name="price" class="input-field" required="required"/>
                </label> <br>
                <label for="Is_custom">
                    <input type="checkbox" id="custom_checkbox" name="is_custom" onchange="toggleCustomField()"> Custom Package
                </label><br><br>
                <input type="submit" value="Add new package">
            </form>
<br>

            <form action="admin.php" method="POST">
                <input type="hidden" name="formulaire_id" value="PackageType">
                <h1>Package Type:</h1>
                <label>
                    type of the package : <input type="text" name="packagetype" class="input-field" required="required"/>
                </label> <br>
                <input type="submit" value="Add new package type">
            </form>
<br>

            <form action="admin.php" method="POST">
                <input type="hidden" name="formulaire_id" value="Accomodation">
                <h1>Accomodation:</h1>
                <select id="Accomodation_provider" name="package_accomodation_provider_id" required>
                    <option value="">-- Select provider --</option>

                    <?php


                    $bdd = get_dbhandle();

                    $req = $bdd->prepare("SELECT ID, Name FROM AccomodationProvider");
                    $req->execute();


                    while ($row = $req->fetch()) {
                        echo '<option value="' . htmlspecialchars($row['ID']) . '">' . htmlspecialchars($row['Name']) . '</option>';
                    }

                    $req->closeCursor();
                    ?>
                </select><br><br>
                <select id="accomodation_room_type" name="accomodation_room_type_id" required>
                    <option value="">-- Select room type --</option>

                    <?php


                    $bdd = get_dbhandle();

                    $req = $bdd->prepare("SELECT ID, Name FROM RoomType");
                    $req->execute();


                    while ($row = $req->fetch()) {
                        echo '<option value="' . htmlspecialchars($row['ID']) . '">' . htmlspecialchars($row['Name']) . '</option>';
                    }

                    $req->closeCursor();
                    ?>
                </select><br><br>
                <label>
                    Indate : <input type="date" name="indate" class="input-field" required="required"/>
                </label> <br>
                <label>
                    Outdate : <input type="date" name="outdate" class="input-field" required="required"/>
                </label> <br>
                <input type="submit" value="Add new Accomodation">
            </form>





            <form action="admin.php" method="POST">
                <input type="hidden" name="formulaire_id" value="AccomodationJoin">
                <h1>Join Accomodation and Package:</h1>


                <input type="submit" value="Join">
            </form>
            <br>




            <form action="admin.php" method="POST">
                <input type="hidden" name="formulaire_id" value="AccomodationProvider">
                <h1>Accomodation Provider:</h1>
                    <select id="accomodation_provider_type" name="accomodation_type_id" required>
                        <option value="">-- Select accomodation type --</option>

                        <?php


                        $bdd = get_dbhandle();

                        $req = $bdd->prepare("SELECT ID, Name FROM AccomodationType");
                        $req->execute();


                        while ($row = $req->fetch()) {
                            echo '<option value="' . htmlspecialchars($row['ID']) . '">' . htmlspecialchars($row['Name']) . '</option>';
                        }

                        $req->closeCursor();
                        ?>
                    </select><br><br>
                    <label>
                        Name : <input type = "text" name="AccomodationProviderName" class="input-field" required="required" />
                    </label><br>
                <label>
                    Adress : <input type = "text" name="AccomodationProviderAdress" class="input-field" required="required" />
                </label><br>

                <input type="submit" value="add accomodation provider">
            </form>
            <br>



            <form action="admin.php" method="POST">
                <input type="hidden" name="formulaire_id" value="AccomodationType">
                <h1>Accomodation Type:</h1>
                    <label>
                        name of the accomodation type : <input type = "text" name="Accomodationtype" class="input-field" required="required" />
                    </label><br>
                <input type="submit" value="add accomodation type">
            </form>



            <br>
            <form action="admin.php" method="POST">
                <input type="hidden" name="formulaire_id" value="Ammenities">
                <h1>Ammenities:</h1>
                    <label>
                        Name : <input type = "text" name="AmmenitiesName" class="input-field" required="required" />
                    </label><br>
                <input type="submit" value="add ammenities">
            </form>
            <br>

            <form action="admin.php" method="POST">
                <input type="hidden" name="formulaire_id" value="AmmenitiesJoin">
                <h1>Join Ammenities to accomodation:</h1>

                <input type="submit" value="join ammenities to an accomodation">
            </form>
            <br>




            <form action="admin.php" method="POST">
                <input type="hidden" name="formulaire_id" value="Destination">
                <h1>Destination:</h1>
                <label>
                    Name : <input type = "text" name="DestinationName" class="input-field" required="required" />
                </label><br>
                <label>
                    Town : <input type = "text" name="DestinationTown" class="input-field" required="required" />
                </label><br>
                <select id="Destination_country" name="Destination_country_id" required>
                    <option value="">-- Select Country --</option>

                    <?php


                    $bdd = get_dbhandle();

                    $req = $bdd->prepare("SELECT ID, Name FROM Country");
                    $req->execute();


                    while ($row = $req->fetch()) {
                        echo '<option value="' . htmlspecialchars($row['ID']) . '">' . htmlspecialchars($row['Name']) . '</option>';
                    }

                    $req->closeCursor();
                    ?>
                </select><br><br>
                <input type="submit" value="add destination">
            </form>
            <br>



            <form action="admin.php" method="POST">
                <input type="hidden" name="formulaire_id" value="Feedback">
                <h1>feedback:</h1>
                <label>
                    Title : <input type = "text" name="FeedbackTitle" class="input-field" required="required" />
                </label><br>
                <select id="Feedback_user" name="Feedback_user_id" required>
                    <option value="">-- Select User --</option>

                    <?php


                    $bdd = get_dbhandle();

                    $req = $bdd->prepare("SELECT ID, First_Name, Last_Name FROM User");
                    $req->execute();


                    while ($row = $req->fetch()) {
                        echo '<option value="' . htmlspecialchars($row['ID']) . '">' . htmlspecialchars($row['First_Name']) . ' ' . htmlspecialchars($row['Last_Name']) . '</option>';
                    }

                    $req->closeCursor();
                    ?>
                </select><br><br>
                <label>
                    content : <input type = "text" name="FeedbackTitle" class="input-field" required="required" />
                </label><br>
                <label>
                    Rate (between 1 and 5) : <input type = "Number" name="FeedbackTitle" class="input-field" required="required" min="1" max="5"  />
                </label><br>
                <input type="submit" value="add feedback">
            </form>
            <br>




            <form action="admin.php" method="POST">
                <input type="hidden" name="formulaire_id" value="PackageUser">
                <h1> Assign a package to an user:</h1>

                <input type="submit" value="join a package to an user">
            </form>
            <br>
            <form action="admin.php" method="POST">
                <input type="hidden" name="formulaire_id" value="Preference">
                <h1>Preference of user about vehicule:</h1>

                <input type="submit" value="ok ">
            </form>
            <br>
            <form action="admin.php" method="POST">
                <input type="hidden" name="formulaire_id" value="RoomType">
                <h1>Room Type:</h1>

                <input type="submit" value="add room type ">
            </form>
            <br>
            <form action="admin.php" method="POST">
                <input type="hidden" name="formulaire_id" value="Transpot">
                <h1>Transport :</h1>

                <input type="submit" value="add transport">
            </form>
            <br>
            <form action="admin.php" method="POST">
                <input type="hidden" name="formulaire_id" value="Transportation">
                <h1>Transportation:</h1>

                <input type="submit" value="add transportation">
            </form>
            <br>
            <form action="admin.php" method="POST">
                <input type="hidden" name="formulaire_id" value="TransportationJoin">
                <h1>join Transportation to package:</h1>

                <input type="submit" value="join ">
            </form>
            <br>
            <form action="admin.php" method="POST">
                <input type="hidden" name="formulaire_id" value="TransportProvider">
                <h1>Transport Provider:</h1>

                <input type="submit" value="add transport provider">
            </form>
            <br>
            <form action="admin.php" method="POST">
                <input type="hidden" name="formulaire_id" value="User">
                <h1>User:</h1>

                <input type="submit" value="add User">
            </form>
            <br>
            <form action="admin.php" method="POST">
                <input type="hidden" name="formulaire_id" value="Is_admin">
                <h1>New admin:</h1>

                <input type="submit" value="add a new admin ">
            </form>
            <br>
        </section>
    </body>
</html>