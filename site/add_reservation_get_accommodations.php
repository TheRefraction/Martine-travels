<?php

include("connection.php");

header("Content-Type: application/json");

if (isset($_GET["pays"])) {
    $pays = intval($_GET["pays"]);  // Récupérer l'ID du pays de manière sécurisée

    // Connexion à la base de données
    $bdd = get_dbhandle();
    $req = $bdd->prepare("SELECT ap.ID, ap.Name FROM Accomodation_Provider ap INNER JOIN Adress Ad ON ap.Address_ID = Ad.ID HAVING Country_ID = :pays;");
    $req->execute(['pays' => $pays]);

    // Récupération des résultats et envoi sous forme JSON
    $accommodations = $req->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($accommodations);
}
?>