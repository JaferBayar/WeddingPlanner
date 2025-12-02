<?php
require_once __DIR__ . '/../models/Model.php';
require_once __DIR__ . '/../views/View.php';
require_once __DIR__ . '/AuthController.php';
class Controller {
    public function html(){
        auth_construct();
        // Always show hero screen for non-logged-in users
        if($_SERVER['REQUEST_METHOD']==='GET' && !isLoggedIn()){
            echo getSplash();
            return;
        }
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $isAjax = isset($_POST['ajax']) && $_POST['ajax'] === '1';

            if(isset($_POST['action']) && $_POST['action']==='add_to_cart' && isset($_POST['item_id'])){
                addToCart((int)$_POST['item_id']);
                if($isAjax){
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success'   => true,
                        'cartCount' => getCartCount(),
                    ]);
                    exit();
                }
                header('Location: index.php');
                exit();
            }
            if(isset($_POST['action']) && $_POST['action']==='add_bundle_to_cart' && isset($_POST['bundle_id'])){
                addBundleToCart((int)$_POST['bundle_id']);
                if($isAjax){
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success'   => true,
                        'cartCount' => getCartCount(),
                    ]);
                    exit();
                }
                header('Location: index.php');
                exit();
            }
            if(isset($_POST['action']) && $_POST['action']==='remove_from_cart' && isset($_POST['cart_key'])){
                // Sanitize cart_key - should only contain alphanumeric characters
                $cartKey = preg_replace('/[^a-zA-Z0-9]/', '', $_POST['cart_key']);
                removeFromCart($cartKey);
                header('Location: index.php');
                exit();
            }
            if(isset($_POST['action']) && $_POST['action']==='place_order'){
                // Block guests from placing orders
                if(isGuest()){
                    header('Location: index.php?error=guest_order');
                    exit();
                }
                $name = isset($_POST['customer_name'])?trim($_POST['customer_name']):'';
                $email = isset($_POST['customer_email'])?trim($_POST['customer_email']):'';
                $orderId = createOrder($name,$email);
                if($orderId){
                    header('Location: index.php?order=success');
                    exit();
                } else {
                    header('Location: index.php?order=empty');
                    exit();
                }
            }
        }
        if(!isLoggedIn()){ header("Location: login.php"); exit(); }
        $isGuest = isGuest();
        $items = getItemsData();
        echo getHeader($isGuest);
        echo getBody($items, $isGuest);
    }
}