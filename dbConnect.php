<?php

    $serverName = "localhost";
    $dbUserName = "root";
    $dbPassword = "";
    $dbName = "tltd";
    $msg = "";


    $conn = new mysqli($serverName, $dbUserName, $dbPassword, $dbName);

    if($conn->connect_error)
    {
        die("****** Connection Failed!".$conn->connect_error);
    }

?>