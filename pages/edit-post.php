<?php include '../login/session.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post edit</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/3.0.0/uicons-solid-straight/css/uicons-solid-straight.css'>
</head>
<body>
    <?php require '../includes/sidebar.php';?>
    <div class="main-container">
        <?php require '../includes/topnav.php';?>
        
        <div class="posts-content">
            <?php
            require_once "../connection.php";

           $postId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

            if ($postId <= 0) {
                echo "<h2 style='text-align:center;color:#999;margin-top:50px;'>Invalid post ID</h2>";
                exit;
            }
            
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
                LEFT JOIN post_media pm ON p.id = pm.post_id AND pm.type = 'image'
                WHERE p.id = ?
                LIMIT 1
            ";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $postId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result && $result->num_rows > 0) {
                $mainPost = $result->fetch_assoc();
                $mainImgSrc = '';
            if ($mainPost['media_source'] === 'upload' && !empty($mainPost['file_path'])) {
                    $mainImgSrc = '/' . htmlspecialchars($mainPost['file_path']);
                } elseif ($mainPost['media_source'] === 'url' && !empty($mainPost['media_url'])) {
                    $mainImgSrc = htmlspecialchars($mainPost['media_url']);
                }
                $mainDate = date('M d, Y', strtotime($mainPost['created_at']));

                $user_id = $_SESSION['user_id'] ?? 0;
                $isLiked = false;
                $isSaved = false;

                if ($user_id > 0) {
                    $stmt = $conn->prepare("SELECT 1 FROM post_likes WHERE user_id = ? AND post_id = ?");
                    $stmt->bind_param("ii", $user_id, $mainPost['post_id']);
                    $stmt->execute();
                    $isLiked = $stmt->get_result()->num_rows > 0;
                    $stmt->close();
                    
                    $stmt = $conn->prepare("SELECT 1 FROM saved_posts WHERE user_id = ? AND post_id = ?");
                    $stmt->bind_param("ii", $user_id, $mainPost['post_id']);
                    $stmt->execute();
                    $isSaved = $stmt->get_result()->num_rows > 0;
                    $stmt->close();
                }

                // категория
                $sql = '
                SELECT c.id AS category_id, c.name AS category_name
                FROM categories c
                INNER JOIN posts p ON p.category_id = c.id
                WHERE p.id = ?';

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $postId);
                $stmt->execute();
                $result = $stmt->get_result();

                $category = null;
                if($result && $result->num_rows>0){
                    $category = $result->fetch_assoc();
                }
                $stmt->close();

                // теги
                $tagsSql = "
                    SELECT t.name AS tag_name
                    FROM tags t
                    INNER JOIN post_tags pt ON pt.tag_id = t.id
                    WHERE pt.post_id = ?
                ";
                $stmt = $conn->prepare($tagsSql);
                $stmt->bind_param("i", $mainPost['post_id']);
                $stmt->execute();
                $result = $stmt->get_result();

                $postTags = [];
                while ($row = $result->fetch_assoc()) {
                    $postTags[] = $row['tag_name'];
                }
                $stmt->close();

                $tagsString = htmlspecialchars(implode(', ', $postTags));
                ?>
                <div class="posts-layout">
                     <!-- Главный пост -->
                    <div class="main-post-container">
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
                                    <span id="like-count"><?= $mainPost['likes_count'] ?> likes</span>
                                    <span id="save-count"><?= $mainPost['saves_count'] ?> saves</span>
                                    <span><?= $mainDate ?></span>
                                </div>
                                <div class="main-post-actions">
                                    <button class="like-btn <?= $isLiked ? 'active' : '' ?>" data-id="<?= $mainPost['post_id'] ?>">
                                        <i class="fi <?= $isLiked ? 'fi-ss-heart' : 'fi-rs-heart' ?>"></i>
                                    </button>
                                    <button class="save-btn <?= $isSaved ? 'active' : '' ?>" data-id="<?= $mainPost['post_id'] ?>">
                                        <?= $isSaved ? 'Saved' : 'Save' ?>
                                    </button>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    
                   <!-- Редактирование поста -->
                    <div class="right-posts-column">
                        <div class="edit-post-card">
                            <h3>Edit Post</h3>
                            <form class="edit-post-form" method="POST" action="../api/update_post.php">
                                <input type="hidden" name="post_id" value="<?= $mainPost['post_id'] ?>">

                                <label for="post_name">Title</label>
                                <input type="text" name="post_name" id="post_name" placeholder="Post title" value="<?= htmlspecialchars($mainPost['post_title']) ?>" required>

                                <label for="post_description">Description</label>
                                <textarea name="post_description" id="post_description" placeholder="Post description" ><?= htmlspecialchars($mainPost['description']) ?></textarea>

                                <label for="post_category">Category</label>
                                <select name="post_category" id="post_category">
                                    <?php
                                        $categoriesResult = $conn->query("SELECT id, name FROM categories");
                                        while($row = $categoriesResult->fetch_assoc()){
                                            $selected = ($category && $category['category_id'] == $row['id']) ? 'selected' : '';
                                            echo "<option value = '{$row['id']}' $selected>{$row['name']}</option>";
                                        }
                                    ?>
                                </select>
                                <label for="post_tags">Tags (comma separated)</label>
                                <input type="text" name="post_tags" id="post_tags" placeholder="tag1, tag2, tag3" value="<?= $tagsString ?>">


                                <div class="edit-post-actions">
                                    <button type="submit" class="save-post-btn">Save Changes</button>
                                    <button type="button" class="delete-post-btn" onclick="confirmDelete(<?= $mainPost['post_id'] ?>)">Delete Post</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
               <?php
            } else {
                echo '<div class="no-posts">
                        <h2>Post not found</h2>
                        <p>The post you are looking for does not exist.</p>
                      </div>';
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
<script>
function confirmDelete(postId) {
    if (confirm("Are you sure you want to delete this post?")) {
        window.location.href = `../api/delete_post.php?id=${postId}`;
    }
}
</script>
<script src="../assets/js/statsUpdate.js"></script>
</html>