<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.html");
    exit();
}

$username = trim($_POST["username"]);
$password = md5($_POST["password"]); // MD5 to match DB hashes

// Query: allow login with username OR email
$sql = "
    SELECT user_id, fullName, username, email, role, bio
    FROM user_table
    WHERE (username = '$username' OR email = '$username')
      AND password = '$password'
    LIMIT 1
";

$result = $conn->query($sql);

if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Store user info in session
    $_SESSION["user_id"]  = $user["user_id"];
    $_SESSION["fullName"] = $user["fullName"];
    $_SESSION["username"] = $user["username"];
    $_SESSION["email"]    = $user["email"];
    $_SESSION["role"]     = $user["role"];
    $_SESSION["bio"]      = $user["bio"];

    header("Location: home.php");
    exit();
} else {
    echo "<p style='color:red;'>Invalid login. <a href='login.html'>Try again</a></p>";
}
?>
