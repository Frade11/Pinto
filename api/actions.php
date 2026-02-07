<?php
require_once "../connection.php";
require_once "../login/session.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';
$post_id = (int)($_POST['post_id'] ?? 0);

if ($post_id <= 0) {
    echo json_encode(['error' => 'Invalid post ID']);
    exit;
}

$response = [];

switch ($action) {
    case 'like':
        // Проверяем, есть ли лайк
        $stmt = $conn->prepare("SELECT 1 FROM post_likes WHERE user_id=? AND post_id=?");
        $stmt->bind_param("ii", $user_id, $post_id);
        $stmt->execute();
        $exists = $stmt->get_result()->num_rows > 0;
        $stmt->close();

        if ($exists) {
            // Удаляем лайк
            $conn->query("DELETE FROM post_likes WHERE user_id=$user_id AND post_id=$post_id");
            $conn->query("UPDATE posts SET likes_count = GREATEST(likes_count - 1, 0) WHERE id=$post_id");
            $response['liked'] = false;
        } else {
            // Добавляем лайк
            $conn->query("INSERT INTO post_likes (user_id, post_id) VALUES ($user_id, $post_id)");
            $conn->query("UPDATE posts SET likes_count = likes_count + 1 WHERE id=$post_id");
            $response['liked'] = true;
        }

        // Возвращаем обновленное количество
        $likes = $conn->query("SELECT likes_count FROM posts WHERE id=$post_id")->fetch_assoc()['likes_count'];
        $response['likes'] = $likes;
        break;

    case 'save':
        // Проверяем, есть ли сохранение
        $stmt = $conn->prepare("SELECT 1 FROM saved_posts WHERE user_id=? AND post_id=?");
        $stmt->bind_param("ii", $user_id, $post_id);
        $stmt->execute();
        $exists = $stmt->get_result()->num_rows > 0;
        $stmt->close();

        if ($exists) {
            // Удаляем из сохранённых
            $conn->query("DELETE FROM saved_posts WHERE user_id=$user_id AND post_id=$post_id");
            $conn->query("UPDATE posts SET saves_count = GREATEST(saves_count - 1, 0) WHERE id=$post_id");
            $response['saved'] = false;
        } else {
            // Добавляем в сохранённые
            $conn->query("INSERT INTO saved_posts (user_id, post_id) VALUES ($user_id, $post_id)");
            $conn->query("UPDATE posts SET saves_count = saves_count + 1 WHERE id=$post_id");
            $response['saved'] = true;
        }

        $saves = $conn->query("SELECT saves_count FROM posts WHERE id=$post_id")->fetch_assoc()['saves_count'];
        $response['saves'] = $saves;
        break;

    default:
        $response['error'] = 'Invalid action';
        break;
}

echo json_encode($response);
