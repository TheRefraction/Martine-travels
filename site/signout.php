<?php
    session_start();
    session_unset();
    $_SESSION = array();
    header("Location: index.php");
?>