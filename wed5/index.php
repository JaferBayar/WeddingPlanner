<?php
require_once __DIR__ . '/theme.php';
theme_init();
require_once __DIR__ . '/controllers/Controller.php';
$controller = new Controller();
$controller->render();
?>