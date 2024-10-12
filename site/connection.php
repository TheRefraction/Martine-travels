<?php
    function get_dbhandle()
    {
        $host = "90.125.194.95";
        $dbname = "martine_travels";
        $dbuser = "martinesql";
        $dbpasswd = "martine";
        return new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpasswd);
    }
?>