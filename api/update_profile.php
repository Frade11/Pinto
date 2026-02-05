<?php
session_start();
require_once '../connection.php';

header('Content-Type: application/json');

if(!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'message' => 'Not loget']);
    exit;
}

// Получаем данные из POST
$nickname = trim($_POST['nickname'] ?? '');
$avatar = trim($_POST['avatar'] ?? '');

if(empty($nickname) && empty($avatar)) {
    echo json_encode(['success' => false, 'message' => 'Where is no data to update']);
    exit;
}

$email = $_SESSION['email']; // идентифицируем пользователя по email

$updates = [];
if($nickname !== '') {
    $updates[] = "username = ?";
}
if($avatar !== '') {
    $updates[] = "avatar_url = ?";
}
// Тут сохраняю данные для дальнейшей замены и использования
$params = [];
if($nickname !== '') $params[] = $nickname;
if($avatar !== '') $params[] = $avatar;

// Добавляем email в параметры для WHERE
$params[] = $email;

$sql = "UPDATE users SET ".implode(", ", $updates)." WHERE email = ?";

// Используем подготовленные выражения для безопасности
$stmt = $conn->prepare($sql);
if(!$stmt){
    echo json_encode(['success' => false, 'message' => 'Request error']);
    exit;
}

// Динамическое связывание параметров
$types = str_repeat('s', count($params)); // все строки
$stmt->bind_param($types, ...$params);

if($stmt->execute()) {
    // Обновляем сессию
    if($nickname !== '') $_SESSION['name'] = $nickname;
    if($avatar !== '') $_SESSION['avatar'] = $avatar;

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database update error']);
}

$stmt->close();
$conn->close();
?>
