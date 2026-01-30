<?php

session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];
$activeForm = $_SESSION['active_form'] ?? 'login';

session_unset();

function showError($error){
    return !empty($error) ? "<p class = 'error-message'>$error</p>" :'';
}

function isActiveForm($formName,$activeForm){
    return $formName === $activeForm ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Login</title>
</head>
<body>
     <div class="form-container">
        <div class="form_box <?= isActiveForm('login', $activeForm) ?>" id="login-form">
            <form action="login_registration.php" method="POST">
                <h2>Login</h2>
                <?= showError($errors['login']) ?>  
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
                <p>Dont have an account? <a href="#" onclick="showForm('register-form')">Register</a></p>
            </form>
        </div>

        <div class="form_box <?= isActiveForm('register', $activeForm) ?>" id="register-form">
            <form action="login_registration.php" method="POST">
                <h2>Register</h2>
                <?= showError($errors['register']) ?> 
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="register">Register</button>
                <p>Already have an account? <a href="#" onclick="showForm('login-form')">Login</a></p>
            </form>
        </div>
     </div>
     <script src="../assets/js/formShow.js"></script>
</body>
</html>