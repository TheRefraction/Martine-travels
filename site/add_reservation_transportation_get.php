<?php

include("connection.php");

header("Content-Type: application/json");

if (isset($_GET["type"])) {
    $type = $_GET["type"];
    $date = isset($_GET["date"]) ? $_GET["date"] : null;
    $departure = isset($_GET["departure"]) ? $_GET["departure"] : null;

    $sql = "
    SELECT  Address_Country.Name as Country, Address_County.Name as County, Address_Town.Name as Town, Address_Street.Name as Street, Tp.ID
    FROM Transportation Tp 
    INNER JOIN Transportation_Type TpT ON Tp.Type_ID = TpT.ID 
    INNER JOIN Address Ad ON Tp.Address_Arrival_ID = Ad.ID
    INNER JOIN Address_Country ON Address_Country.ID = Ad.Country_ID
    INNER JOIN Address_County ON Address_County.ID = Ad.County_ID 
    INNER JOIN Address_Town ON Address_Town.ID = Ad.Town_ID
    INNER JOIN Address_Street ON Address_Street.ID = Ad.Street_ID
    WHERE TpT.ID = :type
    ";

    // Si la variable $date n'est pas vide, on ajoute la condition de date
    if (!empty($date)) {
        $sql .= " AND DATE(Tp.Date_Departure) = :date;";
    }
    else{
        $sql .= " AND Tp.Address_Depature_ID = :departure;";
    }



    // Database connection
    $bdd = get_dbhandle();
    $req = $bdd->prepare($sql);

    // Execute query with correct parameter names
    if (!empty($date)) {
        $req->execute(['type' => $type, 'date' => $date]);
    }
    else{
        $req->execute(['type' => $type, 'departure' => $departure ]);
    }

    // Fetch results and output as JSON
    $transportation = $req->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($transportation);
} else {
    echo json_encode(["error" => "Missing 'type' or 'date' parameter"]);
}

?>