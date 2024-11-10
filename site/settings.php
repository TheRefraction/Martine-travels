<?php
    include("connection.php");

    if(session_status() === PHP_SESSION_NONE) session_start();

    if (!isset($_SESSION['email'])) {
        header("Location: signin.php");
        exit();
    }

    $ID = $_SESSION['ID'];

    $bdd = get_dbhandle();
    $req = $bdd->prepare("SELECT * FROM User WHERE ID = ?");
    $req->execute([$ID]);
    $userData = $req->fetch();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $lname = $_POST['lname'];
        $birthday = $_POST['birthday'];
        $phone = $_POST['phone'];
        $passwd = $_POST['passwd'];
        $fname = $_POST['fname'];
        $email = $_POST['email'];

        if (empty($lname) || empty($birthday) || empty($phone) || empty($fname) || empty($email) ){
            echo "Cannot have empty fields (except for password) in this form!";
            exit();
        }

        if (!empty($passwd)){
            $hashedPassword = password_hash($passwd, PASSWORD_DEFAULT);
            $updateReq = $bdd->prepare("UPDATE User SET Password = ? WHERE ID = ?");
            $updateReq->execute([$hashedPassword]);
        }


        $updateReq = $bdd->prepare("UPDATE User SET Email = ?, First_name = ?, Last_name = ?, Birth_date = ?, Phone = ? WHERE ID = ?");
        $updateReq->execute([$email, $fname, $lname, $birthday, $phone, $ID]);

        echo "Your information has been updated successfully.";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Settings</title>
        <link href ="css/style.css" rel="stylesheet">
    </head>

    <body>
        <?php include_once('header.php');?>

        <section class=login_section>
            <h1>Modification of your personal data</h1>

            <form method="post" action="settings.php">
                <label>
                    Last name : <input type="text"  name="lname" class="input-field" required="required" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\-]+" title ="Must contain only letters or hyphens" value="<?= htmlspecialchars($userData['Last_name']) ?>" />
                </label> <br>

                <label>
                    First name : <input type="text"  name="fname" class="input-field" required="required" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\-]+" title ="Must contain only letters or hyphens" value="<?= htmlspecialchars($userData['First_name']) ?>" />
                </label> <br>

                <label>
                    Email : <input type="email" name="email" class="input-field" required="required" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" value="<?= htmlspecialchars($userData['Email']) ?>" />
                </label> <br>

                <label>
                    Birthdate : <input type="date"  id="birthday" name="birthday" class="input-field" required="required" min="1900-01-01" value="<?= htmlspecialchars($userData['Birth_date']) ?>"/>
                </label> <br>

                <label>
                    Phone number : <input type="tel"  name="phone" class="input-field" required="required" value="<?= htmlspecialchars($userData['Phone']) ?>"/>
                </label> <br>

                <label>
                    Change Password : <input type="text" name="passwd" placeholder="only to change password" class="input-field"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,128}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" />
                </label> <br>

                <br>
                <input type="submit" value="Confirmation"/>

            </form>
        </section>
    </body>
</html>