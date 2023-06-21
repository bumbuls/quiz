<?php

$hostName= "localhost";
$userName= "root";
$password = "";
$database = "quiz";

$connection = mysqli_connect($hostName, $userName, $password, $database);

if (!$connection) {
    echo "Connection failed!";
}