<?php
session_start();
header("Content-Type: application/json");
include("../users/db.php");

// Must be logged in
if (!isset($_SESSION["user_id"])) {
    echo json_encode(["success" => false, "error" => "Not logged in"]);
    exit();
}

// Must be rescuer
if ($_SESSION["role"] !== "rescuer") {
    echo json_encode(["success" => false, "error" => "Only rescuers can add adoption pets"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

$cat_name = $conn->real_escape_string($data["cat_name"]);
$age = intval($data["age"]);
$gender = $conn->real_escape_string($data["gender"]);
$description = $conn->real_escape_string($data["description"]);
$contactInfo = $conn->real_escape_string($data["contactInfo"]);

$user_id = $_SESSION["user_id"];

$sql = "
INSERT INTO cat_database
(cat_name, age, gender, description, contactInfo, owner_id, tag)
VALUES
('$cat_name', $age, '$gender', '$description', '$contactInfo', $user_id, 'adoption')
";

if ($conn->query($sql)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $conn->error]);
}
?>
