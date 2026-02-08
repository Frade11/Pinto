 <?php
require_once "../connection.php";
echo ' <h2 class="saved-posts">Saved posts</h2>
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
        pm.url AS media_url
    FROM post_likes sp
    INNER JOIN posts p ON sp.post_id = p.id
    INNER JOIN users u ON p.user_id = u.id
    LEFT JOIN post_media pm ON p.id = pm.post_id
    WHERE sp.user_id = ? AND pm.type = 'image'
    ORDER BY sp.created_at DESC
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
    $countSql = "SELECT COUNT(*) as total 
                    FROM post_media 
                    WHERE type = 'image'";
    $countResult = $conn->query($countSql);
    $totalPosts = $countResult->fetch_assoc()['total'];
    $totalPages = ceil($totalPosts / $postsPerPage);
    
    if ($totalPages > 1) {
        echo '<div class="load-more">';
        if ($page > 1) {
            echo '<a href="?page=' . ($page - 1) . '" class="load-more-btn">← Previous</a> ';
        }
        echo '<span style="margin: 0 15px; color: #666;">Page ' . $page . ' of ' . $totalPages . '</span>';
        if ($page < $totalPages) {
            echo '<a href="?page=' . ($page + 1) . '" class="load-more-btn">Next →</a>';
        }
        echo '</div>';
    }
    
} else {
    echo '<div class="no-posts">
            <h2>No posts yet</h2>
            <a href="../pages/posts.php" style="display: inline-block; margin-top: 20px; padding: 12px 24px; background: #E60023; color: white; text-decoration: none; border-radius: 24px;">
                explore
            </a>
            </div>';
}

$stmt->close();
$conn->close();
?>