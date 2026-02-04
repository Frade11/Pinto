<?php include '../login/session.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
     <?php require '../includes/sidebar.php';?>
  <div class="main-container">
    <?php require '../includes/topnav.php';?>
        <div class="user-profile-info">
        <div class="user-avtar">
            <img src="<?= htmlspecialchars($_SESSION['avatar'] ?? '../assets/images/logo.jpg')  ?> " alt="user">
        </div>
        <div class="user-infos">
            <p class="username"><?= htmlspecialchars($_SESSION['name'] ?? '')  ?></p>
            <p class="email"><?= htmlspecialchars($_SESSION['email'] ?? '') ?></p>
        </div>
        <button class="edit-profile">Edit profile</button>
    </div>
    <h2 class="saved-posts">Saved posts</h2>
    <div class="posts-content">
    


 <?php
            require_once "../connection.php";
            
            // Количество постов на странице
            $postsPerPage = 50;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $postsPerPage;
            
            // Получаем посты с информацией о пользователе и медиа
            $sql = "
                SELECT 
                    p.id as post_id,
                    p.name as post_title,
                    p.description,
                    p.likes_count,
                    p.saves_count,
                    p.created_at,
                    u.id as user_id,
                    u.username,
                    u.avatar_url,
                    pm.type as media_type,
                    pm.source as media_source,
                    pm.file_path,
                    pm.url as media_url
                FROM posts p
                INNER JOIN users u ON p.user_id = u.id
                LEFT JOIN post_media pm ON p.id = pm.post_id
                WHERE pm.type = 'image'
                ORDER BY p.created_at DESC
                LIMIT ? OFFSET ?
            ";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $postsPerPage, $offset);
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
                    <a href="/view-post.php?id=' . $post['post_id'] . '" class="post">
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
                        <p>Be the first to create a post!</p>
                        <a href="../pages/create.php" style="display: inline-block; margin-top: 20px; padding: 12px 24px; background: #E60023; color: white; text-decoration: none; border-radius: 24px;">
                            Create Post
                        </a>
                      </div>';
            }
            
            $stmt->close();
            $conn->close();
            ?>

        </div>
    </div>
</div>
<!-- еси надо вывести создателя поста -->
        <!-- <div class="post-user">
            ' . (!empty($post['avatar_url']) ? 
                '<img src="' . htmlspecialchars($post['avatar_url']) . '" 
                        alt="' . htmlspecialchars($post['username']) . '" 
                        class="user-avatar">' : 
                '<div class="user-avatar" style="background: #ccc;"></div>') . '
            <span>' . htmlspecialchars($post['username']) . '</span>
        </div> -->
</body>
<script src="../assets/js/gallery_grid.js"></script>
</html>