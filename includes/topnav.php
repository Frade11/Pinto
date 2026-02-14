<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>

<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-straight/css/uicons-regular-straight.css'>
<div class="topbar">
        <div class="search">
            <i class="fi fi-rs-search"></i>
            <input type="text" placeholder="Search...">
        </div>
        <div class="top-icons">
            <div class="notifications"><i class="fi fi-rs-bell-notification-social-media"></i></div>
            <img src="<?= htmlspecialchars($_SESSION['avatar'] ?? '../assets/images/avatarPlaceholder.jpg')  ?> " alt="user" class="userIcon" id="userIcon">
            <div class="userInfoOverlay" id="userOverlay">
                <div class="user-container" id="user-popup">
                    <div class="icon">
                        <img src="<?= htmlspecialchars($_SESSION['avatar'] ?? '../assets/images/avatarPlaceholder.jpg')  ?> " alt="user" class="userIcon">
                        <!-- <img src="../assets/images/logo.jpg" alt="user" class="userIcon"> -->
                    </div>
                    <div class="userInfo">
                        <p class="userName"><?= htmlspecialchars($_SESSION['name'] ?? '')  ?></p>
                        <p class="userEmail"><?= htmlspecialchars($_SESSION['email'] ?? '') ?></p>
                        <p class="userRole"><?= htmlspecialchars($_SESSION['role'] ?? 'user') ?></p>
                    </div>
                </div>
                <div class="logoutBtn">
                    <i class="fi fi-rr-exit" id="logOut"></i>
                </div>
            </div>

            <div class="console" id="console">
                <div class="console-header">
                    <span>Terminal</span>
                    <button id="closeConsole" class="close-btn">✖</button>
                </div>
                <div class="console-body" id="consoleBody"></div>
            </div>

            <!-- <img src="../assets/images/logo.jpg" alt="user" class="userIcon" onclick="window.location.href='../login/logout.php'"> -->
        </div>
    </div>
    <script src="../assets/js/mainScripts.js"></script>