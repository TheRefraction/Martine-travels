<?php
    function get_dbhandle(): PDO
    {
        $host = "90.100.91.219";
        $dbname = "martine_travels";
        $dbuser = "martinesql";
        $dbpasswd = "martine";
        return new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpasswd);
    }
?>
