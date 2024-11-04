<?php

include("connection.php");

header("Content-Type: application/json");

if (isset($_GET["pays"])) {
    $pays = intval($_GET["pays"]);  // Récupérer l'ID du pays de manière sécurisée

    // Connexion à la base de données
    $bdd = get_dbhandle();
    $req = $bdd->prepare("SELECT ID, Name FROM AccomodationProvider WHERE ID_Country = :pays;");
    $req->execute(['pays' => $pays]);

    // Récupération des résultats et envoi sous forme JSON
    $accommodations = $req->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($accommodations);
}
?>