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
        
        <div class="posts-content">
            <?php
            require_once "../connection.php";
            
            $postsPerPage = 50;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $postsPerPage;
            
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
                $allPosts = $result->fetch_all(MYSQLI_ASSOC);
                $mainPost = $allPosts[0];
                $otherPosts = array_slice($allPosts, 1);
                
                // Разделяем посты: 30% слева, 70% справа
                $leftCount = ceil(count($otherPosts) * 0.3);
                $rightCount = count($otherPosts) - $leftCount;
                
                $leftPosts = array_slice($otherPosts, 0, $leftCount);
                $rightPosts = array_slice($otherPosts, $leftCount, $rightCount);
                
                // Основной пост
                $mainImgSrc = '';
                if ($mainPost['media_source'] === 'upload' && !empty($mainPost['file_path'])) {
                    $mainImgSrc = '/' . htmlspecialchars($mainPost['file_path']);
                } elseif ($mainPost['media_source'] === 'url' && !empty($mainPost['media_url'])) {
                    $mainImgSrc = htmlspecialchars($mainPost['media_url']);
                }
                
                $mainDate = date('M d, Y', strtotime($mainPost['created_at']));
                ?>
                
                <div class="posts-layout">
                    <div class="main-post-container">
                        <!-- Основной пост -->
                        <a href="/view-post.php?id=<?= $mainPost['post_id'] ?>" class="main-post">
                            <div class="main-post-image-container">
                                <img src="<?= $mainImgSrc ?>" 
                                     alt="<?= htmlspecialchars($mainPost['post_title']) ?>" 
                                     class="main-post-image"
                                     onerror="this.src='../assets/images/banner.jpg'">
                            </div>
                            
                            <div class="main-post-content">
                                <div class="main-post-user">
                                    <?php if (!empty($mainPost['avatar_url'])): ?>
                                        <img src="<?= htmlspecialchars($mainPost['avatar_url']) ?>" 
                                             alt="<?= htmlspecialchars($mainPost['username']) ?>" 
                                             class="main-post-avatar">
                                    <?php else: ?>
                                        <div class="main-post-avatar" style="background: #ccc;"></div>
                                    <?php endif; ?>
                                    <span style="font-weight: 600; color: #fff;"><?= htmlspecialchars($mainPost['username']) ?></span>
                                </div>
                                
                                <h1 class="main-post-title"><?= htmlspecialchars($mainPost['post_title']) ?></h1>
                                <?php if (!empty($mainPost['description'])): ?>
                                    <div class="main-post-description"><?= htmlspecialchars($mainPost['description']) ?></div>
                                <?php endif; ?>
                                
                                <div class="main-post-meta">
                                    <div class="main-post-stats">
                                        <span><?= $mainPost['likes_count'] ?> likes</span>
                                        <span><?= $mainPost['saves_count'] ?> saves</span>
                                        <span><?= $mainDate ?></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        
                        <!-- Левая колонка постов (под основным для десктопа) -->
                        <div class="masonry-grid" id="leftMasonry">
                            <?php foreach ($leftPosts as $post): ?>
                                <?php
                                $imgSrc = '';
                                if ($post['media_source'] === 'upload' && !empty($post['file_path'])) {
                                    $imgSrc = '/' . htmlspecialchars($post['file_path']);
                                } elseif ($post['media_source'] === 'url' && !empty($post['media_url'])) {
                                    $imgSrc = htmlspecialchars($post['media_url']);
                                }
                                
                                $title = htmlspecialchars($post['post_title']);
                                if (strlen($title) > 50) {
                                    $title = substr($title, 0, 47) . '...';
                                }
                                ?>
                                <a href="/view-post.php?id=<?= $post['post_id'] ?>" class="post">
                                    <img src="<?= $imgSrc ?>" 
                                         alt="<?= htmlspecialchars($post['post_title']) ?>" 
                                         class="post-image"
                                         onerror="this.src='../assets/images/banner.jpg'">
                                    
                                    <div class="post-overlay">
                                        <div class="post-info">
                                            <div class="post-title"><?= $title ?></div>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Все посты для мобильных -->
                        <div class="left-bottom-posts" id="mobileMasonry" style="display: none;">
                            <div class="masonry-grid">
                                <?php foreach ($otherPosts as $post): ?>
                                    <?php
                                    $imgSrc = '';
                                    if ($post['media_source'] === 'upload' && !empty($post['file_path'])) {
                                        $imgSrc = '/' . htmlspecialchars($post['file_path']);
                                    } elseif ($post['media_source'] === 'url' && !empty($post['media_url'])) {
                                        $imgSrc = htmlspecialchars($post['media_url']);
                                    }
                                    
                                    $title = htmlspecialchars($post['post_title']);
                                    if (strlen($title) > 50) {
                                        $title = substr($title, 0, 47) . '...';
                                    }
                                    ?>
                                    <a href="/view-post.php?id=<?= $post['post_id'] ?>" class="post">
                                        <img src="<?= $imgSrc ?>" 
                                             alt="<?= htmlspecialchars($post['post_title']) ?>" 
                                             class="post-image"
                                             onerror="this.src='../assets/images/banner.jpg'">
                                        
                                        <div class="post-overlay">
                                            <div class="post-info">
                                                <div class="post-title"><?= $title ?></div>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Правая колонка постов (только для десктопа) -->
                    <div class="right-posts-column">
                        <div class="masonry-grid" id="rightMasonry">
                            <?php foreach ($rightPosts as $post): ?>
                                <?php
                                $imgSrc = '';
                                if ($post['media_source'] === 'upload' && !empty($post['file_path'])) {
                                    $imgSrc = '/' . htmlspecialchars($post['file_path']);
                                } elseif ($post['media_source'] === 'url' && !empty($post['media_url'])) {
                                    $imgSrc = htmlspecialchars($post['media_url']);
                                }
                                
                                $title = htmlspecialchars($post['post_title']);
                                if (strlen($title) > 30) {
                                    $title = substr($title, 0, 27) . '...';
                                }
                                ?>
                                <a href="/view-post.php?id=<?= $post['post_id'] ?>" class="post">
                                    <img src="<?= $imgSrc ?>" 
                                         alt="<?= htmlspecialchars($post['post_title']) ?>" 
                                         class="post-image"
                                         onerror="this.src='../assets/images/banner.jpg'">
                                    
                                    <div class="post-overlay">
                                        <div class="post-info">
                                            <div class="post-title"><?= $title ?></div>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <?php
                // Пагинация
                $countSql = "SELECT COUNT(*) as total FROM post_media WHERE type = 'image'";
                $countResult = $conn->query($countSql);
                $totalPosts = $countResult->fetch_assoc()['total'];
                $totalPages = ceil($totalPosts / $postsPerPage);
                
                if ($totalPages > 1): ?>
                    <div class="load-more" style="margin-top: 30px; text-align: center;">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?= $page - 1 ?>" class="load-more-btn" style="padding: 10px 20px; background: #3a3a3a; color: #fff; border-radius: 8px; text-decoration: none; margin: 0 10px;">← Previous</a>
                        <?php endif; ?>
                        <span style="margin: 0 15px; color: #aaa;">Page <?= $page ?> of <?= $totalPages ?></span>
                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $page + 1 ?>" class="load-more-btn" style="padding: 10px 20px; background: #3a3a3a; color: #fff; border-radius: 8px; text-decoration: none; margin: 0 10px;">Next →</a>
                        <?php endif; ?>
                    </div>
                <?php endif;
                
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
</body>
<script>
// Универсальная функция masonry (такая же как в gallery_grid.js)
function masonryLayout(container) {
    if (!container) return;
    
    const items = Array.from(container.children);
    const containerWidth = container.clientWidth;
    
    // Тот же алгоритм расчета колонок
    let columns = 6;
    if (window.innerWidth > 1200) columns = Math.floor(containerWidth / 200);
    if (window.innerWidth <= 1200) columns = 5;
    if (window.innerWidth <= 768) columns = 3;
    if (window.innerWidth <= 480) columns = 2;
    
    // Минимум 1 колонка
    columns = Math.max(1, columns);
    
    const columnHeights = new Array(columns).fill(0);
    const columnWidth = containerWidth / columns;

    items.forEach(item => {
        item.style.width = columnWidth + 'px';

        const minColumn = columnHeights.indexOf(Math.min(...columnHeights));

        const x = minColumn * columnWidth;
        const y = columnHeights[minColumn];

        item.style.transform = `translate(${x}px, ${y}px)`;

        columnHeights[minColumn] += item.offsetHeight;
    });

    container.style.height = Math.max(...columnHeights) + 'px';
}

