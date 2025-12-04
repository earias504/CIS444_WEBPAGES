<?php
session_start();
include("../db.php");

// must be logged in
if (!isset($_SESSION["user_id"])) {
    http_response_code(403);
    echo json_encode(["error" => "Not logged in"]);
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT fullName, username, email, bio, role, pfPicture
        FROM user_table
        WHERE user_id = $user_id
        LIMIT 1";

$result = $conn->query($sql);

if ($result && $result->num_rows === 1) {
    echo json_encode($result->fetch_assoc());
} else {
    http_response_code(500);
    echo json_encode(["error" => "User not found"]);
}
?>
