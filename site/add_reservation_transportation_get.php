<?php

include("connection.php");

header("Content-Type: application/json");

if (isset($_GET["type"]) && isset($_GET["date"])) {
    $type = $_GET["type"];
    $date = $_GET["date"];

    // Database connection
    $bdd = get_dbhandle();
    $req = $bdd->prepare("
        SELECT Tp.ID, Tp.Address_Arrival_ID 
        FROM Transportation Tp 
        INNER JOIN Transportation_Type TpT ON Tp.Type_ID = TpT.ID 
        WHERE TpT.Name = 'Plane' AND DATE(Tp.Date_Departure) = '2024-11-08';
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