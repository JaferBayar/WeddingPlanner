<?php
require_once __DIR__ . '/../models/Model.php';
require_once __DIR__ . '/../views/View.php';
require_once __DIR__ . '/AuthController.php';

class Controller {
    public function render() {
        auth_construct();
        if (!isLoggedIn()) {
            header("Location: login.php");
            exit();
        }
        $isGuest = isGuest();
        $itemsData = getItemsData();
        echo getHeader($isGuest);
        echo getBody($itemsData, $isGuest);
if(function_exists('render_banner')) render_banner();
        if(function_exists('render_theme_toggle')) render_theme_toggle();
    }
}
?>
