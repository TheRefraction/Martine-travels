<?php

$name = $_POST['name'];
$first_name = $_POST['first_name'];
$phone_number = $_POST['phone_number'];
$email = $_POST['email'];
$password = $_POST['password'];

$bdd = new PDO("mysql:host=localhost;dbname=account;charset=utf8", "root", "");
$req = $bdd->prepare("INSERT INTO client(name, first_name, phone_number, email, password) VALUES (?,?,?,?,?);");

$req->execute([$name, $first_name,$phone_number,$email,$password]);

die();
?>