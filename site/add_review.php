<?php
include_once("connection.php");

if(session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['email'])) {
    header("Location: signin.php");
    exit();
}

$email = $_SESSION['email'];
$bdd = get_dbhandle();
$req = $bdd->prepare("SELECT First_name, ID FROM User WHERE Email = ?");
$req->execute([$email]);

$data = $req->fetch();
$userName = $data['First_name'];
$userID = $data['ID'];

$reservationID = isset($_POST['reservation_id']) ? $_POST['reservation_id'] : null;

if ($reservationID) {


    $reservationQuery = $bdd->prepare("SELECT Package_ID, Accommodation_ID, Transportation_ID FROM Reservation WHERE ID = ?");
    $reservationQuery->execute([$reservationID]);
    $reservation = $reservationQuery->fetch();


    if (!$reservation) {
        echo "Reservation not found.";
        exit();
    }

    $packageID = $reservation['Package_ID'];
    $accommodationID = $reservation['Accommodation_ID'];
    $transportationID = $reservation['Transportation_ID'];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        $rating = isset($_POST['rating']) ? $_POST['rating'] : '';

        if (empty($title) || empty($content) || empty($rating)) {
            echo "Please fill in all the fields.";
        } else {

            $insertReview = $bdd->prepare("INSERT INTO Review (User_ID, Package_ID, Transportation_ID, Accommodation_ID, Title, Content, Rating)
                                          VALUES (?, ?, ?, ?, ?, ?, ?)");
            $insertReview->execute([$userID, $packageID, $transportationID, $accommodationID, $title, $content, $rating]);

            echo "Review added successfully!";
            header("Location: account.php");
            exit();
        }
    }
} else {
    echo "Invalid reservation.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Review</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?php include_once('header.php');?>

<section class="login_section">
    <h1>Add a Review for Reservation <?php echo htmlspecialchars($reservationID); ?></h1>

    <form method="post" action="">
        <label for="title">Review Title:</label><br>
        <input type="text" name="title" id="title" required><br><br>

        <label for="content">Review Content:</label><br>
        <textarea name="content" id="content" rows="4" required></textarea><br><br>

        <label for="rating">Rating (1 to 5):</label><br>
        <input type="number" name="rating" id="rating" min="1" max="5" required><br><br>

        <input type="hidden" name="reservation_id" value="<?php echo $reservationID; ?>" />
        <input type="submit" value="Submit Review">
    </form>
</section>

</body>
</html>
