<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$fullName = htmlspecialchars($_SESSION["fullName"]);
$username = htmlspecialchars($_SESSION["username"]);
$email    = htmlspecialchars($_SESSION["email"]);
$bio      = htmlspecialchars($_SESSION["bio"]);
$role     = htmlspecialchars($_SESSION["role"]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link rel="stylesheet" href="cat.css">
</head>
<body>

<?php include("userProfile.html"); ?>

<script>
document.getElementById("nameField").innerText  = "Name: <?php echo $fullName; ?>";
document.getElementById("emailField").innerText = "Email: <?php echo $email; ?>";
document.getElementById("bioField").innerText   = "Bio: <?php echo $bio; ?>";
document.getElementById("roleField").innerText  = "Role: <?php echo $role; ?>";
</script>

</body>
</html>
