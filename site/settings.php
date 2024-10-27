<?php
    include("connection.php");

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $phone = $_POST['phone'];
    $passwd = $_POST['passwd'];

    $bdd = get_dbhandle();

    $req = $bdd->prepare("UPDATE * FROM User WHERE Email = ?");
    $req->execute([$email]);
    $data = $req->fetch();


?>
