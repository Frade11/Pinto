<?php include '../login/session.php' ?>
<?php 
require_once "../connection.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinto</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <?php require '../includes/sidebar.php';?>
  <div class="main-container">
    <?php require '../includes/topnav.php';?>
    <div class="main-content">
        <div class="content">
        <div class="main-feed">
            <img src="../assets/images/banner1.gif" alt="banner">
        </div>
        <div class="side-news">
            <p class="news">v1.1 working posts page,recent posts and creating a new one</p>
            <p class="news">v1.2 register/login system where posts are linked tu user id</p>
            <p class="news">v1.3 added popular posts on home page</p>
        </div>
        </div>

        <div class="recent-posts">
             <h3>Recent Posts</h3>
             <div class="explore">Explore →</div>
                <div class="line-post-grid">
                    <?php 
                        //  определяем айди и если нет то по умолчанию 1 страница
                       $postsNumber = 4;
                       $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                       
                       // Получаем 4 самых новых поста с информацией о пользователе и медиа
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
                            FROM posts p
                            INNER JOIN users u ON p.user_id = u.id       
                            LEFT JOIN post_media pm ON p.id = pm.post_id 
                            WHERE pm.type = 'image'                      
                            ORDER BY p.created_at DESC                 
                            LIMIT 10;                                    
                        ";

                        
                        // Выполняем запрос без параметров
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result && $result->num_rows > 0) {
                            // echo '<div class="line-post-grid">';
                            
                            while ($post = $result->fetch_assoc()) {
                                // Определяем источник изображения
                                $imgSrc = '';
                                if ($post['media_source'] === 'upload' && !empty($post['file_path'])) {
                                    $imgSrc = '../' . htmlspecialchars($post['file_path']);
                                } elseif ($post['media_source'] === 'url' && !empty($post['media_url'])) {
                                    $imgSrc = htmlspecialchars($post['media_url']);
                                }

                                // Форматируем дату
                                $date = date('M d, Y', strtotime($post['created_at']));

                                // Обрезаем длинный заголовок
                                $title = htmlspecialchars($post['post_title']);
                                if (strlen($title) > 50) {
                                    $title = substr($title, 0, 47) . '...';
                                }

                                // Вывод карточки поста
                                echo '
                                <a href="/view-post.php?id=' . $post['post_id'] . '" class="line_post">
                                    <img src="' . $imgSrc . '" 
                                        alt="' . htmlspecialchars($post['post_title']) . '" 
                                        class="post-image"
                                        onerror="this.src=\'../assets/images/banner.jpg\'">
                                </a>';
                            }
                            // надо потом вместо баннера дефаулт фотку поставить 
                            
                            echo '</div>';
                        } else {
                            echo "<p>There aren't posts yet</p>";
                        }
                    
                      $stmt->close();
                    ?>
                    
                </div>

            <!-- popular posts -->
            <div class="popular-posts">
                     <h3>Popular Posts</h3>
             <div class="explore">Explore →</div>
                <div class="line-post-grid">
                    <?php 
                        //  определяем айди и если нет то по умолчанию 1 страница
                       $postsNumber = 4;
                       $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                       
                       // Получаем 4 самых новых поста с информацией о пользователе и медиа
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
                            FROM posts p
                            INNER JOIN users u ON p.user_id = u.id       
                            LEFT JOIN post_media pm ON p.id = pm.post_id 
                            WHERE pm.type = 'image'                      
                            ORDER BY likes_count DESC                 
                            LIMIT 10;                                    
                        ";

                        
                        // Выполняем запрос без параметров
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result && $result->num_rows > 0) {
                            // echo '<div class="line-post-grid">';
                            
                            while ($post = $result->fetch_assoc()) {
                                // Определяем источник изображения
                                $imgSrc = '';
                                if ($post['media_source'] === 'upload' && !empty($post['file_path'])) {
                                    $imgSrc = '../' . htmlspecialchars($post['file_path']);
                                } elseif ($post['media_source'] === 'url' && !empty($post['media_url'])) {
                                    $imgSrc = htmlspecialchars($post['media_url']);
                                }

                                // Форматируем дату
                                $date = date('M d, Y', strtotime($post['created_at']));

                                // Обрезаем длинный заголовок
                                $title = htmlspecialchars($post['post_title']);
                                if (strlen($title) > 50) {
                                    $title = substr($title, 0, 47) . '...';
                                }

                                // Вывод карточки поста
                                echo '
                                <a href="/view-post.php?id=' . $post['post_id'] . '" class="line_post1">
                                    <img src="' . $imgSrc . '" 
                                        alt="' . htmlspecialchars($post['post_title']) . '" 
                                        class="post-image"
                                        onerror="this.src=\'../assets/images/banner.jpg\'">
                                </a>';
                            }
                            // надо потом вместо баннера дефаулт фотку поставить 
                            
                            echo '</div>';
                        } else {
                            echo "<p>There aren't posts yet</p>";
                        }
                    
                      $stmt->close();
                    ?>
                    
                </div>

            </div>
        </div>
    </div>
</div>
<?php $conn->close(); ?>
    <script src="../assets/js/lineposts_size.js"></script>
    <script src="../assets/js/mainScripts.js"></script>
</body>
</html>