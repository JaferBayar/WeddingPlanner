<?php
require_once __DIR__ . '/../models/Model.php';

function auth_construct() {
    if (session_status() == PHP_SESSION_NONE) { 
        session_start(); 
    }
    
    // Check remember-me token if user not logged in
    if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
        $u = rememberFindUserByToken($_COOKIE['remember_token']);
        if ($u) {
            $_SESSION['user_id'] = $u['id'];
            $_SESSION['username'] = $u['username'];
            $_SESSION['user_type'] = 'registered';
        } else {
            // Invalid token, clear it
            setcookie('remember_token', '', time() - 3600, '/', '', false, true);
            unset($_COOKIE['remember_token']);
        }
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
                // Handle remember-me
                if (isset($_POST['remember']) && $_POST['remember'] === '1') {
                    $raw = bin2hex(random_bytes(32));
                    $hash = hash('sha256', $raw);
                    $ua = isset($_SERVER['HTTP_USER_AGENT']) ? hash('sha256', $_SERVER['HTTP_USER_AGENT']) : null;
                    $exp = date('Y-m-d H:i:s', time() + 60*60*24*30); // 30 days
                    
                    rememberStoreToken($user['id'], $hash, $ua, $exp);
                    setcookie('remember_token', $raw, time() + 60*60*24*30, '/', '', false, true);
                }

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
    if (session_status() == PHP_SESSION_NONE) { 
        session_start(); 
    }
    
    // Clear remember-me token
    if (isset($_COOKIE['remember_token'])) {
        rememberDeleteToken($_COOKIE['remember_token']);
        setcookie('remember_token', '', time() - 3600, '/', '', false, true);
        unset($_COOKIE['remember_token']);
    }
    
    // Destroy session
    session_destroy();
    header("Location: login.php");
    exit();
}
?>