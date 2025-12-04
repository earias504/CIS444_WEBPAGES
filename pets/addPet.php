<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Start session and include database connection
session_start();
include("../db.php");


// 1. Only handle POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: addPet.html');
    exit();
}
// 2. Ensure user is logged in
if (!isset($_SESSION["user_id"])) {
    echo "<p style='color:red;'>You must be logged in to add a pet.</p>";
    exit();
}

// 3. Prepare data
$ownerId = (int) $_SESSION["user_id"];

$petName = trim($_POST["pet_name"] ?? "");
$petAge = trim($_POST["pet_age"] ?? "");
$petWeight = trim($_POST["pet_weight"] ?? "");
$petMedical = trim($_POST["pet_medical"] ?? "");
$petGender = $_POST["pet_gender"] ?? "Unknown";



// Validate required fields
if ($petName === "") {
    echo "<p style='color:red;'>Pet name is required. Please go back and try again.</p>";
    exit();
}

$petName = trim($_POST["pet_name"] ?? "");
$petAge = trim($_POST["pet_age"] ?? "");
$petWeight = trim($_POST["pet_weight"] ?? "");
$petMedical = trim($_POST["pet_medical"] ?? "");
$petGender = $_POST["pet_gender"] ?? "Unknown";

$ageSql = ($petAge === "") ? "NULL" : (int) $petAge;
$weightSql = ($petWeight === "") ? "NULL" : (float) $petWeight;

$photoSql = "NULL"; // default if no image uploaded

if (!empty($_FILES['pet_pic']['name'])) {

    // 1. Check for upload errors first
    if ($_FILES['pet_pic']['error'] !== UPLOAD_ERR_OK) {
        // For debugging you can echo this; for now we'll just skip saving
        // echo "<p>Upload error code: " . $_FILES['pet_pic']['error'] . "</p>";
        // exit();
    } else {

        // 2. Filesystem folder: /group1/pets/uploadsDir/
        $uploadsDir = __DIR__ . "/uploadsDir/";

        // (Optional) try to create if missing
        if (!is_dir($uploadsDir)) {
            if (!mkdir($uploadsDir, 0775, true)) {
                // echo "<p>Failed to create uploads directory.</p>";
                // exit();
            }
        }

        $fileName   = time() . "_" . basename($_FILES['pet_pic']['name']);
        $targetPath = $uploadsDir . $fileName;

        // Path to store in DB (relative for <img src>)
        $relativePath = "uploadsDir/" . $fileName;

        if (move_uploaded_file($_FILES['pet_pic']['tmp_name'], $targetPath)) {
            // Success: save relative path in DB
            $photoPathEscaped = $conn->real_escape_string($relativePath);
            $photoSql = "'$photoPathEscaped'";
        } else {
            // Debug helper: uncomment while testing
            // echo "<p>move_uploaded_file failed. Target: $targetPath</p>";
            // exit();
        }
    }
}



// 5. Insert
$insertSql = "
    INSERT INTO cat_database
        (owner_id, pet_name, age, weight, gender, medical_notes, photo, intake_date)
    VALUES (
        $ownerId,
        '$petName',
        $ageSql,
        $weightSql,
        '$petGender',
        '$petMedical',
        $photoSql,
        NOW()
    )
";

// 6. Execute and handle result
if ($conn->query($insertSql) === TRUE) {
    header("Location: petDashboard.html");
    exit();
} else {
    echo "<p style='color:red;'>Error adding pet: " . $conn->error . "</p>";
}

?>