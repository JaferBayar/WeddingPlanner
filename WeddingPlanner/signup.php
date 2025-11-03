<?php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/views/View.php';

auth_construct();

if(isLoggedIn()) {
    header("Location: index.php");
    exit();
}

$error = '';
if($_POST) {
    $result = signup();
    if($result !== true && $result !== '') {
        $error = $result;
    }
}

echo getSignupForm($error);
?>
