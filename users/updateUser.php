<?php
session_start();
include("../db.php");

if (!isset($_SESSION["user_id"])) {
    die("Not logged in");
}

$user_id = $_SESSION["user_id"];

$fullName = $conn->real_escape_string($_POST["fullName"]);
$bio      = $conn->real_escape_string($_POST["bio"]);
$pfPic    = intval($_POST["pfPicture"]);
$password = $_POST["password"];

// update base fields
$sql = "UPDATE user_table
        SET fullName = '$fullName',
            bio = '$bio',
            pfPicture = $pfPic
        WHERE user_id = $user_id";

$conn->query($sql);

// update password only if provided
if (!empty($password)) {
    $hashed = md5($password);
    $conn->query("UPDATE user_table SET password = '$hashed' WHERE user_id = $user_id");
}

header("Location: userProfile.html");
exit();
?>
