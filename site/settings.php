<?php
    include("connection.php");
    session_start();
    if (!isset($_SESSION['email'])) {
        header("Location: signin.html");
        exit();
    }
    $bdd = get_dbhandle();
    $email = $_SESSION['email'];

    $req = $bdd->prepare("SELECT * FROM User WHERE Email = ?");
    $req->execute([$email]);
    $data = $req->fetch();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $lname = $_POST['lname'];
        $birthday = $_POST['birthday'];
        $phone = $_POST['phone'];
        $passwd = $_POST['passwd'];


        $updateReq = $bdd->prepare("UPDATE User SET LastName = ?, Birthdate = ?, PhoneNumber = ?, Password = ? WHERE Email = ?");
        $updateReq->execute([$lname, $birthday, $phone, password_hash($passwd, PASSWORD_DEFAULT), $email]);


        exit();
    }

    ?>