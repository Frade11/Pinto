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
        <button class="edit-profile" onclick="showPopup()">Edit profile</button>
    </div>

     <div class="profile-tabs">
        <a href="?tab=saved" class="profile-tab <?= ($_GET['tab'] ?? 'saved') === 'saved' ? 'active' : '' ?>">Saved</a>
        <a href="?tab=likes" class="profile-tab <?= ($_GET['tab'] ?? 'saved') === 'likes' ? 'active' : '' ?>">Likes</a>
        <a href="?tab=posts" class="profile-tab <?= ($_GET['tab'] ?? 'saved') === 'posts' ? 'active' : '' ?>">Posts</a>
    </div>
    
    <div class="edit-popup-overlay " id="popupOverlay">
        <div class="edit-popup">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <h2>Edit profile</h2>
            <img src=<?= htmlspecialchars($_SESSION['avatar']) ?? "../assets/images/avatarPlaceholder.jpg" ?> alt="Avatar" class="avatar-preview" id="avatarPreview">
            <input type="url" id="avatarUrl" placeholder="Link to image">
            <input type="text" id="nickname" placeholder="New username">
            <button onclick="saveProfile()">Save</button>
        </div>
    </div><!-- Контейнер для уведомлений -->
<div id="notification" ></div>


   
    <?php 
    $tab = $_GET['tab'] ?? 'saved';
    if($tab === 'likes'){
        include '../api/renderLikes.php';
    }elseif($tab === 'posts'){
        include '../api/postsActions';
    }else{
        include '../api/renderSaves.php'; 
    }
    
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
<script src="../assets/js/profilePopUp.js"></script>
</html>