// Управление отображением в зависимости от ширины экрана
function setupResponsiveLayout() {
    const isDesktop = window.innerWidth > 1200;
    console.log('Setting up layout for:', isDesktop ? 'desktop' : 'mobile', 'width:', window.innerWidth);
    
    if (isDesktop) {
        // Десктоп: показываем две колонки
        document.getElementById('leftMasonry').style.display = 'block';
        document.getElementById('rightMasonry').parentElement.style.display = 'block';
        document.getElementById('mobileMasonry').style.display = 'none';
        
        // Применяем masonry к обеим колонкам
        setTimeout(() => {
            masonryLayout(document.getElementById('leftMasonry'));
            masonryLayout(document.getElementById('rightMasonry'));
        }, 100);
    } else {
        // Мобильные: показываем все посты в одной колонке
        document.getElementById('leftMasonry').style.display = 'none';
        document.getElementById('rightMasonry').parentElement.style.display = 'none';
        document.getElementById('mobileMasonry').style.display = 'block';
        
        // Применяем masonry к мобильной колонке
        setTimeout(() => {
            const mobileGrid = document.getElementById('mobileMasonry').querySelector('.masonry-grid');
            if (mobileGrid) masonryLayout(mobileGrid);
        }, 100);
    }
}

// Инициализация
window.addEventListener('load', function() {
    // Даем время изображениям загрузиться
    setTimeout(() => {
        setupResponsiveLayout();
        
        // Обработка загрузки изображений
        const images = document.querySelectorAll('.post-image');
        images.forEach(img => {
            if (!img.complete) {
                img.addEventListener('load', setupResponsiveLayout);
            }
        });
    }, 300);
});

// При изменении размера окна
window.addEventListener('resize', () => {
    clearTimeout(window._masonryTimer);
    window._masonryTimer = setTimeout(setupResponsiveLayout, 200);
});
</script>
</html>