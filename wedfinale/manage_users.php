<?php
require_once __DIR__ . '/theme.php';
theme_init();
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/models/Model.php';
require_once __DIR__ . '/views/View.php';

auth_construct();

// Only super admins can access this page
if(!isLoggedIn() || !isSuperAdmin()){ 
    header("Location: index.php"); 
    exit(); 
}

$message = '';
$error = '';

// Handle form submissions
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    if($action === 'promote'){
        $userId = intval($_POST['user_id']);
        // Prevent super admin from modifying themselves
        if($userId === $_SESSION['user_id']){
            $error = t('you_cannot_modify_yourself');
        } else {
            if(updateUserRole($userId, 'admin')){
                $message = t('user_promoted');
            }
        }
    }
    
    if($action === 'demote'){
        $userId = intval($_POST['user_id']);
        // Prevent super admin from modifying themselves
        if($userId === $_SESSION['user_id']){
            $error = t('you_cannot_modify_yourself');
        } else {
            if(updateUserRole($userId, 'user')){
                $message = t('user_demoted');
            }
        }
    }
    
    if($action === 'delete'){
        $userId = intval($_POST['user_id']);
        // Prevent super admin from deleting themselves
        if($userId === $_SESSION['user_id']){
            $error = t('you_cannot_modify_yourself');
        } else {
            if(deleteUser($userId)){
                $message = t('user_deleted');
            } else {
                $error = t('cannot_delete_last_superadmin');
            }
        }
    }
}

// Get all users
$users = getAllUsers();

echo getManageUsersPage($users, $message, $error);