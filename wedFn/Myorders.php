<?php
require_once __DIR__ . '/theme.php';
theme_init();
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/models/Model.php';
require_once __DIR__ . '/views/View.php';

auth_construct();

// Redirect if not logged in or if guest
if(!isLoggedIn() || isGuest()){ 
    header("Location: login.php"); 
    exit(); 
}

// Get user's orders
$userId = $_SESSION['user_id'];
$orders = getUserOrders($userId);

echo getMyOrdersPage($orders);