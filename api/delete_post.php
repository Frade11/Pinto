<?php
require_once "../connection.php";
session_start();

$userId = $_SESSION['user_id'] ?? 0;
if (!$userId) {
    die("Error: login to continue");
}
$postId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($postId <= 0) {
            echo "<h2 style='text-align:center;color:#999;margin-top:50px;'>Invalid post ID</h2>";
            exit;
        }

// Проверяем, принадлежит ли пост пользователю
$stmt = $conn->prepare("SELECT id FROM posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $postId, $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {  
    die("Error: You cannot delete this post");
}
$stmt->close();

$tables = ['post_tags', 'post_likes', 'saved_posts', 'post_media'];
foreach ($tables as $table) {
    $delStmt = $conn->prepare("DELETE FROM $table WHERE post_id = ?");
    $delStmt->bind_param("i", $postId);
    $delStmt->execute();
    $delStmt->close();
}

// Удаляем сам пост
$delPostStmt = $conn->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
$delPostStmt->bind_param("ii", $postId, $userId);
$delPostStmt->execute();
$delPostStmt->close();

$conn->close();

header("Location: ../pages/pins.php?tab=posts");
exit;
?>