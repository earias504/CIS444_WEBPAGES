<?php
session_start();
include("../db.php");

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit();
}


$userId = (int) $_SESSION["user_id"];
$catId  = isset($_POST["cat_id"]) ? (int) $_POST["cat_id"] : 0;

if ($catId <= 0) {
    echo json_encode(["success" => false, "message" => "Invalid cat id"]);
    exit();
}


// Delete ONLY if this cat belongs to this user
$sql = "
    DELETE FROM cat_database
    WHERE cat_id = $catId
      AND owner_id = $userId
";



if ($conn->query($sql) === TRUE) {
    if ($conn->affected_rows > 0) {
        echo json_encode(["success" => true]);
    } else {
        // No row deleted = cat doesn't belong to this user or doesn't exist
        echo json_encode(["success" => false, "message" => "Pet not found or not yours"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "DB error: " . $conn->error]);
}


?>