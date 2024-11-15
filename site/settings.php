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

if (!$userData) {
    echo "User data not found.";
    exit();
}

$prefReq = $bdd->prepare("SELECT Transportation_Type.Name, Transportation_Preferences.Transport_ID FROM Transportation_Preferences 
    JOIN Transportation_Type ON Transportation_Preferences.Transport_ID = Transportation_Type.ID
    WHERE Transportation_Preferences.User_ID = ?");
$prefReq->execute([$ID]);
$currentPreferences = $prefReq->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['transportation_form']) && !isset($_POST['delete_preference'])) {

    $lname = $_POST['lname'];
    $birthday = $_POST['birthday'];
    $phone = $_POST['phone'];
    $passwd = $_POST['passwd'];
    $fname = $_POST['fname'];
    $email = $_POST['email'];

    if (empty($lname) || empty($birthday) || empty($phone) || empty($fname) || empty($email)) {
        echo "Cannot have empty fields (except for password) in this form!";
        exit();
    }

    if (!empty($passwd)) {
        $hashedPassword = password_hash($passwd, PASSWORD_DEFAULT);
        $updateReq = $bdd->prepare("UPDATE User SET Password = ? WHERE ID = ?");
        $updateReq->execute([$hashedPassword, $ID]);
    }

    $updateReq = $bdd->prepare("UPDATE User SET Email = ?, First_name = ?, Last_name = ?, Birth_date = ?, Phone = ? WHERE ID = ?");
    $updateReq->execute([$email, $fname, $lname, $birthday, $phone, $ID]);

    echo "Your information has been updated successfully.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['transportation_form'])) {
    $transportID = $_POST['type_transportation'];

    $verification = $bdd->prepare("SELECT COUNT(*) FROM Transportation_Preferences WHERE User_ID = ? AND Transport_ID = ?");
    $verification->execute([$ID, $transportID]);
    $exists = $verification->fetchColumn();

    if ($exists) {
        echo "This transportation preference has already been added.";
    } elseif ($transportID != "NULL") {
        $insertReq = $bdd->prepare("INSERT INTO Transportation_Preferences (User_ID, Transport_ID) VALUES (?, ?)");
        $insertReq->execute([$ID, $transportID]);
        header("location:settings.php");
    } else {
        echo "Please select a valid transportation type.";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_preference'])) {
    $transportIDToDelete = $_POST['delete_preference'];

    $deleteReq = $bdd->prepare("DELETE FROM Transportation_Preferences WHERE User_ID = ? AND Transport_ID = ?");
    $deleteReq->execute([$ID, $transportIDToDelete]);

    header("location:settings.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings</title>
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
<?php include_once('header.php');?>


<section class="login_section">
    <h1>Modification of your personal data</h1>
    <form method="post" action="settings.php">
        <label>
            Email: <input type="email" name="email" class="input-field" required="required" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" value="<?= htmlspecialchars($userData['Email']) ?>" />
        </label> <br>
        <label>
            Last name: <input type="text" name="lname" class="input-field" required="required" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\-]+" title="Must contain only letters or hyphens" value="<?= htmlspecialchars($userData['Last_Name']) ?>" />
        </label> <br>
        <label>
            First name: <input type="text" name="fname" class="input-field" required="required" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\-]+" title="Must contain only letters or hyphens" value="<?= htmlspecialchars($userData['First_Name']) ?>" />
        </label> <br>
        <label>
            Birthdate: <input type="date" id="birthday" name="birthday" class="input-field" required="required" min="1900-01-01" value="<?= htmlspecialchars($userData['Birth_Date']) ?>" />
        </label> <br>
        <label>
            Phone number: <input type="tel" name="phone" class="input-field" required="required" value="<?= htmlspecialchars($userData['Phone']) ?>" />
        </label> <br>
        <label>
            Change Password: <input type="text" name="passwd" placeholder="only to change password" class="input-field" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,128}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" />
        </label> <br>
        <br>
        <input type="submit" value="Update Information"/>
    </form>

    <h1>Transportation Preferences</h1>
    <form method="post" action="settings.php">
        <input type="hidden" name="transportation_form" value="1"/>
        <label for="type_transportation">Choose your preferred type of transportation:</label><br>
        <select id="type_transportation" name="type_transportation">
            <option value="NULL">-- Select an option --</option>

            <?php
            $req = $bdd->prepare("SELECT * FROM Transportation_Type;");
            $req->execute();

            while ($data = $req->fetch()) {
                $selected = "";
                $isSelected = false;
                foreach ($currentPreferences as $pref) {
                    if ($pref['Transport_ID'] == $data['ID']) {
                        $isSelected = true;
                        break;
                    }
                }
                if ($isSelected) {
                    $selected = "selected";
                }

                echo '<option value="' . htmlspecialchars($data["ID"]) . '" ' . $selected . '>' . htmlspecialchars($data["Name"]) . '</option>';
            }
            ?>
        </select><br><br>
        <input type="submit" value="Add Preference"/>
    </form>

    <h2>Your Actual Transportation Preferences:</h2>
    <ul>
        <?php
        if (empty($currentPreferences)) {
            echo "<li>No preferences selected yet.</li>";
        } else {
            foreach ($currentPreferences as $preference) {
                echo "<li>" . htmlspecialchars($preference['Name']) .
                    ' <form method="post" action="settings.php" style="display:inline;">
                    <input type="hidden" name="delete_preference" value="' . htmlspecialchars($preference['Transport_ID']) . '"/>
                    <input type="submit" value="Delete"/>
                    </form></li>';
            }
        }
        ?>
    </ul>
</section>
</body>
</html>
