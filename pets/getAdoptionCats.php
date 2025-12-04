<?php
include("../users/db.php");
header("Content-Type: application/json");

$sql = "SELECT * FROM cat_database WHERE tag='adoption'";
$result = $conn->query($sql);

$cats = [];
while ($row = $result->fetch_assoc()) {
    $cats[] = $row;
}

echo json_encode($cats);
?>
