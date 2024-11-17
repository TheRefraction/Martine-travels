<?php
include_once('header.php');
include_once("connection.php");

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['ID'])) {
    header("Location: signin.php");
    exit();
}
    $ID = $_SESSION['ID'];
    $pdo = get_dbhandle();
    $stmt = $pdo->prepare("SELECT Is_Admin FROM User WHERE ID = :id");
    $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['Is_Admin'] == 1) {
        header("Location: admin/admin.php");
        exit();}
$userID = $_SESSION['ID'];
$bdd = get_dbhandle();

$reservationQuery = $bdd->prepare("
    SELECT 
        r.ID AS Reservation_ID,
        pt.Name AS Package_Type,
        COALESCE(addr_country.Name, 'No Country') AS Country,
        COALESCE(addr_town.Name, 'No Town') AS Town,
        COALESCE(p.Duration, 0) AS Duration,
        COALESCE(p.Price, 0) AS Price
    FROM 
        Reservation r
    LEFT JOIN Package p ON r.Package_ID = p.ID
    LEFT JOIN Package_Type pt ON p.Type_ID = pt.ID
    LEFT JOIN Address addr ON p.Address_ID = addr.ID
    LEFT JOIN Address_Country addr_country ON addr.Country_ID = addr_country.ID
    LEFT JOIN Address_Town addr_town ON addr.Town_ID = addr_town.ID
    WHERE 
        r.Client_ID = ? AND r.Status = 0
");
$reservationQuery->execute([$userID]);
$reservations = $reservationQuery->fetchAll(PDO::FETCH_ASSOC);

$paymentMethodsQuery = $bdd->prepare("SELECT ID, Name FROM Payment_Method");
$paymentMethodsQuery->execute();
$paymentMethods = $paymentMethodsQuery->fetchAll(PDO::FETCH_ASSOC);

$loyaltyPointsQuery = $bdd->prepare("SELECT Loyalty_Points FROM User WHERE ID = ?");
$loyaltyPointsQuery->execute([$userID]);
$user = $loyaltyPointsQuery->fetch(PDO::FETCH_ASSOC);
$loyaltyPoints = $user['Loyalty_Points'];

$discountMessage = $loyaltyPoints > 15
    ? "<p style='color: #9e03e1;'>You have more than 15 loyalty points! A 5% discount will be applied to your payment.</p>"
    : "";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<div class="payment-container">
    <h1>Select a reservation and payment method</h1><br>

    <?= $discountMessage ?>

    <?php
    if (empty($reservations)) {
        echo "<p>No reservations available for payment.</p>";
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
            echo "Please select a reservation and a payment method.";
            exit();
        }

        $reservationDetailsQuery = $bdd->prepare("
            SELECT 
                r.ID AS Reservation_ID,
                COALESCE(pt.Name, 'No package type') AS Package_Type,
                COALESCE(ac.Name, 'No accommodation provider') AS Accommodation_Provider,
                COALESCE(rt.Name, 'No room type') AS Room_Type,
                COALESCE(tp.Name, 'No transportation provider') AS Transportation_Provider,
                COALESCE(tt.Name, 'No transportation type') AS Transportation_Type,
                COALESCE(addr_country.Name, 'No country') AS Country,
                COALESCE(addr_town.Name, 'No town') AS Town,
                COALESCE(p.Duration, 0) AS Duration,
                COALESCE(p.Price, 0) AS Price
            FROM 
                Reservation r
            LEFT JOIN Package p ON r.Package_ID = p.ID
            LEFT JOIN Package_Type pt ON p.Type_ID = pt.ID
            LEFT JOIN Address addr ON p.Address_ID = addr.ID
            LEFT JOIN Address_Country addr_country ON addr.Country_ID = addr_country.ID
            LEFT JOIN Address_Town addr_town ON addr.Town_ID = addr_town.ID
            LEFT JOIN Accommodation a ON r.Accommodation_ID = a.ID
            LEFT JOIN Accommodation_Provider ac ON a.Provider_ID = ac.ID
            LEFT JOIN Room_Type rt ON a.Room_Type_ID = rt.ID
            LEFT JOIN Transportation t ON r.Transportation_ID = t.ID
            LEFT JOIN Transportation_Type tt ON t.Type_ID = tt.ID
            LEFT JOIN Transportation_Provider tp ON t.Provider_ID = tp.ID
            WHERE r.ID = ?
        ");
        $reservationDetailsQuery->execute([$reservationID]);
        $reservation = $reservationDetailsQuery->fetch(PDO::FETCH_ASSOC);

        if (!$reservation) {
            echo "Reservation not found or already paid.";
            exit();
        }

        $price = $reservation['Price'];
        $discountApplied = false;

        if ($loyaltyPoints > 15) {
            $price *= 0.95;
            $discountApplied = true;
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

        $reservationDataJson = json_encode(array_merge($reservation, [
            'Final_Price' => $price,
            'Discount_Applied' => $discountApplied ? "Yes" : "No"
        ]), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

        $paymentMethodName = $paymentMethod['Name'];
        ?>

        <p>Payment successful! Final amount paid: <?= number_format($price, 2) ?>€</p>
        <button onclick="generatePDF()">Download Receipt</button>

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
                    "Package Type": reservationData.Package_Type || "Unknown",
                    "Accommodation & Room Type":
                        (reservationData.Accommodation_Provider || "Unknown") + " - " +
                        (reservationData.Room_Type || "Unknown"),
                    "Country": reservationData.Country || "Unknown",
                    "Town": reservationData.Town || "Unknown",
                    "Duration": reservationData.Duration || 0,
                    "Price (Original)": reservationData.Price + "€",
                    "Discount Applied": reservationData.Discount_Applied || "No",
                    "Final Price": reservationData.Final_Price + "€",
                    "Payment Method": paymentMethodName || "Unknown"
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
</div>
</body>
</html>
