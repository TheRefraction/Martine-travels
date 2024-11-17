<?php
    session_start();

    include_once("connection.php");



    $email = $_POST['email'];
    $password = $_POST['password'];

    $bdd = get_dbhandle();

    $req = $bdd->prepare("SELECT * FROM User WHERE Email = ?");
    $req->execute([$email]);
    $data = $req->fetch();

    if(empty($data)) {
        echo "Authentication failed!\nPlease      try again <a href='signin.php'>Here</a>.";
        exit();
    }

    if (password_verify($password, $data['Password'])) {
        $req = $bdd->prepare("UPDATE User SET Last_login = NOW() WHERE Email = ?");
        $req->execute([$email]);
        $_SESSION['email']=$_POST['email'];
        $_SESSION['ID']=$data['ID'];
        if($data['Is_Admin']) {
            header("Location: admin/admin.php");
        } else {
            header("Location: account.php");
        }
        exit();
    } else {
        echo "Authentication fuyailed!\nPlease try again <a href='signin.php'>Here</a>.";
    }
?>