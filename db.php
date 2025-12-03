<?php
$servername = "localhost";
$username   = "group1";
$password   = "c96f9v9o";
$dbname     = "group1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
