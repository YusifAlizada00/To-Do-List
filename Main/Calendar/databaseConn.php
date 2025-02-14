<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$database = "login";

$conn = new mysqli($serverName, $userName, $password, $database);

if($conn->connect_error)
{
    die("Connection error " . $conn->connect_error);
}
?>