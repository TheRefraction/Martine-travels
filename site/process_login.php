<?php
    $login = $_POST['login'];
    $password = $_POST['password'];
    $bdd = new PDO("mysql:host=83.113.214.244;dbname=martine_travels;charset=utf8", "martinesql", "martine");

    header("Location: home.php");

    exit();
?>
