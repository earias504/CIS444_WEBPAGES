<?php
header('Content-Type: application/json');

require '../db.php';

$category = isset($_GET['category']) ? trim($_GET['category']) : '';

if ($category === '') {
    echo json_encode([]);
    exit;
}

$sql = "SELECT post_id, user_id, category, title, body, created
        FROM forum_posts
        WHERE LOWER(TRIM(category)) = LOWER(TRIM(?))
        ORDER BY created DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $category);
$stmt->execute();
$result = $stmt->get_result();

$posts = [];
while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}

echo json_encode($posts);
