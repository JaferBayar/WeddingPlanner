<?php 
require_once __DIR__ . '/../theme.php'; 

function getHeader($isGuest = false) {
    $themeClass = theme_class();
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'میوان';
    
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="ku">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>پلانا هەڤژینیێ</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            
            body { 
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                direction: rtl; 
                min-height: 100vh;
                transition: background-color 0.3s, color 0.3s;
            }
            
            /* Header Styles */
            header { 
                background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%);
                color: white; 
                padding: 40px 20px;
                text-align: center;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
            
            header h1 { 
                font-size: 2.5rem;
                font-weight: 700;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
                letter-spacing: 2px;
            }
            
            /* Navigation */
            nav { 
                background: rgba(255, 20, 147, 0.95);
                padding: 15px 20px;
                text-align: center;
                position: sticky;
                top: 0;
                z-index: 1000;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                backdrop-filter: blur(10px);
            }
            
            .nav-container {
                max-width: 1200px;
                margin: 0 auto;
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 10px;
            }
            
            .nav-links {
                display: flex;
                gap: 15px;
                align-items: center;
            }
            
            .user-info {
                color: white;
                font-weight: 600;
                background: rgba(255,255,255,0.2);
                padding: 8px 16px;
                border-radius: 20px;
                font-size: 0.9rem;
            }
            
            nav a { 
                color: white;
                text-decoration: none;
                font-weight: 600;
                padding: 10px 20px;
                border-radius: 25px;
                transition: all 0.3s;
                display: inline-block;
                background: rgba(255,255,255,0.1);
            }
            
            nav a:hover { 
                background: rgba(255,255,255,0.3);
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            }
            
            /* Guest Warning */
            .guest-banner {
                background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
                color: white;
                text-align: center;
                padding: 15px 20px;
                margin: 0;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            
            .guest-banner strong {
                font-size: 1.1rem;
                display: block;
                margin-bottom: 5px;
            }
            
            /* Main Content */
            .main-content {
                max-width: 1200px;
                margin: 40px auto;
                padding: 0 20px;
            }
            
            /* Category Cards */
            .category-section {
                background: white;
                border-radius: 15px;
                padding: 30px;
                margin-bottom: 30px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.08);
                transition: all 0.3s;
            }
            
            .category-section:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0,0,0,0.12);
            }
            
            h2 { 
                color: #ff1493;
                font-size: 1.8rem;
                margin-bottom: 20px;
                padding-bottom: 15px;
                border-bottom: 3px solid #ff69b4;
                display: flex;
                align-items: center;
                gap: 10px;
            }
            
            h2::before {
                content: '💎';
                font-size: 1.5rem;
            }
            
            /* Service Items */
            ul { 
                list-style: none;
                display: grid;
                gap: 15px;
            }
            
            li { 
                padding: 15px 20px;
                background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
                border-radius: 10px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                transition: all 0.3s;
                border-right: 4px solid transparent;
            }
            
            li:hover {
                border-right-color: #ff69b4;
                transform: translateX(-5px);
                box-shadow: 0 4px 12px rgba(255, 105, 180, 0.2);
            }
            
            .service-name {
                font-weight: 600;
                font-size: 1.1rem;
                color: #333;
            }
            
            .service-price {
                font-weight: 700;
                font-size: 1.2rem;
                color: #ff1493;
                background: rgba(255, 105, 180, 0.1);
                padding: 8px 15px;
                border-radius: 20px;
            }
            
            /* Warning Banner */
            .warning-banner {
                background: linear-gradient(135deg, #fff9c4 0%, #fff59d 100%);
                border: 2px solid #fbc02d;
                border-radius: 12px;
                padding: 20px;
                margin: 20px auto;
                max-width: 1200px;
                text-align: center;
                box-shadow: 0 4px 10px rgba(251, 192, 45, 0.2);
            }
            
            .warning-banner strong {
                color: #f57c00;
                font-size: 1.2rem;
                display: block;
                margin-bottom: 8px;
            }
            
            /* Light Theme */
            body.light { 
                background: linear-gradient(to bottom, #f5f7fa 0%, #e9ecef 100%);
                color: #212529;
            }
            
            /* Dark Theme */
            body.dark { 
                background: linear-gradient(to bottom, #0d1117 0%, #161b22 100%);
                color: #f0f6fc;
            }
            
            body.dark header {
                background: linear-gradient(135deg, #c2185b 0%, #880e4f 100%);
            }
            
            body.dark nav {
                background: rgba(194, 24, 91, 0.95);
            }
            
            body.dark .category-section {
                background: #1e1e1e;
                box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            }
            
            body.dark h2 {
                color: #ff69b4;
                border-bottom-color: #c2185b;
            }
            
            body.dark li {
                background: linear-gradient(135deg, #2d2d2d 0%, #252525 100%);
            }
            
            body.dark .service-name {
                color: #e0e0e0;
            }
            
            body.dark .service-price {
                color: #ff80ab;
                background: rgba(255, 128, 171, 0.15);
            }
            
            body.dark .warning-banner {
                background: linear-gradient(135deg, #3e3420 0%, #4a3f28 100%);
                border-color: #806515;
            }
            
            body.dark .warning-banner strong {
                color: #ffb74d;
            }
            
            body.dark .guest-banner {
                background: linear-gradient(135deg, #1565c0 0%, #0d47a1 100%);
            }
            
            /* Responsive */
            @media (max-width: 768px) {
                header h1 { font-size: 1.8rem; }
                .nav-container { flex-direction: column; }
                h2 { font-size: 1.5rem; }
                .service-name { font-size: 1rem; }
                .service-price { font-size: 1rem; }
            }
        </style>
    </head>
    <body class="<?php echo $themeClass; ?>">
        <header>
            <h1>💍 پلانا هەڤژینیێ 💍</h1>
        </header>
        
        <nav>
            <div class="nav-container">
                <div class="nav-links">
                    <a href="index.php">🏠 سەرەکی</a>
                    <?php if ($isGuest): ?>
                    <a href="signup.php">✨ دروستکردنی هەژمار</a>
                    <?php endif; ?>
                    <a href="logout.php">🚪 دەرچوون</a>
                </div>
                <div class="user-info">
                    👤 <?php echo htmlspecialchars($username); ?>
                </div>
            </div>
        </nav>
        
        <?php if ($isGuest): ?>
        <div class="guest-banner">
            <strong>🎯 ئێستا لە مۆدی میوانی دایت</strong>
            <small>هەلبژاردنەکانت پاشەکەوت ناکرێت - بۆ پاشەکەوتکردن هەژمارێک دروست بکە</small>
        </div>
        <?php endif; ?>
    <?php
    return ob_get_clean();
}

function getBody($itemsData, $isGuest = false) {
    ob_start();
    
    if ($isGuest) {
        echo '<div class="warning-banner">
            <strong>⚠️ تێبینی گرنگ</strong>
            <p>تۆ وەک میوان چاودێری سەردانی دەکەیت. هەلبژاردنەکانت پاشەکەوت ناکرێن.<br>
            بۆ پاشەکەوتکردنی هەلبژاردنەکانت، تکایە <a href="signup.php" style="color:#ff1493;font-weight:bold;">هەژمارێک دروست بکە</a></p>
        </div>';
    }
    
    echo '<div class="main-content">';
    
    $categoryIcons = [
        'هۆل' => '🏰',
        'خواردن' => '🍽️',
        'دیکۆراتات' => '🎨',
        'ستران بێژ' => '🎤',
        'وێنەگر' => '📸'
    ];
    
    foreach ($itemsData as $category => $items) {
        $icon = isset($categoryIcons[$category]) ? $categoryIcons[$category] : '💎';
        
        echo '<div class="category-section">';
        echo '<h2>' . $icon . ' ' . htmlspecialchars($category) . '</h2>';
        
        if (empty($items)) {
            echo '<p style="color:#999;padding:20px;text-align:center;">هیچ خزمەتگوزارییەک تۆمار نەکراوە</p>';
        } else {
            echo '<ul>';
            foreach ($items as $item) {
                echo '<li>';
                echo '<span class="service-name">' . htmlspecialchars($item['name']) . '</span>';
                echo '<span class="service-price">' . number_format($item['price']) . ' دینار</span>';
                echo '</li>';
            }
            echo '</ul>';
        }
        
        echo '</div>';
    }
    
    echo '</div>';
    
    return ob_get_clean();
}

function getLoginForm($error = '') {
    $themeClass = theme_class();
    $errorHtml = $error ? '<div class="error">⚠️ ' . htmlspecialchars($error) . '</div>' : '';
    
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="ku">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>چۆناژۆر - پلانا هەڤژینیێ</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            
            body { 
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                direction: rtl; 
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: background-color 0.3s, color 0.3s;
                padding: 20px;
            }
            
            .container { 
                max-width: 450px;
                width: 100%;
                padding: 40px;
                border-radius: 20px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            }
            
            .logo {
                text-align: center;
                margin-bottom: 30px;
            }
            
            .logo h1 {
                font-size: 2rem;
                background: linear-gradient(135deg, #ff69b4, #ff1493);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                margin-bottom: 10px;
            }
            
            h2 { 
                text-align: center;
                margin-bottom: 30px;
                font-size: 1.8rem;
            }
            
            .form-group { 
                margin-bottom: 20px;
            }
            
            label { 
                display: block;
                margin-bottom: 8px;
                font-weight: 600;
                font-size: 0.95rem;
            }
            
            input[type="email"], 
            input[type="password"] { 
                width: 100%;
                padding: 14px;
                border: 2px solid #e0e0e0;
                border-radius: 10px;
                font-size: 1rem;
                transition: all 0.3s;
            }
            
            input:focus {
                outline: none;
                border-color: #ff69b4;
                box-shadow: 0 0 0 3px rgba(255, 105, 180, 0.1);
            }
            
            .remember-group { 
                margin-bottom: 20px;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            
            input[type="checkbox"] {
                width: 18px;
                height: 18px;
                cursor: pointer;
            }
            
            button { 
                width: 100%;
                border: none;
                padding: 15px;
                border-radius: 10px;
                cursor: pointer;
                font-size: 1.1rem;
                font-weight: 600;
                margin-bottom: 12px;
                transition: all 0.3s;
            }
            
            button:hover { 
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            }
            
            button[type="submit"] {
                background: linear-gradient(135deg, #ff69b4, #ff1493);
                color: white;
            }
            
            .quick-login { 
                background: linear-gradient(135deg, #4CAF50, #45a049);
                color: white;
            }
            
            .guest-login { 
                background: linear-gradient(135deg, #2196F3, #1976D2);
                color: white;
            }
            
            .divider { 
                text-align: center;
                margin: 20px 0;
                position: relative;
            }
            
            .divider::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 0;
                right: 0;
                height: 1px;
                background: #ddd;
            }
            
            .divider span {
                background: white;
                padding: 0 15px;
                position: relative;
                color: #999;
                font-size: 0.9rem;
            }
            
            .info-box {
                background: linear-gradient(135deg, #e3f2fd, #bbdefb);
                padding: 20px;
                border-radius: 12px;
                text-align: center;
                margin-bottom: 20px;
                border: 2px solid #90caf9;
            }
            
            .info-box strong {
                display: block;
                font-size: 1.1rem;
                margin-bottom: 8px;
                color: #1565c0;
            }
            
            .signup-link { 
                text-align: center;
                margin-top: 20px;
                font-size: 1rem;
            }
            
            .signup-link a { 
                color: #ff1493;
                text-decoration: none;
                font-weight: 600;
            }
            
            .signup-link a:hover { 
                text-decoration: underline;
            }
            
            .error { 
                background: linear-gradient(135deg, #ffebee, #ffcdd2);
                color: #c62828;
                text-align: center;
                padding: 15px;
                border-radius: 10px;
                margin-bottom: 20px;
                border: 2px solid #ef5350;
                font-weight: 600;
            }
            
            /* Light theme */
            body.light { 
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            }
            
            body.light .container { 
                background: white;
            }
            
            body.light h2 { 
                color: #333;
            }
            
            body.light label {
                color: #333;
            }
            
            /* Dark theme */
            body.dark { 
                background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            }
            
            body.dark .container { 
                background: #1e1e1e;
                box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            }
            
            body.dark h2 { 
                color: #f0f0f0;
            }
            
            body.dark label {
                color: #e0e0e0;
            }
            
            body.dark input[type="email"], 
            body.dark input[type="password"] { 
                background: #2a2a2a;
                color: #f0f0f0;
                border-color: #444;
            }
            
            body.dark input:focus {
                border-color: #ff69b4;
                box-shadow: 0 0 0 3px rgba(255, 105, 180, 0.2);
            }
            
            body.dark .divider span {
                background: #1e1e1e;
                color: #999;
            }
            
            body.dark .divider::before {
                background: #444;
            }
            
            body.dark .info-box {
                background: linear-gradient(135deg, #1a2332, #2c3e50);
                border-color: #34495e;
            }
            
            body.dark .info-box strong {
                color: #64b5f6;
            }
            
            body.dark .info-box small {
                color: #b0bec5;
            }
            
            body.dark .error {
                background: linear-gradient(135deg, #4a1f1f, #6b2525);
                color: #ff6b6b;
                border-color: #8b3333;
            }
        </style>
    </head>
    <body class="<?php echo $themeClass; ?>">
        <div class="container">
            <div class="logo">
                <h1>💍 پلانا هەڤژینیێ</h1>
            </div>
            
            <h2>چۆناژۆر</h2>
            
            <?php echo $errorHtml; ?>

            <div class="info-box">
                <strong>✨ مۆدی میوان</strong>
                <small>تاقیکردنەوەی خێرا بەبێ دروستکردنی هەژمار</small>
            </div>

            <a href="login.php?guest_login=true" style="text-decoration: none;">
                <button class="guest-login">🎯 چوونەژوورەوە وەک میوان</button>
            </a>

            <div class="divider"><span>یان</span></div>

            <a href="login.php?quick_login=true" style="text-decoration: none;">
                <button class="quick-login">⚡ چۆناژۆری خێرا (Demo)</button>
            </a>

            <div class="divider"><span>یان</span></div>

            <form method="POST">
                <div class="form-group">
                    <label for="email">📧 ئیمەیڵ:</label>
                    <input type="email" id="email" name="email" required placeholder="example@gmail.com">
                </div>
                <div class="form-group">
                    <label for="password">🔒 ژمارا نهێنی:</label>
                    <input type="password" id="password" name="password" required placeholder="••••••">
                </div>
                <div class="remember-group">
                    <input type="checkbox" name="remember" value="1" id="remember">
                    <label for="remember" style="margin: 0;">بیرم بهێنەوە (٣٠ ڕۆژ)</label>
                </div>
                <button type="submit">🚀 چوونەژوورەوە</button>
            </form>

            <div class="signup-link">
                هەژمار نییە؟ <a href="signup.php">دروست بکە</a>
            </div>
        </div>
        <?php render_theme_toggle(); ?>
    </body>
    </html>
    <?php
    return ob_get_clean();
}

function getSignupForm($error = '') {
    $themeClass = theme_class();
    $errorHtml = $error ? '<div class="error">⚠️ ' . htmlspecialchars($error) . '</div>' : '';
    
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="ku">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>دروستکردنی هەژمار - پلانا هەڤژینیێ</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            
            body { 
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                direction: rtl; 
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: background-color 0.3s, color 0.3s;
                padding: 20px;
            }
            
            .container { 
                max-width: 500px;
                width: 100%;
                padding: 40px;
                border-radius: 20px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            }
            
            .logo {
                text-align: center;
                margin-bottom: 30px;
            }
            
            .logo h1 {
                font-size: 2rem;
                background: linear-gradient(135deg, #ff69b4, #ff1493);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                margin-bottom: 10px;
            }
            
            h2 { 
                text-align: center;
                margin-bottom: 30px;
                font-size: 1.8rem;
            }
            
            .form-group { 
                margin-bottom: 20px;
            }
            
            label { 
                display: block;
                margin-bottom: 8px;
                font-weight: 600;
                font-size: 0.95rem;
            }
            
            input[type="text"],
            input[type="email"], 
            input[type="password"] { 
                width: 100%;
                padding: 14px;
                border: 2px solid #e0e0e0;
                border-radius: 10px;
                font-size: 1rem;
                transition: all 0.3s;
            }
            
            input:focus {
                outline: none;
                border-color: #ff69b4;
                box-shadow: 0 0 0 3px rgba(255, 105, 180, 0.1);
            }
            
            button { 
                width: 100%;
                border: none;
                padding: 15px;
                border-radius: 10px;
                cursor: pointer;
                font-size: 1.1rem;
                font-weight: 600;
                margin-bottom: 12px;
                transition: all 0.3s;
            }
            
            button:hover { 
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            }
            
            button[type="submit"] {
                background: linear-gradient(135deg, #ff69b4, #ff1493);
                color: white;
            }
            
            .guest-signup { 
                background: linear-gradient(135deg, #2196F3, #1976D2);
                color: white;
            }
            
            .benefits {
                background: linear-gradient(135deg, #f0f8ff, #e1f5fe);
                padding: 20px;
                border-radius: 12px;
                margin-bottom: 25px;
                border-right: 4px solid #ff69b4;
            }
            
            .benefits h3 {
                color: #ff1493;
                margin-bottom: 15px;
                font-size: 1.3rem;
            }
            
            .benefits ul {
                list-style: none;
                padding: 0;
            }
            
            .benefits li {
                padding: 10px 0;
                padding-right: 25px;
                position: relative;
            }
            
            .benefits li::before {
                content: '✓';
                position: absolute;
                right: 0;
                color: #4CAF50;
                font-weight: bold;
                font-size: 1.2rem;
            }
            
            .info-box {
                background: linear-gradient(135deg, #fff3e0, #ffe0b2);
                padding: 20px;
                border-radius: 12px;
                text-align: center;
                margin-bottom: 20px;
                border: 2px solid #ffb74d;
            }
            
            .info-box strong {
                display: block;
                font-size: 1.1rem;
                margin-bottom: 8px;
                color: #ef6c00;
            }
            
            .login-link { 
                text-align: center;
                margin-top: 20px;
                font-size: 1rem;
            }
            
            .login-link a { 
                color: #ff1493;
                text-decoration: none;
                font-weight: 600;
            }
            
            .login-link a:hover { 
                text-decoration: underline;
            }
            
            .error { 
                background: linear-gradient(135deg, #ffebee, #ffcdd2);
                color: #c62828;
                text-align: center;
                padding: 15px;
                border-radius: 10px;
                margin-bottom: 20px;
                border: 2px solid #ef5350;
                font-weight: 600;
            }
            
            /* Light theme */
            body.light { 
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            }
            
            body.light .container { 
                background: white;
            }
            
            body.light h2 { 
                color: #333;
            }
            
            body.light label {
                color: #333;
            }
            
            /* Dark theme */
            body.dark { 
                background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            }
            
            body.dark .container { 
                background: #1e1e1e;
                box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            }
            
            body.dark h2 { 
                color: #f0f0f0;
            }
            
            body.dark label {
                color: #e0e0e0;
            }
            
            body.dark input[type="text"],
            body.dark input[type="email"], 
            body.dark input[type="password"] { 
                background: #2a2a2a;
                color: #f0f0f0;
                border-color: #444;
            }
            
            body.dark input:focus {
                border-color: #ff69b4;
                box-shadow: 0 0 0 3px rgba(255, 105, 180, 0.2);
            }
            
            body.dark .benefits {
                background: linear-gradient(135deg, #1a2332, #2c3e50);
                border-right-color: #ff69b4;
            }
            
            body.dark .benefits h3 {
                color: #ff69b4;
            }
            
            body.dark .benefits li {
                color: #e0e0e0;
            }
            
            body.dark .info-box {
                background: linear-gradient(135deg, #3e3420, #4a3f28);
                border-color: #806515;
            }
            
            body.dark .info-box strong {
                color: #ffb74d;
            }
            
            body.dark .info-box small {
                color: #b0bec5;
            }
            
            body.dark .error {
                background: linear-gradient(135deg, #4a1f1f, #6b2525);
                color: #ff6b6b;
                border-color: #8b3333;
            }
        </style>
    </head>
    <body class="<?php echo $themeClass; ?>">
        <div class="container">
            <div class="logo">
                <h1>💍 پلانا هەڤژینیێ</h1>
            </div>
            
            <h2>دروستکردنی هەژمار</h2>
            
            <?php echo $errorHtml; ?>

            <div class="benefits">
                <h3>✨ سوودەکانی هەژمار</h3>
                <ul>
                    <li>پاشەکەوتکردنی هەلبژاردنەکانت</li>
                    <li>دەستگەیشتن لە هەموو شوێنێکەوە</li>
                    <li>بیرکردنەوەی خۆکارانە (Remember Me)</li>
                    <li>پارێزراوی و پاراستراو</li>
                </ul>
            </div>

            <form method="POST">
                <div class="form-group">
                    <label for="username">👤 ناوی بەکارهێنەر:</label>
                    <input type="text" id="username" name="username" required placeholder="ناوێکی جوان هەڵبژێرە">
                </div>
                <div class="form-group">
                    <label for="email">📧 ئیمەیڵ:</label>
                    <input type="email" id="email" name="email" required placeholder="example@gmail.com">
                </div>
                <div class="form-group">
                    <label for="password">🔒 ژمارەی نهێنی:</label>
                    <input type="password" id="password" name="password" required placeholder="کەمتر لە ٦ پیت نەبێت">
                </div>
                <button type="submit">🎉 دروستکردنی هەژمار</button>
            </form>

            <div class="info-box">
                <strong>🎯 یان بەردەوام بە وەک میوان</strong>
                <small>تاقیکردنەوە بەبێ هەژمار</small>
            </div>

            <a href="login.php?guest_login=true" style="text-decoration: none;">
                <button class="guest-signup">👋 بەردەوامبوون وەک میوان</button>
            </a>

            <div class="login-link">
                هەژمارت هەیە؟ <a href="login.php">چوونەژوورەوە</a>
            </div>
        </div>
        <?php render_theme_toggle(); ?>
    </body>
    </html>
    <?php
    return ob_get_clean();
}
?>