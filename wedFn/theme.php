<?php
// Handle theme mode switching
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['mode'])){
    $mode = $_POST['mode']==='bride' ? 'bride' : 'groom';
    setcookie('wedding_mode', $mode, time()+3600*24*365, '/');
    header('Location: '.(isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'index.php'));
    exit();
}

// Handle language switching
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['lang'])){
    $lang = $_POST['lang']==='ar' ? 'ar' : 'en';
    setcookie('lang', $lang, time()+3600*24*365, '/');
    header('Location: '.(isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'index.php'));
    exit();
}

function theme_init(){
    if(!isset($_COOKIE['wedding_mode'])){
        setcookie('wedding_mode','groom', time()+3600*24*365, '/');
        $_COOKIE['wedding_mode']='groom';
    }
    if(!isset($_COOKIE['lang'])){
        setcookie('lang','en', time()+3600*24*365, '/');
        $_COOKIE['lang']='en';
    }
}
function render_theme_toggle(){}