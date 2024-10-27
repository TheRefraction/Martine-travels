<?php
    include("connection.php");
    $_SESSION['email']=$_POST['email'];

    $email = $_POST['email'];
    $password = $_POST['password'];

    $bdd = get_dbhandle();

    $req = $bdd->prepare("SELECT * FROM User WHERE Email = ?");
    $req->execute([$email]);
    $data = $req->fetch();

    if(empty($data)) {
        echo "Authentification failed!\nPlease try again <a href='signin.html'>Here</a>.";
        exit();
    }

    if (password_verify($password, $data['Password'])) {
        $req = $bdd->prepare("UPDATE User SET Last_login = NOW() WHERE Email = ?");
        $req->execute([$email]);

        if($data['Is_admin']) {
            header("Location: admin.html");
        } else {
            header("Location: home.html");
        }
    } else {
        echo "Authentification failed!\nPlease try again <a href='signin.html'>Here</a>.";
    }
?>