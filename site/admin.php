<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $formulaire_id = $_POST['formulaire_id'];

    switch ($formulaire_id) {
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
