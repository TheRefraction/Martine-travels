<?php

$Last_name = $_POST['Last_name'];
$First_name = $_POST['First_name'];
$Phone = $_POST['Phone'];
$Email = $_POST['Email'];
$password = $_POST['password'];
$Birth_date = $_POST['Birth_date'];
$password_confirmation = $_POST['password_confirmation'];

if ($password !== $password_confirmation) {
    echo "Password are not the same. \n";
    echo " Try again <a href='info_client.php'> Here </a>.";
} else {
    $Password_confirmation = password_hash($password, PASSWORD_BCRYPT);

    $bdd = new PDO("mysql:host=localhost;dbname=Martine_travels;charset=utf8", "root", "");
    $req = $bdd->prepare("INSERT INTO User(First_name, Last_name, Email, Phone, Birth_date) VALUES (?,?,?,?,?);");

    $req->execute([$First_name, $Last_name, $Email, $Phone, $Birth_date]);

    $User_ID = $bdd->lastInsertId();
    $req = $bdd->prepare("INSERT INTO Login(User_ID, Username, Password) VALUES (?,?,?);");
    $req->execute([$User_ID, $Email, $password_confirmation]);

    echo "Inscription successful, you can go to the  ";
    echo " <a href='login.php'> Login page </a>.";
}
die();
?>