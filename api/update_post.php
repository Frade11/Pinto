<?php
require_once "../connection.php";
session_start();

// Проверка авторизации
$userEmail = $_SESSION['email'] ?? null;
if (!$userEmail) {
    die("Error: login to continue");
}

$postId = $_POST['post_id'];
$userId = $_SESSION['user_id'] ?? 0; 
$postName = $_POST['post_name'] ?? "Post name";
$description = $_POST['post_description'] ?? "";
$categoryId = $_POST['post_category'] ?? 0;

if ($postId <= 0) die("Error: Invalid post ID");
if (empty($postName)) die("Error: Post name is required");

// Проверка категории
if (!isset($_POST['post_category']) || !is_numeric($_POST['post_category']) || intval($_POST['post_category']) <= 0) {
    die("Error: Category is required");
}
$categoryId = intval($_POST['post_category']);

$categoryId = (int)$_POST['post_category'];

// Проверяем существование категории
$checkCat = $conn->prepare("SELECT id FROM categories WHERE id = ?");
$checkCat->bind_param("i", $categoryId);
$checkCat->execute();
$checkCat->store_result();

if ($checkCat->num_rows === 0) {
    die("Error: Selected category does not exist");
}
$checkCat->close();

// Получаем ID пользователя
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $userId = $row['id'];
} else {
    die("Error: user not found");
}
$stmt->close();



$stmt = $conn->prepare("
    UPDATE posts
    SET name = ?, description = ?, category_id = ?
    WHERE id = ? AND user_id = ?
");
$stmt->bind_param("ssiis", $postName, $description, $categoryId, $postId, $userId);
$stmt->execute();
$stmt->close();

// теги
if (isset($_POST['post_tags'])) {
    $tags = explode(',', $_POST['post_tags']);
    $tags = array_map('trim', $tags);
    $tags = array_filter($tags);

    // Удаляем все текущие теги поста
    $delStmt = $conn->prepare("DELETE FROM post_tags WHERE post_id = ?");
    $delStmt->bind_param("i", $postId);
    $delStmt->execute();
    $delStmt->close();

    // Добавляем новые теги
    foreach ($tags as $tagName) {
        // Создаем тег, если его нет
        $stmt = $conn->prepare("INSERT IGNORE INTO tags (name) VALUES (?)");
        $stmt->bind_param("s", $tagName);
        $stmt->execute();
        $stmt->close();

        // Получаем ID тега
        $tagStmt = $conn->prepare("SELECT id FROM tags WHERE name = ?");
        $tagStmt->bind_param("s", $tagName);
        $tagStmt->execute();
        $tagResult = $tagStmt->get_result();
        $tagRow = $tagResult->fetch_assoc();
        $tagStmt->close();

        if ($tagRow) {
            // Связываем тег с постом
            $linkStmt = $conn->prepare("INSERT INTO post_tags (post_id, tag_id) VALUES (?, ?)");
            $linkStmt->bind_param("ii", $postId, $tagRow['id']);
            $linkStmt->execute();
            $linkStmt->close();
        }
    }
}
header("Location: ../pages/pins.php?tab=posts");
    exit();
?>