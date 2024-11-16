<?php include_once('header.php');?>
<?php
include("connection.php");

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['ID'])) {
    header("Location: signin.php");
    exit();
}

$userID = $_SESSION['ID'];
$bdd = get_dbhandle();

$reservationQuery = $bdd->prepare("SELECT 
    r.Client_ID,
    u.Last_Name,
    u.First_Name,
    r.Package_ID,
    pt.Name AS Package_Type,
    ac.Name AS Accommodation_Provider,
    rt.Name AS Room_Type,
    a.Check_In_Date,
    a.Check_Out_Date,
    a.Price_Per_Night,
    a.Booking_Status,
    addr_street.Name AS Street,
    addr_town.Name AS Town,
    addr_county.Name AS County,
    addr_country.Name AS Country,
    addr.Street_Num,
    t.Date_Departure,
    t.Date_Arrival,
    t.Ticket_Num,
    t.Ticket_Price,
    t.Seat_Num,
    tt.Name AS Transportation_Type,
    tp.Name AS Transportation_Provider,
    r.Status AS Reservation_Status
FROM 
    Reservation r
    JOIN User u ON r.Client_ID = u.ID
    JOIN Package p ON r.Package_ID = p.ID
    JOIN Package_Type pt ON p.Type_ID = pt.ID
    JOIN Address addr ON p.Address_ID = addr.ID
    JOIN Address_Street addr_street ON addr.Street_ID = addr_street.ID
    JOIN Address_Town addr_town ON addr.Town_ID = addr_town.ID
    JOIN Address_County addr_county ON addr.County_ID = addr_county.ID
    JOIN Address_Country addr_country ON addr.Country_ID = addr_country.ID
    JOIN Accommodation a ON r.Accommodation_ID = a.ID
    JOIN Accommodation_Provider ac ON a.Provider_ID = ac.ID
    JOIN Room_Type rt ON a.Room_Type_ID = rt.ID
    JOIN Transportation t ON r.Transportation_ID = t.ID
    JOIN Transportation_Type tt ON t.Type_ID = tt.ID
    JOIN Transportation_Provider tp ON t.Provider_ID = tp.ID
WHERE 
    r.Client_ID = ?
");
$reservationQuery->execute([$userID]);
$reservation = $reservationQuery->fetch(PDO::FETCH_ASSOC);

if (!$reservation) {
    echo "No reservation found.";
    exit();
}

$reservationDataJson = json_encode($reservation, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
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
<button onclick="generatePDF()">Download the receipt</button>

<script>
    const reservationData = <?= $reservationDataJson ?>;

    function generatePDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        doc.setFontSize(16);
        doc.text("Receipt", 20, 20);

        const details = {
            "Name of the client": reservationData.First_Name + " " + reservationData.Last_Name,
            "Type of the Package": reservationData.Package_Type,
            "Accommodation Provider and room type": reservationData.Accommodation_Provider + " - " + reservationData.Room_Type,
            "Check-In Date": reservationData.Check_In_Date,
            "Check-Out Date": reservationData.Check_Out_Date,
            "Price per Night": reservationData.Price_Per_Night + "€",
            "Status of the reservation": reservationData.Booking_Status,
            "Address": reservationData.Street_Num + " " + reservationData.Street + ", " + reservationData.Town + ", " + reservationData.County + ", " + reservationData.Country,
            "Departure date": reservationData.Date_Departure,
            "Arrival date": reservationData.Date_Arrival,
            "Transportation type": reservationData.Transportation_Type + " by " + reservationData.Transportation_Provider,
            "Ticket Number": reservationData.Ticket_Num,
            "Seat Number" : reservationData.Seat_Num
        };

        let y = 40;
        doc.setFontSize(12);
        for (const [key, value] of Object.entries(details)) {
            doc.text(`${key}: ${value}`, 20, y);
            y += 10;
        }
        doc.save("Receipt.pdf");
    }
</script>
</body>
</html>
