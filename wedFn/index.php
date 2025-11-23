
<?php
require_once __DIR__ . '/theme.php';
theme_init();
require_once __DIR__ . '/controllers/Controller.php';
$c = new Controller();
$c->html();
