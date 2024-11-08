<?php
include("connection.php");
if (isset($_GET["ID"])) {

    $transportation_ID = $_GET["ID"];
    $bdd = get_dbhandle();
    $req = $bdd->prepare("
            SELECT  Address_Country.Name as Country, Address_County.Name as County, Address_Town.Name as Town, Address_Street.Name as Street, Tp.*
            FROM Transportation Tp 
            INNER JOIN Transportation_Type TpT ON Tp.Type_ID = TpT.ID
            INNER JOIN Address Ad ON Tp.Address_Arrival_ID = Ad.ID
            INNER JOIN Address_Country ON   Address_Country.ID = Ad.Country_ID
            INNER JOIN Address_County ON   Address_County.ID = Ad.County_ID 
            INNER JOIN Address_Town ON   Address_Town.ID = Ad.Town_ID
            INNER JOIN Address_Street ON   Address_Street.ID = Ad.Street_ID
            WHERE Tp.ID = :ID;
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