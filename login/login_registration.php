<?php

session_start();
require_once '../connection.php';

    if(isset($_POST['register'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $checkEmail = $conn->query("SELECT id FROM users WHERE email = '$email'");
    if($checkEmail->num_rows > 0){
        $_SESSION['register_error'] = 'Email is already registered!';
        $_SESSION['active_form'] = 'register';
        header("location:../login/login.php");
        exit();
    }

    $checkName = $conn->query("SELECT id FROM users WHERE username = '$name'");
    if($checkName->num_rows > 0){
        $_SESSION['register_error'] = 'Username is already taken!';
        $_SESSION['active_form'] = 'register';
        header("location:../login/login.php");
        exit();
    }

    $conn->query("INSERT INTO users (username,email,password_hash) VALUES ('$name','$email','$password')");


        header("location:../login/login.php");
        exit();
    }

if(isset($_POST["login"])){
    $email = $_POST["email"];
    $password = $_POST["password"];

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if($result->num_rows>0){
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password_hash'])){
            $_SESSION['name'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'] ?? 'user';
            $_SESSION['avatar'] = $user['avatar_url'] ?? '../assets/images/logo.jpg';
            $_SESSION['user_id'] = $user['id'];

            if($user['role'] === 'admin'){
                header("location: ../admin_pannel/admin.php");
            }else{
                header("location: ../pages/home.php");
            }
            exit();
        }
    }

    $_SESSION['login_error'] = 'Incorect email or password';
    $_SESSION['active_form'] = 'login';
    header("location: ../login/login.php");
    exit();
}
?>