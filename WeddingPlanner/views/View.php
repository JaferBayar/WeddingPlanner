<?php
function getHeader($isGuest = false) {
    $userInfo = $isGuest ? 
        '<div style="text-align: center; background: #e6f7ff; padding: 10px; margin: 10px; border-radius: 5px;">
            <strong>ئێستا لە مۆدی میوانی دایت 🎯</strong><br>
            <small>بۆ هەلبژاردنەکانت هەلێ داگیری ناکرێتەوە</small>
         </div>' : '';
    
    return '
    <header>
        <h1>پـــــــــلانــــــــا هـــــــەڤــــــــژيــــــــنـــــــيـــــێ </h1>
    </header>
    <nav>
        <a href="index.php">سەرەکی</a>
        ' . ($isGuest ? '<a href="signup.php">دروستکردنی هەژمار</a>' : '') . '
        <a href="logout.php">دەرچوون</a>
    </nav>
    ' . $userInfo . '
    <style>
        body { font-family: sans-serif; direction: rtl; background: white; margin:0; padding:0; }
        header { background: #ff69b4; color: white; padding: 20px; text-align: center; }
        nav { background: #ff1493; padding: 10px; text-align: center; position: sticky; top:0; z-index:1000; }
        nav a { color: white; text-decoration: none; margin: 0 15px; font-weight: bold; }
        nav a:hover { text-decoration: underline; }
        h2 { color:#ff1493; padding:10px 20px; }
        ul { list-style: none; padding: 0 20px 20px; }
        li { padding: 8px 12px; border-bottom: 1px solid #eee; display:flex; justify-content:space-between; }
    </style>';
}

function getBody($itemsData, $isGuest = false) {
    $guestWarning = $isGuest ? 
        '<div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; margin: 20px; border-radius: 5px; text-align: center;">
            <strong>⚠ تێبینی:</strong> تۆ وەک میوان هەلبژاردنەکانت داگیر ناکرێت. بۆ داگیرکردن، هەژمارێک دروست بکە.
        </div>' : '';
    
    $body = $guestWarning;
    
    foreach ($itemsData as $category => $items) {
        $body .= '<h2 id="' . urlencode($category) . '">' . $category . '</h2>';
        $body .= '<ul>';
        foreach ($items as $item) {
            $body .= '<li><span>' . $item['name'] . '</span><span>' . number_format($item['price']) . ' دینار</span></li>';
        }
        $body .= '</ul>';
    }
    return $body;
}

function getLoginForm($error = '') {
    $errorHtml = $error ? '<div class="error">' . $error . '</div>' : '';
    return '
    <!DOCTYPE html>
    <html lang="ku">
    <head>
        <meta charset="UTF-8">
        <title>چۆناژۆر - پلانا هەڤژینیێ</title>
        <style>
            body { font-family: sans-serif; direction: rtl; background: #f5f5f5; margin:0; padding:0; }
            .container { max-width: 420px; margin: 40px auto; background: white; padding: 28px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
            h2 { text-align: center; color: #ff69b4; margin-bottom: 24px; }
            .form-group { margin-bottom: 16px; }
            label { display: block; margin-bottom: 6px; color: #333; font-weight: bold; }
            input[type="email"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
            button { width: 100%; background: #ff69b4; color: white; border: none; padding: 12px; border-radius: 5px; cursor: pointer; font-size: 16px; margin-bottom: 10px; }
            button:hover { background: #ff1493; }
            .quick-login { background: #4CAF50 !important; }
            .quick-login:hover { background: #45a049 !important; }
            .guest-login { background: #2196F3 !important; }
            .guest-login:hover { background: #1976D2 !important; }
            .signup-link { text-align: center; margin-top: 12px; }
            .signup-link a { color: #ff69b4; text-decoration: none; }
            .signup-link a:hover { text-decoration: underline; }
            .error { color: red; text-align: center; margin-bottom: 12px; padding: 10px; background: #ffe6e6; border-radius: 5px; }
            .divider { text-align: center; margin: 16px 0; color: #666; }
            .guest-info { background: #e3f2fd; padding: 12px; border-radius: 5px; margin-bottom: 16px; text-align: center; }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>چۆناژۆر</h2>
            ' . $errorHtml . '

            <div class="guest-info">
                <strong>✅ مۆدی میوان</strong><br>
                <small>هەلبژاردنەکانت تاقی بکەوە بەبێ دروستکردنی هەژمار</small>
            </div>

            <a href="login.php?guest_login=true" style="text-decoration: none;">
                <button class="guest-login">چوونەژوورەوە وەک میوان</button>
            </a>

            <div class="divider">یان</div>

            <a href="login.php?quick_login=true" style="text-decoration: none;">
                <button class="quick-login">چۆناژۆری خێرا (بێ پڕکردنەوە)</button>
            </a>

            <div class="divider">یان</div>

            <form method="POST">
                <div class="form-group">
                    <label for="email">ئیمەیڵ:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">ژمارا نهێنی:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">چۆناژۆر</button>
            </form>

            <div class="signup-link">
                <a href="signup.php">هەژمار نییە؟ دروست بکە</a>
            </div>
        </div>
    </body>
    </html>';
}

function getSignupForm($error = '') {
    $errorHtml = $error ? '<div class="error">' . $error . '</div>' : '';
    return '
    <!DOCTYPE html>
    <html lang="ku">
    <head>
        <meta charset="UTF-8">
        <title>دروستکردنی هەژمار - پلانا هەڤژینیێ</title>
        <style>
            body { font-family: sans-serif; direction: rtl; background: #f5f5f5; margin:0; padding:0; }
            .container { max-width: 450px; margin: 30px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
            h2 { text-align: center; color: #ff69b4; margin-bottom: 30px; }
            .form-group { margin-bottom: 20px; }
            label { display: block; margin-bottom: 5px; color: #333; font-weight: bold; }
            input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; font-size: 16px; }
            input:focus { border-color: #ff69b4; outline: none; box-shadow: 0 0 5px rgba(255, 105, 180, 0.3); }
            button { width: 100%; background: #ff69b4; color: white; border: none; padding: 12px; border-radius: 5px; cursor: pointer; font-size: 16px; margin-bottom: 10px; transition: background 0.3s; }
            button:hover { background: #ff1493; }
            .guest-signup { background: #2196F3 !important; }
            .guest-signup:hover { background: #1976D2 !important; }
            .login-link { text-align: center; margin-top: 20px; }
            .login-link a { color: #ff69b4; text-decoration: none; font-weight: bold; }
            .login-link a:hover { text-decoration: underline; }
            .error { color: red; text-align: center; margin-bottom: 15px; padding: 10px; background: #ffe6e6; border-radius: 5px; border: 1px solid #ffcccc; }
            .guest-info { background: #e3f2fd; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center; border: 1px solid #bbdefb; }
            .benefits { background: #f0f8ff; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-right: 4px solid #ff69b4; }
            .benefits h3 { color: #ff69b4; margin-top: 0; }
            .benefits ul { padding-right: 20px; margin: 10px 0; }
            .benefits li { margin-bottom: 8px; }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>دروستکردنی هەژمارێ تازە</h2>
            ' . $errorHtml . '

            <div class="benefits">
                <h3>✅ سوودەکان</h3>
                <ul>
                    <li>پاسەوانی هەلبژاردنەکانت</li>
                    <li>داگیری هەلبژاردن بۆ ئاڤا</li>
                    <li>پەیوەستبوون بە داتابەیس</li>
                </ul>
            </div>

            <form method="POST">
                <div class="form-group">
                    <label for="username">ناوی بەکارهێنەر:</label>
                    <input type="text" id="username" name="username" required placeholder="ناوی بەکارهێنەرێک هەڵبژێرە">
                </div>
                <div class="form-group">
                    <label for="email">ئیمەیڵ:</label>
                    <input type="email" id="email" name="email" required placeholder="example@gmail.com">
                </div>
                <div class="form-group">
                    <label for="password">ژمارەی نهێنی:</label>
                    <input type="password" id="password" name="password" required placeholder="کەمتر لە ٦ پیت نەبێت">
                </div>
                <button type="submit">دروستکردنی هەژمار</button>
            </form>

            <div class="guest-info">
                <strong>🎯 هێشتا گومانیت؟</strong><br>
                <small>دەتوانیت سەردان بکەیت وەک میوان بەبێ دروستکردنی هەژمار</small>
            </div>

            <a href="login.php?guest_login=true" style="text-decoration: none;">
                <button class="guest-signup">بەردەوامبوون وەک میوان</button>
            </a>

            <div class="login-link">
                <a href="login.php">هەژمارەکەت هەیە؟ چوونەژوورەوە</a>
            </div>
        </div>
    </body>
    </html>';
}
?>
