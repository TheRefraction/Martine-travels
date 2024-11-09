<?php
include("connection.php");
if (isset($_GET["ID"])) {

    $transportation_ID = $_GET["ID"];
    $bdd = get_dbhandle();
    $req = $bdd->prepare("
            SELECT  
    Address_Arrival_Country.Name AS Arrival_Country, 
    Address_Arrival_County.Name AS Arrival_County, 
    Address_Arrival_Town.Name AS Arrival_Town, 
    Address_Arrival_Street.Name AS Arrival_Street,
    Address_Departure_Country.Name AS Departure_Country,
    Address_Departure_County.Name AS Departure_County,
    Address_Departure_Town.Name AS Departure_Town,
    Address_Departure_Street.Name AS Departure_Street,
    Tp.*
    FROM 
        Transportation Tp
    INNER JOIN 
        Transportation_Type TpT ON Tp.Type_ID = TpT.ID
    INNER JOIN 
        Address Ad_Arrival ON Tp.Address_Arrival_ID = Ad_Arrival.ID
    INNER JOIN 
        Address Address_Departure ON Tp.Address_Depature_ID = Address_Departure.ID
    INNER JOIN 
        Address_Country AS Address_Arrival_Country ON Address_Arrival_Country.ID = Ad_Arrival.Country_ID
    INNER JOIN 
        Address_County AS Address_Arrival_County ON Address_Arrival_County.ID = Ad_Arrival.County_ID
    INNER JOIN 
        Address_Town AS Address_Arrival_Town ON Address_Arrival_Town.ID = Ad_Arrival.Town_ID
    INNER JOIN 
        Address_Street AS Address_Arrival_Street ON Address_Arrival_Street.ID = Ad_Arrival.Street_ID
    INNER JOIN 
        Address_Country AS Address_Departure_Country ON Address_Departure_Country.ID = Address_Departure.Country_ID
    INNER JOIN 
        Address_County AS Address_Departure_County ON Address_Departure_County.ID = Address_Departure.County_ID
    INNER JOIN 
        Address_Town AS Address_Departure_Town ON Address_Departure_Town.ID = Address_Departure.Town_ID
    INNER JOIN 
        Address_Street AS Address_Departure_Street ON Address_Departure_Street.ID = Address_Departure.Street_ID
    WHERE 
        Tp.ID = :ID;
            ");

// Execute query with correct parameter names
    $req->execute(['ID' => $transportation_ID]);
    $data = $req->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
}
else {
    echo json_encode(["error" => "Missing ID parameter"]);
}

?>