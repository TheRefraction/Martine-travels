<?php
    include("connection.php");

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $phone = $_POST['phone'];
    $passwd = $_POST['passwd'];
    $passwd_conf = $_POST['passwd_conf'];

    if ($passwd <> $passwd_conf) {
        echo "Passwords are not the same. \n";
        echo " Please try again <a href='signup.html'> Here </a>.";

    } else {
        $bdd = get_dbhandle();

        $passwd_conf = password_hash($passwd, PASSWORD_BCRYPT);

        $req = $bdd->prepare("INSERT INTO User(First_name, Last_name, Email, Password, Phone, Birth_date) VALUES (?,?,?,?,?,?);");

        $req->execute([$fname, $lname, $email, $passwd_conf, $phone, $birthday]);

        echo "Registration successful.";
        echo "You may now <a href='login.html'>log into your account</a>.";
    }
    die();
?>