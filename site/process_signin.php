<?php
    session_start();

    include("connection.php");
    $_SESSION['email']=$_POST['email'];


    $email = $_POST['email'];
    $password = $_POST['password'];

    $bdd = get_dbhandle();

    $req = $bdd->prepare("SELECT * FROM User WHERE Email = ?");
    $req->execute([$email]);
    $data = $req->fetch();
    $_SESSION['ID']=$data['ID'];
    if(empty($data)) {
        echo "Authentication failed!\nPlease try again <a href='signin.php'>Here</a>.";
        exit();
    }

    if (password_verify($password, $data['Password'])) {
        $req = $bdd->prepare("UPDATE User SET Last_login = NOW() WHERE Email = ?");
        $req->execute([$email]);

        if($data['Is_Admin']) {
            header("Location: admin/test.php");
        } else {
            header("Location: account.php");
        }
        exit();
    } else {
        echo "Authentication failed!\nPlease try again <a href='signin.php'>Here</a>.";
    }
?>