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
        COALESCE(addr_country.Name, 'No Country') AS Country,
        COALESCE(addr_town.Name, 'No Town'),
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

$discountMessage = $loyaltyPoints > 15 ? "<p>You have more than 15 loyalty points! A 5% discount will be applied to your payment.</p>" : "";

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
    <h1>Select a Reservation and Payment Method</h1> <br>

    <?= $discountMessage ?>

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
                r.ID AS Reservation_ID,
                p.Price AS Price,
                pt.Name AS Package_Type
            FROM 
                Reservation r
            LEFT JOIN Package p ON r.Package_ID = p.ID
            LEFT JOIN Package_Type pt ON p.Type_ID = pt.ID
            WHERE r.ID = ?
        ");
        $reservationDetailsQuery->execute([$reservationID]);
        $reservation = $reservationDetailsQuery->fetch(PDO::FETCH_ASSOC);

        if (!$reservation) {
            echo "Reservation not found or already paid.";
            exit();
        }

        $price = $reservation['Price'];
        if ($loyaltyPoints > 15) {
            $price *= 0.95;
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

        echo "<p>Payment successful! Final amount paid: " . number_format($price, 2) . "€</p>";
    }
    ?>
</div>
</body>
</html>
