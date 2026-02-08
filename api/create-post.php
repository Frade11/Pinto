<?php
require_once "../connection.php";
session_start();

// Проверка авторизации
$userEmail = $_SESSION['email'] ?? null;
if (!$userEmail) {
    die("Error: login to continue");
}

// Проверка категории
if (empty($_POST['category_id'])) {
    die("Error: Category is required");
}
$categoryId = (int)$_POST['category_id'];

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



// $userId = 1; // временно

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
    $stmt = $conn->prepare("INSERT INTO posts (user_id, category_id, name, description) VALUES (?, ?, ?, ?)");
    $postName = $_POST['name'] ?? "Post name";
    $description = $_POST['description'] ?? "";
    $stmt->bind_param("iiss", $userId, $categoryId, $postName, $description);
    $stmt->execute();
    $postId = $stmt->insert_id;
    $stmt->close();

    // 2. Обработка медиа 
    if ($file && $file['error'] === 0) {
        $allowed = ['image/jpeg','image/png','image/webp','image/gif'];
        
        // Проверка типа файла
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mimeType, $allowed)) {
            throw new Exception("Invalid image type. Allowed: JPEG, PNG, WebP, GIF");
        }
        
        // Проверка размера (5MB максимум)
        $maxSize = 5 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            throw new Exception("File too large. Maximum size: 5MB");
        }
        
        // Создаем папку для загрузок с подпапками по дате
        $uploadDir = "../uploads/" . date('Y/m/d') . "/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Генерация безопасного имени файла
        $originalName = basename($file['name']);
        $safeName = preg_replace('/[^a-zA-Z0-9\._-]/', '', $originalName);
        $fileName = uniqid('img_') . '_' . $safeName;
        $filePath = $uploadDir . $fileName;
        
        // Перемещаем файл
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new Exception("Failed to save uploaded file");
        }
        
        // Вставляем запись в БД
        $stmt = $conn->prepare(
            "INSERT INTO post_media 
            (post_id, type, source, mime_type, file_path, original_name, file_size) 
            VALUES (?, 'image', 'upload', ?, ?, ?, ?)"
        );
        $relativePath = "uploads/" . date('Y/m/d') . "/" . $fileName;
        $stmt->bind_param("isssi", 
            $postId, 
            $mimeType, 
            $relativePath, 
            $originalName, 
            $file['size']
        );
        $stmt->execute();
        $stmt->close();
        
    } elseif ($url) {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception("Invalid URL format");
        }
        // Проверяем, что это изображение 
        $imageExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.webp', '.bmp'];
        $isImage = false;
        foreach ($imageExtensions as $ext) {
            if (stripos($url, $ext) !== false) {
                $isImage = true;
                break;
            }
        }
        
        if (!$isImage) {
            throw new Exception("URL must point to an image file (jpg, png, gif, webp, bmp)");
        }
        
        // Вставляем запись в БД
        $stmt = $conn->prepare(
            "INSERT INTO post_media 
            (post_id, type, source, url) 
            VALUES (?, 'image', 'url', ?)"
        );
        $stmt->bind_param("is", $postId, $url);
        $stmt->execute();
        $stmt->close();
    }
    
    // 3. Обработка тегов 
    if (!empty($_POST['tags'])) {
        $tags = explode(',', $_POST['tags']);
        $tags = array_map('trim', $tags);
        $tags = array_filter($tags);
        
        foreach ($tags as $tagName) {
            // Находим или создаем тег
            $stmt = $conn->prepare(
                "INSERT IGNORE INTO tags (name) VALUES (?)"
            );
            $stmt->bind_param("s", $tagName);
            $stmt->execute();
            
            // Получаем ID тега
            $tagStmt = $conn->prepare("SELECT id FROM tags WHERE name = ?");
            $tagStmt->bind_param("s", $tagName);
            $tagStmt->execute();
            $tagResult = $tagStmt->get_result();
            $tagRow = $tagResult->fetch_assoc();
            $tagStmt->close();
            
            if ($tagRow) {
                // Связываем тег с постом
                $linkStmt = $conn->prepare(
                    "INSERT IGNORE INTO post_tags (post_id, tag_id) VALUES (?, ?)"
                );
                $linkStmt->bind_param("ii", $postId, $tagRow['id']);
                $linkStmt->execute();
                $linkStmt->close();
            }
        }
    }
    
    $conn->commit();
    
    header("Location: ../pages/posts.php");
    exit();

} catch (Exception $e) {
    $conn->rollback();
    // Удаляем загруженный файл, если была ошибка после загрузки
    if (isset($filePath) && file_exists($filePath)) {
        unlink($filePath);
    }
    
    // Выводим понятную ошибку
    echo "<div style='padding: 20px; background: #fff0f0; border: 2px solid #ffcccc; border-radius: 8px; margin: 20px;'>";
    echo "<h3>Error creating post</h3>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    
    // Для отладки (уберите в продакшене)
    echo "<details style='margin-top: 15px;'>";
    echo "<summary>Debug info</summary>";
    echo "<pre>";
    echo "POST data: " . print_r($_POST, true) . "\n";
    echo "Files data: " . print_r($_FILES, true);
    echo "</pre>";
    echo "</details>";
    
    echo "<p><a href='javascript:history.back()'>Go back and try again</a></p>";
    echo "</div>";
}
?>