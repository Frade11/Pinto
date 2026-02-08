 <?php
require_once "../connection.php";
echo ' <h2 class="saved-posts">Your posts</h2>
    <div class="posts-content">';
// Количество постов на странице
$postsPerPage = 50;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $postsPerPage;
$userId = $_SESSION['user_id']; 

$sql = "
SELECT 
    p.id AS post_id,
    p.name AS post_title,
    p.description,
    p.likes_count,
    p.saves_count,
    p.created_at,
    u.id AS user_id,
    u.username,
    u.avatar_url,
    pm.type AS media_type,
    pm.source AS media_source,
    pm.file_path,
    pm.url AS media_url,
    pm.mime_type
FROM posts AS p
INNER JOIN users AS u ON p.user_id = u.id
LEFT JOIN post_media AS pm 
    ON p.id = pm.post_id 
    AND pm.type = 'image'
WHERE p.user_id = ?
ORDER BY p.created_at DESC
LIMIT ? OFFSET ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iii",$userId, $postsPerPage, $offset);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    echo '<div class="post-grid">';
    
    while ($post = $result->fetch_assoc()) {
        // Определяем источник изображения
        $imgSrc = '';
        if ($post['media_source'] === 'upload' && !empty($post['file_path'])) {
            // Файл на сервере - добавляем / в начало для абсолютного пути
            $imgSrc = '/' . htmlspecialchars($post['file_path']);
        } elseif ($post['media_source'] === 'url' && !empty($post['media_url'])) {
            // Внешний URL
            $imgSrc = htmlspecialchars($post['media_url']);
        }
        
        // Форматируем дату
        $date = date('M d, Y', strtotime($post['created_at']));
        
        // Обрезаем заголовок если слишком длинный
        $title = htmlspecialchars($post['post_title']);
        if (strlen($title) > 50) {
            $title = substr($title, 0, 47) . '...';
        }
        
        echo '
        <a href="../pages/view-post.php?id=' . $post['post_id'] . '" class="post">
            <img src="' . $imgSrc . '" 
                    alt="' . htmlspecialchars($post['post_title']) . '" 
                    class="post-image"
                    onerror="this.src=\'../assets/images/banner.jpg\'">
            
            <div class="post-overlay">
                <div class="post-info">
                    <div class="post-title">' . $title . '</div>
                    
                </div>
            </div>
        </a>';
    }
    
    echo '</div>';
    
    // Пагинация
    $countSql = "SELECT COUNT(*) AS total FROM posts AS p INNER JOIN post_media AS pm ON p.id = pm.post_id WHERE p.user_id = ? AND pm.type = 'image'";
    $countStmt = $conn->prepare($countSql);
    $countStmt->bind_param("i", $userId);
    $countStmt->execute();
    $countResult = $countStmt->get_result();
    $totalPosts = $countResult->fetch_assoc()['total'] ?? 0;
    $countStmt->close();

    $totalPages = ceil($totalPosts / $postsPerPage);
    
  $currentTab = $_GET['tab']; 

if ($totalPages > 1) {
    echo '<div class="load-more">';
    if ($page > 1) {
        echo '<a href="?tab=' . $currentTab . '&page=' . ($page - 1) . '" class="load-more-btn">← Previous</a>';
    }
    echo '<span style="margin: 0 15px; color: #666;">Page ' . $page . ' of ' . $totalPages . '</span>';
    if ($page < $totalPages) {
        echo '<a href="?tab=' . $currentTab . '&page=' . ($page + 1) . '" class="load-more-btn">Next →</a>';
    }
    echo '</div>';
}

    
} else {
    echo '<div class="no-posts">
            <h2>You dont have any posts!</h2>
            <a href="../pages/create.php" style="display: inline-block; margin-top: 20px; padding: 12px 24px; background: #333; color: white; text-decoration: none; border-radius: 24px;">
                Create
            </a>
            </div>';
}

$stmt->close();
$conn->close();
?>