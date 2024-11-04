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
        <input type="hidden" name="form_id" value="Package">
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
            <input type="checkbox" id="custom_checkbox" name="is_custom" "> Custom Package
        </label><br><br>
        <input type="submit" value="Add new package">
    </form>
    <br>

    <form action="admin.php" method="POST">
        <input type="hidden" name="form_id" value="PackageType">
        <h1>Package Type:</h1>
        <label>
            type of the package : <input type="text" name="PackageType" class="input-field" required="required"/>
        </label> <br>
        <input type="submit" value="Add new package type">
    </form>
    <br>

    <form action="admin.php" method="POST">
        <input type="hidden" name="form_id" value="Accommodation">
        <h1>Accommodation:</h1>
        <select id="Accommodation_provider" name="package_accommodation_provider_id" required>
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
        <select id="accommodation_room_type" name="accommodation_room_type_id" required>
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
        <input type="submit" value="Add new Accommodation">
    </form>





    <form action="admin.php" method="POST">
        <input type="hidden" name="form_id" value="AccommodationJoin">
        <h1>Join Accommodation and Package:</h1>
        <?php
        $bdd = get_dbhandle();

        $req = $bdd->prepare("
        SELECT Accomodation.ID, AccomodationProvider.Name AS Provider_Name, RoomType.Name AS Room_Type
        FROM Accomodation
        INNER JOIN AccomodationProvider ON Accomodation.Provider_ID = AccomodationProvider.ID
        INNER JOIN RoomType ON Accomodation.Room_type_ID = RoomType.ID");
        $req->execute();
        ?>

        <select id="Accommodationjoin_accommodation" name="Accommodationjoin_accommodation_id" required>
            <option value="">-- Select an accommodation --</option>

            <?php
            while ($row = $req->fetch()) {
                echo '<option value="' . htmlspecialchars($row['ID']) . '">'
                    . htmlspecialchars($row['Provider_Name']) . ' - '
                    . htmlspecialchars($row['Room_Type']) .
                    '</option>';
            }

            $req->closeCursor();
            ?>
        </select>
        <br><br>
        <?php
        $bdd = get_dbhandle();

        $req = $bdd->prepare("
    SELECT Package.ID, PackageType.Name AS Package_Type, Destination.Name AS Destination_Name, Package.Duration
    FROM Package
    INNER JOIN PackageType ON Package.Type_ID = PackageType.ID
    INNER JOIN Destination ON Package.Destination_ID = Destination.ID");

        $req->execute();
        ?>

        <select id="AccommodationJoin_package_select" name="AccommodationJoin_package_id" required>
            <option value="">-- Select a package --</option>

            <?php
            while ($row = $req->fetch()) {
                echo '<option value="' . htmlspecialchars($row['ID']) . '">'
                    . htmlspecialchars($row['Package_Type']) . ' - '
                    . htmlspecialchars($row['Destination_Name']) . ' - '
                    . htmlspecialchars($row['Duration']) . ' jours'
                    . '</option>';
            }

            $req->closeCursor();
            ?>
        </select>
        <br><br>


        <input type="submit" value="Join">
    </form>
    <br>




    <form action="admin.php" method="POST">
        <input type="hidden" name="form_id" value="AccommodationProvider">
        <h1>Accommodation Provider:</h1>
        <select id="accommodation_provider_type" name="accommodation_type_id" required>
            <option value="">-- Select accommodation type --</option>

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
            Name : <input type = "text" name="AccommodationProviderName" class="input-field" required="required" />
        </label><br>
        <label>
            Address : <input type = "text" name="AccommodationProviderAddress" class="input-field" required="required" />
        </label><br>

        <input type="submit" value="add accommodation provider">
    </form>
    <br>



    <form action="admin.php" method="POST">
        <input type="hidden" name="form_id" value="AccommodationType">
        <h1>Accommodation Type:</h1>
        <label>
            name of the accommodation type : <input type = "text" name="Accommodationtype" class="input-field" required="required" />
        </label><br>
        <input type="submit" value="add accommodation type">
    </form>



    <br>
    <form action="admin.php" method="POST">
        <input type="hidden" name="form_id" value="Amenities">
        <h1>Amenities:</h1>
        <label>
            Name : <input type = "text" name="AmenitiesName" class="input-field" required="required" />
        </label><br>
        <input type="submit" value="add amenities">
    </form>
    <br>

    <form action="admin.php" method="POST">
        <input type="hidden" name="form_id" value="AmenitiesJoin">
        <h1>Join Amenities to accommodation:</h1>
        <?php
        $bdd = get_dbhandle();

        $req = $bdd->prepare("
        SELECT Accomodation.ID, AccomodationProvider.Name AS Provider_Name, RoomType.Name AS Room_Type
        FROM Accomodation
        INNER JOIN AccomodationProvider ON Accomodation.Provider_ID = AccomodationProvider.ID
        INNER JOIN RoomType ON Accomodation.Room_type_ID = RoomType.ID");
        $req->execute();
        ?>

        <select id="Amenitiesjoin_accommodation" name="Amenitiesjoin_accommodation_id" required>
            <option value="">-- Select accommodation --</option>

            <?php
            while ($row = $req->fetch()) {
                echo '<option value="' . htmlspecialchars($row['ID']) . '">'
                    . htmlspecialchars($row['Provider_Name']) . ' - '
                    . htmlspecialchars($row['Room_Type']) .
                    '</option>';
            }

            $req->closeCursor();
            ?>
        </select>
        <br><br>

        <select id="Amenities_join_amenities" name="Amenities_join_amenities_id" required>
            <option value="">-- Select amenities --</option>

            <?php


            $bdd = get_dbhandle();

            $req = $bdd->prepare("SELECT ID, Name FROM Amenities");
            $req->execute();


            while ($row = $req->fetch()) {
                echo '<option value="' . htmlspecialchars($row['ID']) . '">' . htmlspecialchars($row['Name']) . '</option>';
            }

            $req->closeCursor();
            ?>
        </select><br><br>
        <input type="submit" value="join amenities to an accommodation">
    </form>
    <br>




    <form action="admin.php" method="POST">
        <input type="hidden" name="form_id" value="Destination">
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
        <input type="hidden" name="form_id" value="Feedback">
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
        <input type="hidden" name="form_id" value="PackageUser">
        <h1> Assign a package to a user:</h1>
        <select id="PackageUser_user" name="PackageUser_id" required>
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
        <?php
        $bdd = get_dbhandle();

        $req = $bdd->prepare("
    SELECT Package.ID, PackageType.Name AS Package_Type, Destination.Name AS Destination_Name, Package.Duration
    FROM Package
    INNER JOIN PackageType ON Package.Type_ID = PackageType.ID
    INNER JOIN Destination ON Package.Destination_ID = Destination.ID");

        $req->execute();
        ?>

        <select id="PackageUser_package" name="PackageUser_package_id" required>
            <option value="">-- Select a package --</option>

            <?php
            while ($row = $req->fetch()) {
                echo '<option value="' . htmlspecialchars($row['ID']) . '">'
                    . htmlspecialchars($row['Package_Type']) . ' - '
                    . htmlspecialchars($row['Destination_Name']) . ' - '
                    . htmlspecialchars($row['Duration']) . ' jours'
                    . '</option>';
            }

            $req->closeCursor();
            ?>
        </select>
        <br><br>


        <input type="submit" value="join a package to an user">
    </form>



    <br>
    <form action="admin.php" method="POST">
        <input type="hidden" name="form_id" value="Preference">
        <h1>Preference of user about vehicle:</h1>
        <select id="preference_user" name="preference_user_id" required>
            <option value="">-- Select an user --</option>

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

        <select id="Preference_transport" name="Preference_transport_id" required>
            <option value="">-- Select transport --</option>

            <?php


            $bdd = get_dbhandle();

            $req = $bdd->prepare("SELECT ID, Name FROM Transport");
            $req->execute();


            while ($row = $req->fetch()) {
                echo '<option value="' . htmlspecialchars($row['ID']) . '">' . htmlspecialchars($row['Name']) . '</option>';
            }

            $req->closeCursor();
            ?>
        </select><br><br>
        <input type="submit" value="ok ">
    </form>



    <br>
    <form action="admin.php" method="POST">
        <input type="hidden" name="form_id" value="RoomType">
        <h1>Room Type:</h1>
        <label>
            New room type : <input type = "text" name="RoomType" class="input-field" required="required" />
        </label><br>
        <input type="submit" value="add room type ">
    </form>
    <br>



    <form action="admin.php" method="POST">
        <input type="hidden" name="form_id" value="Transport">
        <h1>Transport :</h1>
        <label>
            New Transport : <input type = "text" name="Transport" class="input-field" required="required" />
        </label><br>
        <input type="submit" value="add transport">
    </form>
    <br>

    <form action="admin.php" method="POST">
        <input type="hidden" name="form_id" value="Transportation">
        <h1>Transportation:</h1>
        <select id="Transportation_transport" name="Transportation_transport_id" required>
            <option value="">-- Select transport --</option>

            <?php


            $bdd = get_dbhandle();

            $req = $bdd->prepare("SELECT ID, Name FROM Transport");
            $req->execute();


            while ($row = $req->fetch()) {
                echo '<option value="' . htmlspecialchars($row['ID']) . '">' . htmlspecialchars($row['Name']) . '</option>';
            }

            $req->closeCursor();
            ?>
        </select><br><br>
        <label>
            Date : <input type="date" name="Transportation_date" class="input-field" required="required"/>
        </label> <br>
        <label>
            Departure : <input type="time" name="Transportation_departure" class="input-field" required="required"/>
        </label> <br>
        <label>
            Arrival : <input type="time" name="Transportation_arrival" class="input-field" required="required"/>
        </label> <br>
        <select id="Transportation_transport_provider" name="Transportation_transport_provider_id" required>
            <option value="">-- Select transport provider --</option>

            <?php


            $bdd = get_dbhandle();

            $req = $bdd->prepare("SELECT ID, Name FROM TransportProvider");
            $req->execute();


            while ($row = $req->fetch()) {
                echo '<option value="' . htmlspecialchars($row['ID']) . '">' . htmlspecialchars($row['Name']) . '</option>';
            }

            $req->closeCursor();
            ?>
        </select><br><br>
        <label>
            Ticket number : <input type="number" name="Transportation_ticket_number" class="input-field" required="required"/>
        </label> <br>
        <label>
            Seat number : <input type="number" name="Transportation_seat_number" class="input-field" required="required"/>
        </label> <br>
        <label>
            Place of Departure : <input type="text" name="Transportation_departure_place" class="input-field" required="required"/>
        </label> <br>
        <label>
            Place of Arrival : <input type="text" name="Transportation_arrival_place" class="input-field" required="required"/>
        </label> <br>
        <select id="Transportation_departure_country" name="Transportation_departure_country_id" required>
            <option value="">-- Select Departure Country --</option>

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
        <select id="Transportation_arrival_country" name="Transportation_arrival_country_id" required>
            <option value="">-- Select Arrival Country --</option>

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
        <input type="submit" value="add transportation">
    </form>
    <br>


    <form action="admin.php" method="POST">
        <input type="hidden" name="form_id" value="TransportationJoin">
        <h1>join Transportation to package:</h1>
        <?php
        $bdd = get_dbhandle();


        $req = $bdd->prepare("
    SELECT Package.ID, PackageType.Name AS Package_Type, Destination.Name AS Destination_Name, Package.Duration
    FROM Package
    INNER JOIN PackageType ON Package.Type_ID = PackageType.ID
    INNER JOIN Destination ON Package.Destination_ID = Destination.ID");

        $req->execute();
        ?>

        <select id="TransportationJoin_package" name="TransportationJoin_package_id" required>
            <option value="">-- Select a package --</option>

            <?php
            while ($row = $req->fetch()) {
                echo '<option value="' . htmlspecialchars($row['ID']) . '">'
                    . htmlspecialchars($row['Package_Type']) . ' - '
                    . htmlspecialchars($row['Destination_Name']) . ' - '
                    . htmlspecialchars($row['Duration']) . ' jours'
                    . '</option>';
            }
            $req->closeCursor();
            ?>
        </select>
        <br><br>

        <?php

        $req = $bdd->prepare("
    SELECT Transportation.ID, Transport.Name AS Transport_Type, Transportation.Date, TransportProvider.Name AS Provider_Name
    FROM Transportation
    INNER JOIN Transport ON Transportation.Type_ID = Transport.ID
    INNER JOIN TransportProvider ON Transportation.Provider_ID = TransportProvider.ID");

        $req->execute();
        ?>

        <select id="TransportationJoin_transportation" name="TransportationJoin_transportation_id" required>
            <option value="">-- Select transportation --</option>

            <?php
            while ($row = $req->fetch()) {
                echo '<option value="' . htmlspecialchars($row['ID']) . '">'
                    . htmlspecialchars($row['Transport_Type']) . ' - '
                    . htmlspecialchars($row['Date']) . ' - '
                    . htmlspecialchars($row['Provider_Name'])
                    . '</option>';
            }
            $req->closeCursor();
            ?>
        </select>
        <br><br>


        <input type="submit" value="join ">
    </form>



    <br>
    <form action="admin.php" method="POST">
        <input type="hidden" name="form_id" value="TransportProvider">
        <h1>Transport Provider:</h1>
        <label>
            New transport provider : <input type="text" name="Transport_provider" class="input-field" required="required"/>
        </label> <br>
        <input type="submit" value="add transport provider">
    </form>
    <br>

    <form action="admin.php" method="POST">
        <input type="hidden" name="form_id" value="User">
        <h1>User:</h1>
        <label>
            First name : <input type="text" name="fname" class="input-field" required="required" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\-]+" title ="Must contain only letters or hyphens"/>
        </label> <br>

        <label>
            Last name : <input type="text" name="lname" class="input-field" required="required" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\-]+" title ="Must contain only letters or hyphens"/>
        </label> <br>

        <label>
            Email : <input type="email" placeholder="email@domain.com" name="email" class="input-field" required="required" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$"/>
        </label> <br>

        <label>
            Birthdate : <input type="date" id="birthday" name="birthday" class="input-field" required="required" min="1900-01-01"/>
        </label> <br>

        <label>
            Phone number : <input type="tel" placeholder="0545654751" name="phone" class="input-field" required="required"/>
        </label> <br>
        <label>
            Password : <input type="password" name="passwd" class="input-field" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,128}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"/>
        </label> <br>
        <input type="submit" value="add User">
    </form>
    <br>
    <form action="admin.php" method="POST">
        <input type="hidden" name="form_id" value="Is_admin">
        <h1>New admin:</h1>
        <select id="Is_admin_user" name="Is_admin_user_id" required>
            <option value="">-- Select an user --</option>

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
        <input type="submit" value="add a new admin ">
    </form>
    <br>
</section>
</body>
</html>