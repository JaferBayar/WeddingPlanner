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
    $allowed = ['en','ar','ku'];
    $lang = in_array($_POST['lang'], $allowed, true) ? $_POST['lang'] : 'ku';
    setcookie('wedding_lang', $lang, time()+3600*24*365, '/');
    header('Location: '.(isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'index.php'));
    exit();
}

function theme_init(){
    if(!isset($_COOKIE['wedding_mode'])){
        setcookie('wedding_mode','groom', time()+3600*24*365, '/');
        $_COOKIE['wedding_mode']='groom';
    }
    if(!isset($_COOKIE['wedding_lang'])){
        // Default language set to Kurdish Sorani
        setcookie('wedding_lang','ku', time()+3600*24*365, '/');
        $_COOKIE['wedding_lang']='ku';
    }
}
function render_theme_toggle(){}