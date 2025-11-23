<?php
require_once __DIR__ . '/theme.php';
theme_init();
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/models/Model.php';
require_once __DIR__ . '/views/View.php';

auth_construct();

// Only admins can access this page
if(!isLoggedIn() || !isAdmin()){ 
    header("Location: index.php"); 
    exit(); 
}

$message = '';
$editItem = null;

// Handle form submissions
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    if($action === 'add'){
        $title = trim($_POST['title']);
        $price = floatval($_POST['price']);
        $category = trim($_POST['category']);
        $icon = trim($_POST['icon']);
        $isBundle = isset($_POST['is_bundle']) ? 1 : 0;
        
        if($title && $price > 0 && $category){
            addItem($title, $price, $category, $icon, $isBundle);
            $message = 'Item added successfully!';
        }
    }
    
    if($action === 'update'){
        $id = intval($_POST['id']);
        $title = trim($_POST['title']);
        $price = floatval($_POST['price']);
        $category = trim($_POST['category']);
        $icon = trim($_POST['icon']);
        $isBundle = isset($_POST['is_bundle']) ? 1 : 0;
        
        if($id && $title && $price > 0 && $category){
            updateItem($id, $title, $price, $category, $icon, $isBundle);
            $message = 'Item updated successfully!';
        }
    }
    
    if($action === 'delete'){
        $id = intval($_POST['id']);
        if($id){
            deleteItem($id);
            $message = 'Item deleted successfully!';
        }
    }
}

// Check if editing
if(isset($_GET['edit'])){
    $editId = intval($_GET['edit']);
    $editItem = getItemById($editId);
}

// Get all items
$items = getAllItems();

echo getManageItemsPage($items, $editItem, $message);