<?php
    include("connection.php");

    $login = $_POST['login'];
    $password = $_POST['password'];

    $bdd = get_dbhandle();

    header("Location: home.html");

    exit();
?>