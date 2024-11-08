<?php

include("connection.php");

header("Content-Type: application/json");

if (isset($_GET["type"]) && isset($_GET["date"])) {
    $type = $_GET["type"];
    $date = $_GET["date"];

    // Database connection
    $bdd = get_dbhandle();
    $req = $bdd->prepare("
            SELECT  Address_Country.Name as Country, Address_County.Name as County, Address_Town.Name as Town, Address_Street.Name as Street, Tp.ID
            FROM Transportation Tp 
            INNER JOIN Transportation_Type TpT ON Tp.Type_ID = TpT.ID 
            INNER JOIN Address Ad ON Tp.Address_Arrival_ID = Ad.ID
            INNER JOIN Address_Country ON   Address_Country.ID = Ad.Country_ID
            INNER JOIN Address_County ON   Address_County.ID = Ad.County_ID 
            INNER JOIN Address_Town ON   Address_Town.ID = Ad.Town_ID
            INNER JOIN Address_Street ON   Address_Street.ID = Ad.Street_ID
            WHERE TpT.ID = :type AND DATE(Tp.Date_Departure) = :date;
    ");

    // Execute query with correct parameter names
    $req->execute(['type' => $type, 'date' => $date]);

    // Fetch results and output as JSON
    $transportation = $req->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($transportation);
} else {
    echo json_encode(["error" => "Missing 'type' or 'date' parameter"]);
}

?>