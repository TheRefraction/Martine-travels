<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $form_id = $_POST['form_id'];

    switch ($form_id) {
        case 'Package':

            echo "Processing Package Form.";
            break;

        case 'PackageType':
            

            echo "Processing PackageType Form.";
            break;

        case 'Destination':
            echo "Processing Destination Form.";
            break;

        case 'Country':

            echo "Processing Country Form.";
            break;

        case 'TransportationJoin':

            echo "Processing TransportationJoin Form.";
            break;

        case 'AccomodationJoin':

            echo "Processing AccomodationJoin Form.";
            break;

        case 'AccomodationType':

            echo "Processing AccomodationType Form.";
            break;

        case 'RoomType':

            echo "Processing RoomType Form.";
            break;

        case 'Transport':

            echo "Processing Transport Form.";
            break;

        case 'Accomodation':
            $bdd = get_dbhandle();



                $provider_id = $_POST['provider_id'];
                $room_type_id = $_POST['room_type_id'];
                $indate = $_POST['indate'];
                $outdate = $_POST['outdate'];


                $req = $bdd->prepare("INSERT INTO Accommodation (Provider_ID, Room_type_ID, Indate, Outdate) VALUES (:provider_id, :room_type_id, :indate, :outdate)");
                $req->bindParam(':provider_id', $provider_id);
                $req->bindParam(':room_type_id', $room_type_id);
                $req->bindParam(':indate', $indate);
                $req->bindParam(':outdate', $outdate);

                if ($req->execute()) {
                    echo "Accommodation added successfully!";
                } else {
                    echo "Failed to add accommodation.";
                }

            echo "Processing Accomodation Form.";
            break;

        case 'AmmenitiesJoin':

            echo "Processing AmmenitiesJoin Form.";
            break;

        case 'Ammenities':

            echo "Processing Ammenities Form.";
            break;

        case 'TransportationProvider':

            echo "Processing TransportationProvider Form.";
            break;

        default:
            echo "Unknown form submission.";
            break;
    }
}


?>
