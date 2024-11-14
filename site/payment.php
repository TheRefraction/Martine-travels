<?php
include("connection.php");

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: signin.php");
    exit();
}

$userID = $_SESSION['userID'];
$bdd = get_dbhandle();

$reservationQuery = $bdd->prepare();
$reservationQuery->execute([$userID]);
$reservation = $reservationQuery->fetch(PDO::FETCH_ASSOC);

if (!$reservation) {
    echo "No reservation found.";
    exit();
}

$reservationDataJson = json_encode($reservation);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings</title>
    <link href="css/style.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>
<body>
<h1>Status of your reservation</h1>
<button onclick="generatePDF()">Télécharger le reçu</button>

<script>
    const reservationData = <?= $reservationDataJson ?>;

    function generatePDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        doc.setFontSize(16);
        doc.text("Reçu de Voyage", 20, 20);

        const details = {
            "Nom du client": reservationData.client_name,
            "Destination": reservationData.destination,
            "Date de départ": reservationData.departure_date,
            "Date de retour": reservationData.return_date,
            "Prix": reservationData.price + "€"
        };
        let y = 40;
        doc.setFontSize(12);
        for (const [key, value] of Object.entries(details)) {
            doc.text(`${key}: ${value}`, 20, y);
            y += 10;
        }
        doc.save("Recu_voyage.pdf");
    }
</script>
</body>
</html>
