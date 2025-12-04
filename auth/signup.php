<?php
// signup.php

error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
include("../db.php");

// Only handle POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: signup.html");
    exit();
}

// 1. Get form data safely
$fullName = trim($_POST["fullName"]);
$username = trim($_POST["username"]);
$email    = trim($_POST["email"]);
$password = $_POST["password"];
$bio      = trim($_POST["bio"]);
$role     = $_POST["role"];  // 'owner' or 'rescuer'

// 2. Basic validation (server-side safety net)
if ($fullName === "" || $username === "" || $email === "" || $password === "" || $role === "") {
    echo "<p style='color:red;'>All fields except bio are required. Please go back and try again.</p>";
    exit();
}

// 3. Hash password (MD5 to match class examples)
$hashedPassword = md5($password);

// 4. Escape values for SQL
$fullName = $conn->real_escape_string($fullName);
$username = $conn->real_escape_string($username);
$email    = $conn->real_escape_string($email);
$bio      = $conn->real_escape_string($bio);
$role     = $conn->real_escape_string($role);

// 5. Check if username or email already exists
$checkSql = "
    SELECT user_id 
    FROM user_table
    WHERE username = '$username' OR email = '$email'
    LIMIT 1
";
$checkResult = $conn->query($checkSql);

if ($checkResult && $checkResult->num_rows > 0) {
    echo "<p style='color:red;'>Username or email already exists. Please go back and choose another.</p>";
    exit();
}

// 6. Insert new user into user_table
$insertSql = "
    INSERT INTO user_table (fullName, username, email, password, bio, role)
    VALUES ('$fullName', '$username', '$email', '$hashedPassword', '$bio', '$role')
";

if ($conn->query($insertSql) === TRUE) {
    // 7. On success, send them back to login page
    header("Location: login.html");
    exit();
} else {
    echo "<p style='color:red;'>Error creating account: " . $conn->error . "</p>";
}
?>
