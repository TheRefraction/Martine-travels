<?php

$Last_name = $_POST['Last_name'];
$First_name = $_POST['First_name'];
$Phone = $_POST['Phone'];
$Email = $_POST['Email'];
$password = $_POST['password'];
$Birth_date = $_POST['Birth_date'];
$password_confirmation = $_POST['password_confirmation'];

if ($password !== $password_confirmation) {
    echo "Password are not the same. Try again.";
} else {
    $Password_confirmation = password_hash($password, PASSWORD_BCRYPT);

    $bdd = new PDO("mysql:host=localhost;dbname=Martine_travels;charset=utf8", "root", "");
    $req = $bdd->prepare("INSERT INTO User(First_name, Last_name, Email, Phone, Birth_date) VALUES (?,?,?,?,?);");

    $req->execute([$First_name, $Last_name, $Email, $Phone, $Birth_date]);
    echo "Inscription successful, you can go to the login page. ";
}
die();
?>