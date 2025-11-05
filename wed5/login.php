<?php require_once __DIR__ . '/theme.php'; theme_init(); ?>
<?php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/views/View.php';

auth_construct();

if(isLoggedIn()) {
    header("Location: index.php");
    exit();
}

if(isset($_GET['guest_login'])) {
    guestLogin();
}

if(isset($_GET['quick_login'])) {
    quickLogin();
}

$error = '';
if($_POST) {
    $result = login();
    if($result !== true && $result !== '') {
        $error = $result;
    }
}

echo getLoginForm($error);
?>
