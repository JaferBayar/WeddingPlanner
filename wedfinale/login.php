
<?php require_once __DIR__ . '/theme.php'; theme_init(); ?>
<?php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/views/View.php';
auth_construct();
if(isLoggedIn()){ header("Location: index.php"); exit(); }
if(isset($_GET['guest_login'])){ guestLogin(); }
$error = '';
if($_POST){
    $r = login();
    if($r !== true && $r !== '') $error = $r;
}
echo getLoginForm($error);
