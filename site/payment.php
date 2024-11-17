<?php
include_once('header.php');
include_once("connection.php");

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['ID'])) {
    header("Location: signin.php");
    exit();
}

$userID = $_SESSION['ID'];
$bdd = get_dbhandle();

$reservationQuery = $bdd->prepare("
    SELECT 
        r.ID AS Reservation_ID,
        pt.Name AS Package_Type,
        addr_country.Name AS Country,
        addr_town.Name AS Town,
        p.Duration,
        p.Price
    FROM 
        Reservation r
    JOIN Package p ON r.Package_ID = p.ID
    JOIN Package_Type pt ON p.Type_ID = pt.ID
    JOIN Address addr ON p.Address_ID = addr.ID
    JOIN Address_Country addr_country ON addr.Country_ID = addr_country.ID
    JOIN Address_Town addr_town ON addr.Town_ID = addr_town.ID
    WHERE 
        r.Client_ID = ? AND r.Status = 0
");
$reservationQuery->execute([$userID]);
$reservations = $reservationQuery->fetchAll(PDO::FETCH_ASSOC);

$paymentMethodsQuery = $bdd->prepare("SELECT ID, Name FROM Payment_Method");
$paymentMethodsQuery->execute();
$paymentMethods = $paymentMethodsQuery->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<h1>Select a Reservation and Payment Method</h1> <br>

<?php
if (empty($reservations)) {
    echo "<p>No reservations available to pay.</p>";
} else {
    ?>

    <form action="" method="POST">
        <label for="reservation">Choose a reservation:</label>
        <select name="reservation_id" id="reservation">
            <option value="NULL">-- Select a reservation --</option>
            <?php
            foreach ($reservations as $reservation) {
                echo '<option value="' . $reservation["Reservation_ID"] . '">' .
                    $reservation["Package_Type"] . ' - ' .
                    $reservation["Country"] . ' - ' .
                    $reservation["Town"] . ' - ' .
                    $reservation["Duration"] . ' days - ' .
                    $reservation["Price"] . '€' .
                    '</option>';
            }
            ?>
        </select>

        <br><br>

        <label for="payment_method">Choose a payment method:</label>
        <select name="payment_method" id="payment_method">
            <option value="NULL">-- Select a payment method --</option>
            <?php
            foreach ($paymentMethods as $method) {
                echo '<option value="' . $method["ID"] . '">' . $method["Name"] . '</option>';
            }
            ?>
        </select>

        <br><br>

        <input type="submit" name="submit" value="Pay" />
    </form>

    <?php
}

if (isset($_POST['submit'])) {
    $reservationID = $_POST['reservation_id'];
    $paymentMethodID = $_POST['payment_method'];

    if ($reservationID === 'NULL' || $paymentMethodID === 'NULL') {
        echo "Please select both a reservation and a payment method.";
        exit();
    }

    $reservationDetailsQuery = $bdd->prepare("
        SELECT 
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
            r.ID = ? AND r.Status = 0
    ");
    $reservationDetailsQuery->execute([$reservationID]);
    $reservation = $reservationDetailsQuery->fetch(PDO::FETCH_ASSOC);

    if (!$reservation) {
        echo "Reservation not found or already paid.";
        exit();
    }

    $paymentMethodQuery = $bdd->prepare("SELECT Name FROM Payment_Method WHERE ID = ?");
    $paymentMethodQuery->execute([$paymentMethodID]);
    $paymentMethod = $paymentMethodQuery->fetch(PDO::FETCH_ASSOC);

    if (!$paymentMethod) {
        echo "Invalid payment method.";
        exit();
    }

    $updateUserQuery = $bdd->prepare("UPDATE User SET Loyalty_Points = Loyalty_Points + 1 WHERE ID = ?");
    $updateUserQuery->execute([$userID]);

    $updateReservationQuery = $bdd->prepare("UPDATE Reservation SET Status = 3 WHERE ID = ?");
    $updateReservationQuery->execute([$reservationID]);

    $reservationDataJson = json_encode($reservation, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    $paymentMethodName = $paymentMethod['Name'];
    ?>

    <button onclick="generatePDF()">Download the receipt</button>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script>
        const reservationData = <?= $reservationDataJson ?>;
        const paymentMethodName = <?= json_encode($paymentMethodName) ?>;

        function generatePDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            doc.setFontSize(16);
            doc.text("Receipt", 20, 20);

            const details = {
                "Client Name": reservationData.First_Name + " " + reservationData.Last_Name,
                "Package Type": reservationData.Package_Type,
                "Accommodation Provider and Room Type": reservationData.Accommodation_Provider + " - " + reservationData.Room_Type,
                "Check-In Date": reservationData.Check_In_Date,
                "Check-Out Date": reservationData.Check_Out_Date,
                "Price per Night": reservationData.Price_Per_Night + "€",
                "Booking Status": reservationData.Booking_Status,
                "Address": reservationData.Street_Num + " " + reservationData.Street + ", " + reservationData.Town + ", " + reservationData.County + ", " + reservationData.Country,
                "Departure Date": reservationData.Date_Departure,
                "Arrival Date": reservationData.Date_Arrival,
                "Transportation Type": reservationData.Transportation_Type + " by " + reservationData.Transportation_Provider,
                "Ticket Number": reservationData.Ticket_Num,
                "Seat Number": reservationData.Seat_Num,
                "Payment Method": paymentMethodName
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

    <?php
}
?>

</body>
</html>
