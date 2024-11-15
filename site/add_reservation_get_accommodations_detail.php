<?php

include("connection.php");

header("Content-Type: application/json");

if (isset($_GET["accomodationprovider"])) {
    $accomodationprovider = $_GET["accomodationprovider"];

    // Connexion à la base de données
    $bdd = get_dbhandle();
    $req = $bdd->prepare("
    SELECT Ac.ID, Check_In_Date, Ac.Check_Out_Date, Ac.Price_Per_Night, Type.Name as Room_Type
    FROM `Accommodation` Ac
    INNER JOIN Accommodation_Type AS Type ON Ac.Room_Type_ID = Type.ID
    WHERE Provider_ID = :accomodationprovider AND Ac.Booking_Status = 0;
    ");

    $req->execute(['accomodationprovider' => $accomodationprovider]);

    // Récupération des résultats et envoi sous forme JSON
    $accommodations = $req->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($accommodations);
}
?>