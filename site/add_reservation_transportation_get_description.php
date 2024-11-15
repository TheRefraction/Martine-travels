<?php
include("connection.php");

header("Content-Type: application/json");

$bdd = get_dbhandle();

// Cas 1 : Recherche par ID
if (isset($_GET["id"])) {
    $id = $_GET["id"];
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
        Provider.Name AS Provider,
        Tp.*
        FROM Transportation_Join Tj
        INNER JOIN Transportation Tp ON Tj.Transportation_ID = Tp.ID
        INNER JOIN Transportation_Type TpT ON Tp.Type_ID = TpT.ID
        INNER JOIN Address Ad_Arrival ON Tp.Address_Arrival_ID = Ad_Arrival.ID
        INNER JOIN Address Address_Departure ON Tp.Address_Depature_ID = Address_Departure.ID
        INNER JOIN Address_Country AS Address_Arrival_Country ON Address_Arrival_Country.ID = Ad_Arrival.Country_ID
        INNER JOIN Address_County AS Address_Arrival_County ON Address_Arrival_County.ID = Ad_Arrival.County_ID
        INNER JOIN Address_Town AS Address_Arrival_Town ON Address_Arrival_Town.ID = Ad_Arrival.Town_ID
        INNER JOIN Address_Street AS Address_Arrival_Street ON Address_Arrival_Street.ID = Ad_Arrival.Street_ID
        INNER JOIN Address_Country AS Address_Departure_Country ON Address_Departure_Country.ID = Address_Departure.Country_ID
        INNER JOIN Address_County AS Address_Departure_County ON Address_Departure_County.ID = Address_Departure.County_ID
        INNER JOIN Address_Town AS Address_Departure_Town ON Address_Departure_Town.ID = Address_Departure.Town_ID
        INNER JOIN Address_Street AS Address_Departure_Street ON Address_Departure_Street.ID = Address_Departure.Street_ID
        INNER JOIN Transportation_Provider AS Provider ON Tp.Provider_ID = Provider.ID
        WHERE Tj.Package_ID = :id;
    ");
    $req->execute(['id' => $id]);
    $data = $req->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);

// Cas 2 : Recherche par critères
} elseif (isset($_GET["type"], $_GET["departure"], $_GET["arrival"], $_GET["date"])) {
    $type = $_GET["type"];
    $departure = $_GET["departure"];
    $arrival = $_GET["arrival"];
    $date = $_GET["date"];

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
        Provider.Name AS Provider,
        Tp.*
        FROM Transportation Tp
        INNER JOIN Transportation_Type TpT ON Tp.Type_ID = TpT.ID
        INNER JOIN Address Ad_Arrival ON Tp.Address_Arrival_ID = Ad_Arrival.ID
        INNER JOIN Address Address_Departure ON Tp.Address_Depature_ID = Address_Departure.ID
        INNER JOIN Address_Country AS Address_Arrival_Country ON Address_Arrival_Country.ID = Ad_Arrival.Country_ID
        INNER JOIN Address_County AS Address_Arrival_County ON Address_Arrival_County.ID = Ad_Arrival.County_ID
        INNER JOIN Address_Town AS Address_Arrival_Town ON Address_Arrival_Town.ID = Ad_Arrival.Town_ID
        INNER JOIN Address_Street AS Address_Arrival_Street ON Address_Arrival_Street.ID = Ad_Arrival.Street_ID
        INNER JOIN Address_Country AS Address_Departure_Country ON Address_Departure_Country.ID = Address_Departure.Country_ID
        INNER JOIN Address_County AS Address_Departure_County ON Address_Departure_County.ID = Address_Departure.County_ID
        INNER JOIN Address_Town AS Address_Departure_Town ON Address_Departure_Town.ID = Address_Departure.Town_ID
        INNER JOIN Address_Street AS Address_Departure_Street ON Address_Departure_Street.ID = Address_Departure.Street_ID
        INNER JOIN Transportation_Provider AS Provider ON Tp.Provider_ID = Provider.ID
        WHERE 
           Tp.Address_Depature_ID = :departure AND 
           Tp.Address_Arrival_ID = :arrival AND 
           Tp.Type_ID = :type AND 
           DATE(Tp.Date_Departure) = :date;
    ");
    $req->execute([
        'departure' => $departure,
        'arrival' => $arrival,
        'type' => $type,
        'date' => $date,
    ]);
    $data = $req->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);

// Cas 3 : Paramètres manquants
} else {
    echo json_encode(["error" => "Missing parameters"]);
}
?>