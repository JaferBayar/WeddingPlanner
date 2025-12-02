
<?php require_once __DIR__ . '/theme.php'; theme_init(); ?>
<?php
require_once __DIR__ . '/controllers/AuthController.php';
auth_construct();
logout();
