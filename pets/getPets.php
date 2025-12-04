<?php
session_start();
include("../db.php");

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["error" => "not_logged_in"]);
    exit();
}

$userId = (int) $_SESSION["user_id"];

$sql = "
    SELECT cat_id, pet_name, age, weight, gender, photo
    FROM cat_database
    WHERE owner_id = $userId
    ORDER BY created DESC
";

$result = $conn->query($sql);

$pets = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pets[] = $row;
    }
}

echo json_encode($pets);
?>
