<?php 

    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "clients_info";

    $con = mysqli_connect($host, $user, $pass, $dbname);

    if(!$con) {
        die('Connection failed: ' . mysqli_connect_error());
    }
?>
