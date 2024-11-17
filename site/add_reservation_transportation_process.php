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
    $reservation_id = $_POST['reservation'];

    if (isset($reservation_id)){
        if(isset($_POST['transportation_id'])){

            $req = $bdd->prepare("
            UPDATE Reservation
            SET Transportation_ID = :transportation_id
            WHERE ID = :reservation_id;
            ");
            $req->execute(['transportation_id' => $_POST['transportation_id'], 'reservation_id' => $reservation_id]);
            header("Location:payment.php");
            exit;
        }
    }














}
























?>