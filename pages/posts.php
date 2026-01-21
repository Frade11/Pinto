<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
     <?php require '../includes/sidebar.php';?>
  <div class="main-container">
    <?php require '../includes/topnav.php';?>
    <div class="main-content">

 <?php
require_once "../connection.php";

echo '<div class="post-grid">';

// Выбираем все посты с медиа типа 'image'
$sql = "SELECT pm.id, pm.post_id, pm.type, pm.source, pm.url
        FROM post_media pm
        WHERE pm.type = 'image'
        ORDER BY pm.id DESC"; // новые посты сверху

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imgSrc = '';

        if ($row['source'] === 'url' && !empty($row['url'])) {
            $imgSrc = $row['url'];
        } elseif ($row['source'] === 'upload') {
            // Если BLOB в базе
            $stmt = $conn->prepare("SELECT data, mime_type FROM post_media WHERE id = ?");
            $stmt->bind_param("i", $row['id']);
            $stmt->execute();
            $stmt->bind_result($data, $mimeType);
            $stmt->fetch();
            $stmt->close();

            $base64 = base64_encode($data);
            $imgSrc = "data:$mimeType;base64,$base64";
        }

        echo '<div class="post"><img src="' . htmlspecialchars($imgSrc) . '" alt=""></div>';
    }
} else {
    echo '<p>No posts found</p>';
}

echo '</div>';
?>

        </div>
    </div>
</div>

</body>
<script src="/assets/js/gallery_grid.js"></script>
</html>