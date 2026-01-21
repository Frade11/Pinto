<?php
require_once "../connection.php";
session_start();

$userId = 1; // временно

$file = $_FILES['media_file'] ?? null;
$url  = trim($_POST['media_url'] ?? "");

// Проверка наличия медиа
if ((!$file || $file['error'] !== 0) && !$url) {
    exit("No media provided");
}

if ($file && $file['error'] === 0 && $url) {
    exit("Choose file OR url, not both");
}

// Начало транзакции
$conn->begin_transaction();

try {
    // 1. Создаем пост
    $stmt = $conn->prepare("INSERT INTO posts (user_id, name) VALUES (?, ?)");
    $postName = "Post name";
    $stmt->bind_param("is", $userId, $postName);
    $stmt->execute();
    $postId = $stmt->insert_id; // Получаем ID нового поста
    $stmt->close();

    /* ================= FILE UPLOAD ================= */
    if ($file && $file['error'] === 0) {
        $allowed = ['image/jpeg','image/png','image/webp'];
        if (!in_array($file['type'], $allowed)) {
            throw new Exception("Invalid image type");
        }

        $data = file_get_contents($file['tmp_name']);

        $stmt = $conn->prepare(
            "INSERT INTO post_media (post_id, type, source, mime_type, data)
             VALUES (?, 'image', 'upload', ?, ?)"
        );
        $null = NULL; // для blob
        $stmt->bind_param("iss", $postId, $file['type'], $null);
        // Используем send_long_data для BLOB
        $stmt->send_long_data(2, $data);
        $stmt->execute();
        $stmt->close();
    }

    /* ================= URL ================= */
    if ($url) {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception("Invalid URL");
        }

        $stmt = $conn->prepare(
            "INSERT INTO post_media (post_id, type, source, url)
             VALUES (?, 'image', 'url', ?)"
        );
        $stmt->bind_param("is", $postId, $url);
        $stmt->execute();
        $stmt->close();
    }

    $conn->commit();
    echo "Post created";

} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}
