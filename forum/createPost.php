<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Start session and include database connection
session_start();
include("../db.php");

// 1. Only handle POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: forumTopic.html');
    exit();
}

// 2. Ensure user is logged in
if (!isset($_SESSION["user_id"])) {
    echo "<p style='color:red;'>You must be logged in to create a forum post.</p>";
    exit();
}

// 3. Prepare data
$userId = (int) $_SESSION["user_id"];
$title = trim($_POST["title"] ?? "");
$body = trim($_POST["body"] ?? "");
$category = trim($_POST["category"] ?? "");

// 4. Basic validation
if ($title === "" || $body === "") {
    echo "<p style='color:red;'>Title and content are required.</p>";
    exit();
}

// 5. Escape for SQL
$titleEsc = $conn->real_escape_string($title);
$bodyEsc = $conn->real_escape_string($body);
$categoryEsc = $conn->real_escape_string($category);

// 6. Insert (let `created` use DEFAULT CURRENT_TIMESTAMP)
$insertSql = "
    INSERT INTO forum_posts (user_id, title, content, category)
    VALUES (
        $userId,
        '$titleEsc',
        '$bodyEsc',
        '$categoryEsc'
    )
";

// 7. Execute and handle result
if ($conn->query($insertSql) === TRUE) {
    header("Location: forumTopic.html");
    exit();
} else {
    echo "<p style='color:red;'>Error creating post: " . $conn->error . "</p>";
}
?>