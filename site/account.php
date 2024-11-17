<?php
    include("connection.php");

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

    $ID = $_SESSION['ID'];
    $pdo = get_dbhandle();
    $stmt = $pdo->prepare("SELECT Is_Admin FROM User WHERE ID = :id");
    $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['Is_Admin'] == 1) {
        header("Location: admin/admin.php");
        exit();}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Martine Travels - My account</title>
        <link href ="css/style.css" rel="stylesheet">
    </head>

    <body>

        <?php include_once('header.php');?>

        <section class ="login_section">
            <h1>Welcome back <?php echo htmlspecialchars($userName);?>! Where would you like to go?</h1>
            <br>

            <form method="post" action="add_reservation.php">
                <label>
                    <input type="submit" name='home_ajout' value="Add a reservation" /><br>
                </label><br>

            </form>

                <h2>Your old reservations</h2>

                <?php


                $req = $bdd->prepare("SELECT Pa.Duration, Ac.Name, Pa.Price  FROM Reservation Re INNER JOIN Package Pa ON Re.Package_ID = Pa.ID INNER JOIN Address Ad ON Ad.ID = Pa.Address_ID INNER JOIN Address_Country Ac ON Ad.Country_ID = Ac.ID WHERE Re.Status = 3 AND Re.Client_ID=$userID;");
                $req->execute();

                ?>

            <table class="table_design">
                <thead>
                <tr>
                    <th>Destination</th>
                    <th>Duration</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php

                $req = $bdd->prepare("SELECT Re.ID as Reservation_ID, Pa.Duration, Ac.Name, Pa.Price 
                          FROM Reservation Re 
                          INNER JOIN Package Pa ON Re.Package_ID = Pa.ID 
                          INNER JOIN Address Ad ON Ad.ID = Pa.Address_ID 
                          INNER JOIN Address_Country Ac ON Ad.Country_ID = Ac.ID 
                          WHERE Re.Status = 3 AND Re.Client_ID = ?");
                $req->execute([$userID]);

                while($data = $req->fetch()) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data["Name"]); ?></td>
                        <td><?php echo htmlspecialchars($data["Duration"]); ?> days</td>
                        <td><?php echo htmlspecialchars($data["Price"]); ?>€</td>
                        <td>

                            <form method="post" action="add_review.php">

                                <input type="hidden" name="reservation_id" value="<?php echo $data['Reservation_ID']; ?>" />
                                <input type="submit" name="add_review" value="Add Review" />
                            </form>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>


        </section>
    </body>
</html>