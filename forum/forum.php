<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();                       

header('Content-Type: application/json');

require '../db.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'get_post':
        get_post($conn);
        break;

    case 'get_comments':
        get_comments($conn);
        break;

    case 'add_comment':
        add_comment($conn);
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
        break;
}

function get_post($conn)
{
    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
    if ($post_id <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid post_id']);
        return;
    }

    $sql = "SELECT 
                post_id,
                user_id,
                category,
                title,
                content AS body,  
                created
            FROM forum_posts
            WHERE post_id = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'DB error (prepare get_post): ' . $conn->error]);
        return;
    }

    $stmt->bind_param('i', $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();

    if (!$post) {
        http_response_code(404);
        echo json_encode(['error' => 'Post not found']);
        return;
    }

    echo json_encode($post);
}

function get_comments($conn)
{
    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
    if ($post_id <= 0) {
        echo json_encode([]);
        return;
    }

    $sql = "SELECT 
                comment_id,
                post_id,
                user_id,
                comment AS comment_text,
                created
            FROM forum_comments
            WHERE post_id = ?
            ORDER BY created ASC";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'DB error (prepare get_comments): ' . $conn->error]);
        return;
    }

    $stmt->bind_param('i', $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }

    echo json_encode($comments);
}

function add_comment($conn)
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'POST required']);
        return;
    }

    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $comment_text = isset($_POST['comment_text']) ? trim($_POST['comment_text']) : '';

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'You must be logged in to comment.']);
        return;
    }
    $user_id = (int) $_SESSION['user_id'];

    if ($post_id <= 0 || $comment_text === '') {
        http_response_code(400);
        echo json_encode(['error' => 'Missing data']);
        return;
    }

    $sql = "INSERT INTO forum_comments (post_id, user_id, comment)
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'DB error (prepare add_comment): ' . $conn->error]);
        return;
    }

    $stmt->bind_param('iis', $post_id, $user_id, $comment_text);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'comment_id' => $stmt->insert_id
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Insert failed: ' . $stmt->error]);
    }
}
