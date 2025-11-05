<?php
if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
}

function theme_init() {
    if (isset($_GET['theme']) && in_array($_GET['theme'], ['dark','light'], true)) {
        setcookie('theme', $_GET['theme'], time() + 60*60*24*365, '/');
        $_COOKIE['theme'] = $_GET['theme'];
        
        // Get the current page without query string
        $current_page = basename($_SERVER['PHP_SELF']);
        header("Location: " . $current_page);
        exit();
    }
}

function theme_class() {
    $t = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';
    return $t === 'dark' ? 'dark' : 'light';
}

function render_theme_toggle() {
    $current = theme_class();
    $other = $current === 'dark' ? 'light' : 'dark';
    $icon = $current === 'dark' ? '☀️' : '🌙';
    $text = $current === 'dark' ? 'Switch to Light' : 'Switch to Dark';
    
    echo '<div style="position:fixed;bottom:16px;right:16px;z-index:9999;font-family:sans-serif">';
    echo '<a href="?theme=' . htmlspecialchars($other) . '" style="padding:10px 16px;border:1px solid #999;border-radius:8px;text-decoration:none;background:#f0f0f0;display:inline-block;box-shadow:0 2px 5px rgba(0,0,0,0.2);transition:all 0.3s;">';
    echo $icon . ' ' . htmlspecialchars($text);
    echo '</a></div>';
}

function render_theme_styles() {
    echo '<style>
        /* Base styles */
        body { transition: background-color 0.3s, color 0.3s; }
        
        /* Dark theme */
        body.dark { 
            background: #111 !important; 
            color: #f4f4f4 !important; 
        }
        body.dark header { 
            background: #d81b60 !important; 
            color: #fff !important; 
        }
        body.dark nav { 
            background: #c2185b !important; 
        }
        body.dark nav a { 
            color: #fff !important; 
        }
        body.dark nav a:hover { 
            background: rgba(255,255,255,0.1); 
        }
        body.dark .container { 
            background: #1e1e1e !important; 
            color: #f4f4f4 !important; 
            border: 1px solid #333 !important;
        }
        body.dark h2 { 
            color: #ff69b4 !important; 
        }
        body.dark li { 
            border-bottom: 1px solid #333 !important; 
        }
        body.dark input, 
        body.dark select, 
        body.dark textarea { 
            background: #2a2a2a !important; 
            color: #f4f4f4 !important; 
            border-color: #444 !important; 
        }
        body.dark input:focus {
            border-color: #ff69b4 !important;
            box-shadow: 0 0 5px rgba(255, 105, 180, 0.5) !important;
        }
        body.dark button { 
            background: #ff69b4 !important; 
            color: #fff !important; 
            border-color: #ff1493 !important; 
        }
        body.dark button:hover { 
            background: #ff1493 !important; 
        }
        body.dark .quick-login {
            background: #388e3c !important;
        }
        body.dark .quick-login:hover {
            background: #2e7d32 !important;
        }
        body.dark .guest-login {
            background: #1976d2 !important;
        }
        body.dark .guest-login:hover {
            background: #1565c0 !important;
        }
        body.dark .guest-signup {
            background: #1976d2 !important;
        }
        body.dark .guest-signup:hover {
            background: #1565c0 !important;
        }
        body.dark .error {
            background: #4a1f1f !important;
            color: #ff6b6b !important;
            border-color: #6b2525 !important;
        }
        body.dark .guest-info {
            background: #1a2332 !important;
            border-color: #2c3e50 !important;
            color: #e3f2fd !important;
        }
        body.dark .benefits {
            background: #1a2332 !important;
            border-right-color: #ff69b4 !important;
            color: #f4f4f4 !important;
        }
        body.dark .divider {
            color: #999 !important;
        }
        body.dark .signup-link a,
        body.dark .login-link a {
            color: #ff69b4 !important;
        }
        
        /* Light theme */
        body.light { 
            background: #fff !important; 
            color: #111 !important; 
        }
        body.light header {
            background: #ff69b4 !important;
            color: white !important;
        }
        body.light nav {
            background: #ff1493 !important;
        }
        body.light nav a {
            color: white !important;
        }
        body.light .container {
            background: white !important;
            color: #333 !important;
        }
    </style>';
}
?>