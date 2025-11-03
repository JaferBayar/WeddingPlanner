<?php
require_once __DIR__ . '/../models/Model.php';

function auth_construct() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

function signup() {
    if($_POST) {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if(empty($username) || empty($email) || empty($password)) {
            return "هەموو خانەکان پڕبکەرەوە!";
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "ئیمەیڵێکی دروست بنووسە!";
        }

        if(strlen($password) < 6) {
            return "ژمارەی نهێنی پێویستە کەمتر لە ٦ پیت نەبێت!";
        }

        if(usernameExists($username)) {
            return "ناوی بەکارهێنەر پێشتر هەیە!";
        }

        if(emailExists($email)) {
            return "ئیمەیڵ پێشتر هەیە!";
        }

        $user_id = createUser($username, $email, $password);
        if ($user_id) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = 'registered';
            header("Location: index.php");
            exit();
        } else {
            return "هەڵەیەک ڕوویدا لە دروستکردنی هەژمار!";
        }
    }
    return '';
}

function login() {
    if($_POST) {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $user = emailExists($email);
        if($user) {
            if(password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_type'] = 'registered';
                header("Location: index.php");
                exit();
            } else {
                return "ژمارا نهێنی هەڵەیە!";
            }
        } else {
            return "ئیمەیڵ نەدۆزرایەوە!";
        }
    }
    return '';
}

function quickLogin() {
    $user = emailExists('demo@test.com');
    if($user) {
        if(password_verify('123456', $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = 'registered';
            header("Location: index.php");
            exit();
        }
    }
    return "هەژماری دیمو بوونی نییە!";
}

function guestLogin() {
    $_SESSION['user_id'] = 'guest_' . uniqid();
    $_SESSION['username'] = 'میوان';
    $_SESSION['user_type'] = 'guest';
    header("Location: index.php");
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isGuest() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'guest';
}

function logout() {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
