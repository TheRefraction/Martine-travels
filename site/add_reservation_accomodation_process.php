<?php

include("connection.php");
$bdd = get_dbhandle();

if(session_status() === PHP_SESSION_NONE) session_start();


if (!isset($_SESSION['email'])) {
    header("Location: signin.php");
    exit();
}
else{
    $req = $bdd->prepare("SELECT ID FROM User WHERE Email = :email");
    $req->execute(['email' => $_SESSION['email']]);
    $data = $req->fetch();

    if (!$data) {
        header("Location: signin.php?error=user_not_found");
        exit();
    }

    $user = $data['ID'];
}

//ADD the RESERVATION with the post method
//IF ADD TRANSPORTATION go to add_reservation_transportation.php
//ELSE go to payment



if(isset($_POST["options"]) and $_POST["options"] == "premade"){

    $package  = $_POST["package_choice"];
    $req = $bdd->prepare("
    INSERT INTO Reservation
    VALUES (NULL, :id, :package,NULL,NULL,0);
    ");
    $req->execute(array('id' => $user, 'package' => $package));

    $newReservationId = $bdd->lastInsertId();

    if (isset($_POST["premade_next_transportation"])) {
        // Si l'utilisateur veut ajouter un transport
        header("Location:add_reservation_transportation.php?id=" . $newReservationId);
    } elseif (isset($_POST["premade_next_no"])) {
        // Si l'utilisateur ne veut pas ajouter un transport
        header("Location:payment.php");
    }

    exit;
}

if(isset($_POST["options"]) and $_POST["options"] == "custom"){

    $accomodation_detail=$_POST["accomodation_detail"];
    $req = $bdd->prepare("
    INSERT INTO Reservation
    VALUES (NULL, :id, NULL,NULL,:accomodation,0);
    ");
    $req->execute(array('id' => $user, 'accomodation' => $accomodation_detail));

    $newReservationId = $bdd->lastInsertId();


    if(isset($_POST["transportation_header"])){
        header("Location:add_reservation_transportation.php?id=" . $newReservationId);
    }
    elseif (isset($_POST["custom_no_transportation"])) {
        header("Location:payment.php");
    }
    exit;
}


if (!isset($_POST["options"])) {
    header("Location: signin.php?error=user_not_found");
    exit();
}















?>
