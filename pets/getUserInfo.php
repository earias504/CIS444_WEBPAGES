<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "not_logged_in"]);
    exit;
}

require_once("../db.php");

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT fullName, username, email, bio, role, pfPicture
                        FROM user_table WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

echo json_encode($user);
?>
