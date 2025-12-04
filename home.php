<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: shared/login.html");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Home Page</title>
  <link rel="stylesheet" href="shared/cat.css">
</head>

<body>
  <h1 class="app-title">Pawfect Central</h1>

  <header>
    <div class="header-content">
      <img src="images/catpic_left.png" class="header-cat">
      <h1>Home Page</h1>
      <img src="images/catpic_right.png" class="header-cat">
    </div>

    <div class="button-row">
      <a href="userProfile.php" class="tile">USER PROFILE</a>
      <a href="logout.php" class="tile">SIGN OUT</a>
    </div>
  </header>

  <div class="container">
    <div class="profile-section">
      <div class="user-info">
        <p class="user-name">
          <strong>Name:</strong> <?php echo $_SESSION["fullName"]; ?>
        </p>
      </div>
    </div>

    <h3>What do you want to do?</h3>

    <div class="main-buttons">
      <a href="donations.html" class="tile">DONATIONS</a>
      <a href="petDashboard.html" class="tile">PET DASHBOARD</a>
      <a href="forum.html" class="tile">FORUMS</a>
    </div>

    <div class="bottom-buttons">
      <a href="adoptions.html" class="tile">ADOPTIONS</a>
      <a href="resource.html" class="tile">RESOURCES</a>
    </div>
  </div>
</body>

</html>