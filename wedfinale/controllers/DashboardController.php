
<?php
require_once __DIR__ . '/../models/Model.php';
require_once __DIR__ . '/../views/View.php';
require_once __DIR__ . '/AuthController.php';
class DashboardController {
    public function html(){
        auth_construct();
        if(!isLoggedIn()){ header("Location: login.php"); exit(); }
        if(!isAdmin()){ header("Location: index.php"); exit(); }
        $stats = getDashboardStats();
        $orders = getRecentOrders(50);
        echo getDashboard($stats,$orders);
    }
}
