<?php
require_once __DIR__ . '/../lang.php';

function theme_class(){ return isset($_COOKIE['wedding_mode']) && $_COOKIE['wedding_mode']==='bride' ? 'bride' : 'groom'; }
function palette_btn_bg(){ return theme_class()==='bride' ? '#e56ca5' : '#4e6aff'; }
function palette_header_bg(){ return theme_class()==='bride' ? '#ffe6f2' : '#e8f0ff'; }
function palette_card_bg(){ return "#ffffffcc"; }

function getSplash(){
    $btn = palette_btn_bg();
    $hdr = palette_header_bg();
    $theme = theme_class();
    $accent = $theme === 'bride' ? '#d4849a' : '#6b7fd4';
    $accentLight = $theme === 'bride' ? 'rgba(212,132,154,0.15)' : 'rgba(107,127,212,0.15)';
    $dir = getDir();
    $isRTL = isRTL();
    $lang = getCurrentLang();
    ob_start();
?>
<!DOCTYPE html>
<html lang="<?=$lang?>" dir="<?=$dir?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?=t('site_name')?> - <?=t('hero_subtitle')?></title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;500;600;700&family=Cormorant+Garamond:wght@300;400;500;600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <?php if($isRTL): ?>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <?php endif; ?>
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        html{scroll-behavior:smooth}
        body{font-family:<?=$isRTL ? '"Tajawal", "Cormorant Garamond", sans-serif' : '"Cormorant Garamond", serif'?>;color:#2d2d2d;overflow-x:hidden;background:<?=$theme === 'bride' ? '#ffe6f2' : '#e8f0ff'?>}
        
        /* RTL Support */
        <?php if($isRTL): ?>
        body{direction:rtl;text-align:right}
        .hero-content{direction:rtl}
        .hero-buttons{flex-direction:row-reverse}
        .hero-features{flex-direction:row-reverse}
        .feature-item{flex-direction:row-reverse}
        .btn-primary svg,.btn-secondary svg{transform:rotate(180deg)}
        .stats-container{flex-direction:row-reverse}
        .services-grid{direction:rtl}
        .lang-switcher{left:20px;right:auto}
        <?php else: ?>
        .lang-switcher{right:20px;left:auto}
        <?php endif; ?>
        
        /* Language Switcher */
        .lang-switcher{position:fixed;top:20px;z-index:100;display:flex;gap:8px}
        .lang-btn{padding:8px 14px;border:none;border-radius:999px;cursor:pointer;font-size:13px;font-weight:600;transition:all 0.3s;background:rgba(255,255,255,0.9);color:#333;box-shadow:0 2px 10px rgba(0,0,0,0.1)}
        .lang-btn:hover{transform:translateY(-2px)}
        .lang-btn.active{background:<?=$btn?>;color:#fff}
        
        /* Hero Section */
        .hero{min-height:100vh;position:relative;display:flex;align-items:center;justify-content:center;overflow:hidden}
        .hero-bg{position:absolute;inset:0;z-index:0}
        .hero-bg img{width:100%;height:100%;object-fit:cover;filter:brightness(0.85)}
        .hero-overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,0.92) 0%,rgba(255,248,252,0.88) 50%,rgba(248,245,255,0.85) 100%);z-index:1}
        .hero-content{position:relative;z-index:2;max-width:1200px;width:100%;padding:40px 24px;display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center}
        
        /* Left side - Text */
        .hero-text{animation:fadeInUp 1s ease-out}
        .hero-badge{display:inline-flex;align-items:center;gap:8px;padding:8px 18px;background:<?=$accentLight?>;border-radius:999px;font-size:13px;letter-spacing:0.1em;text-transform:uppercase;color:<?=$accent?>;font-weight:500;margin-bottom:24px}
        .hero-badge svg{width:16px;height:16px}
        .hero-title{font-family:"Great Vibes",cursive;font-size:clamp(48px,8vw,82px);color:<?=$accent?>;line-height:1.1;margin-bottom:16px}
        .hero-subtitle{font-family:"Playfair Display",serif;font-size:clamp(24px,3.5vw,36px);font-weight:500;color:#333;margin-bottom:20px;line-height:1.3}
        .hero-description{font-size:18px;line-height:1.8;opacity:0.85;max-width:500px;margin-bottom:32px}
        .hero-features{display:flex;flex-wrap:wrap;gap:16px;margin-bottom:36px}
        .feature-item{display:flex;align-items:center;gap:10px;font-size:15px;color:#555}
        .feature-item svg{width:20px;height:20px;color:<?=$accent?>}
        .hero-buttons{display:flex;gap:16px;flex-wrap:wrap}
        .btn-primary{display:inline-flex;align-items:center;gap:10px;padding:16px 32px;background:<?=$btn?>;color:#fff;text-decoration:none;border-radius:999px;font-weight:600;font-size:16px;box-shadow:0 12px 35px rgba(0,0,0,0.2);transition:all 0.3s ease;border:none;cursor:pointer;font-family:"Cormorant Garamond",serif}
        .btn-primary:hover{transform:translateY(-3px);box-shadow:0 18px 45px rgba(0,0,0,0.25)}
        .btn-secondary{display:inline-flex;align-items:center;gap:10px;padding:16px 32px;background:transparent;color:#333;text-decoration:none;border-radius:999px;font-weight:600;font-size:16px;border:2px solid rgba(0,0,0,0.15);transition:all 0.3s ease;cursor:pointer;font-family:"Cormorant Garamond",serif}
        .btn-secondary:hover{border-color:<?=$accent?>;color:<?=$accent?>}
        
        /* Right side - Image Gallery */
        .hero-gallery{position:relative;height:600px;animation:fadeInRight 1s ease-out 0.3s both}
        .gallery-main{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:320px;height:420px;border-radius:24px;overflow:hidden;box-shadow:0 30px 60px rgba(0,0,0,0.25);border:6px solid #fff;z-index:3}
        .gallery-main img{width:100%;height:100%;object-fit:cover}
        .gallery-side-1{position:absolute;top:10%;left:0;width:180px;height:240px;border-radius:20px;overflow:hidden;box-shadow:0 20px 40px rgba(0,0,0,0.15);border:4px solid #fff;z-index:2;transform:rotate(-8deg)}
        .gallery-side-1 img{width:100%;height:100%;object-fit:cover}
        .gallery-side-2{position:absolute;bottom:10%;right:0;width:200px;height:260px;border-radius:20px;overflow:hidden;box-shadow:0 20px 40px rgba(0,0,0,0.15);border:4px solid #fff;z-index:2;transform:rotate(6deg)}
        .gallery-side-2 img{width:100%;height:100%;object-fit:cover}
        .gallery-decor{position:absolute;width:120px;height:120px;border-radius:50%;background:<?=$accentLight?>;z-index:1}
        .decor-1{top:5%;right:15%;animation:float 6s ease-in-out infinite}
        .decor-2{bottom:15%;left:5%;animation:float 8s ease-in-out infinite reverse}
        
        /* Stats Section */
        .stats-bar{position:absolute;bottom:0;left:0;right:0;z-index:10;background:rgba(255,255,255,0.95);backdrop-filter:blur(20px);border-top:1px solid rgba(0,0,0,0.05)}
        .stats-container{max-width:1200px;margin:0 auto;padding:24px;display:flex;justify-content:space-around;flex-wrap:wrap;gap:20px}
        .stat-item{text-align:center}
        .stat-number{font-family:"Playfair Display",serif;font-size:32px;font-weight:700;color:<?=$accent?>}
        .stat-label{font-size:14px;opacity:0.7;margin-top:4px}
        
        /* Services Preview Section */
        .services-preview{padding:100px 24px;background:linear-gradient(180deg,#fff 0%,#faf8fc 100%)}
        .section-container{max-width:1200px;margin:0 auto}
        .section-header{text-align:center;margin-bottom:60px}
        .section-eyebrow{font-size:13px;letter-spacing:0.15em;text-transform:uppercase;color:<?=$accent?>;margin-bottom:12px}
        .section-title{font-family:"Playfair Display",serif;font-size:clamp(28px,4vw,42px);font-weight:600;margin-bottom:16px}
        .section-description{font-size:18px;opacity:0.75;max-width:600px;margin:0 auto}
        
        .services-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:30px}
        .service-card{background:#fff;border-radius:24px;padding:36px 28px;text-align:center;box-shadow:0 8px 40px rgba(0,0,0,0.06);transition:all 0.3s ease;border:1px solid rgba(0,0,0,0.04)}
        .service-card:hover{transform:translateY(-8px);box-shadow:0 20px 50px rgba(0,0,0,0.1)}
        .service-icon{width:70px;height:70px;border-radius:20px;background:<?=$accentLight?>;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:32px}
        .service-title{font-family:"Playfair Display",serif;font-size:22px;font-weight:600;margin-bottom:12px}
        .service-desc{font-size:15px;opacity:0.75;line-height:1.7}
        

        
        /* CTA Section */
        .cta-section{padding:100px 24px;background:#fff;text-align:center}
        .cta-title{font-family:"Great Vibes",cursive;font-size:clamp(36px,6vw,56px);color:<?=$accent?>;margin-bottom:16px}
        .cta-subtitle{font-size:20px;opacity:0.8;max-width:500px;margin:0 auto 32px}
        .cta-buttons{display:flex;gap:16px;justify-content:center;flex-wrap:wrap}
        
        /* Footer */
        .hero-footer{padding:24px;text-align:center;background:#faf8fc;font-size:14px;opacity:0.7}
        
        /* Animations */
        @keyframes fadeInUp{from{opacity:0;transform:translateY(40px)}to{opacity:1;transform:translateY(0)}}
        @keyframes fadeInRight{from{opacity:0;transform:translateX(40px)}to{opacity:1;transform:translateX(0)}}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-20px)}}
        
        /* Responsive */
        @media(max-width:900px){
            .hero-content{grid-template-columns:1fr;text-align:center;gap:40px}
            .hero-text{order:2}
            .hero-gallery{order:1;height:400px}
            .gallery-main{width:240px;height:320px}
            .gallery-side-1,.gallery-side-2{display:none}
            .hero-features{justify-content:center}
            .hero-buttons{justify-content:center}
            .hero-description{margin-left:auto;margin-right:auto}
        }
        @media(max-width:600px){
            .stats-container{padding:20px 16px}
            .stat-number{font-size:24px}
            .hero-gallery{height:320px}
            .gallery-main{width:200px;height:280px}
        }
    </style>
</head>

<body>
    <!-- Language Switcher -->
    <div class="lang-switcher">
        <form method="post" action="theme.php" style="display:inline">
            <input type="hidden" name="lang" value="en">
            <button type="submit" class="lang-btn <?=$lang==='en'?'active':''?>">EN</button>
        </form>
        <form method="post" action="theme.php" style="display:inline">
            <input type="hidden" name="lang" value="ar">
            <button type="submit" class="lang-btn <?=$lang==='ar'?'active':''?>">عربي</button>
        </form>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg">
            <img src="assets/images/hero_wedding.jpg" alt="Wedding background">
        </div>
        <div class="hero-overlay"></div>
        
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    <?=t('hero_badge')?>
                </div>
                <h1 class="hero-title"><?=t('hero_title')?></h1>
                <h2 class="hero-subtitle"><?=t('hero_subtitle')?></h2>
                <p class="hero-description"><?=t('hero_description')?></p>
                <div class="hero-features">
                    <div class="feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <?=t('hero_feature_1')?>
                    </div>
                    <div class="feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <?=t('hero_feature_2')?>
                    </div>
                    <div class="feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <?=t('hero_feature_3')?>
                    </div>
                </div>
                <div class="hero-buttons">
                    <a href="login.php" class="btn-primary">
                        <?=t('start_planning')?>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </a>
                    <a href="#services" class="btn-secondary">
                        <?=t('explore_services')?>
                    </a>
                </div>
            </div>
            
            <div class="hero-gallery">
                <div class="gallery-decor decor-1"></div>
                <div class="gallery-decor decor-2"></div>
                <div class="gallery-side-1">
                    <img src="assets/images/login_side.jpg" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=1200&q=80';" alt="Wedding flowers">
                </div>
                <div class="gallery-main">
                    <img src="assets/images/signup_side.jpg" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=1200&q=80';" alt="Wedding couple">
                </div>
                <div class="gallery-side-2">
                    <img src="assets/images/cat_decor.jpg" alt="Wedding venue">
                </div>
            </div>
        </div>
        
        <div class="stats-bar">
            <div class="stats-container">
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label"><?=t('happy_couples')?></div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label"><?=t('premium_venues')?></div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100+</div>
                    <div class="stat-label"><?=t('trusted_vendors')?></div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">5★</div>
                    <div class="stat-label"><?=t('customer_rating')?></div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Services Preview -->
    <section class="services-preview" id="services">
        <div class="section-container">
            <div class="section-header">
                <div class="section-eyebrow"><?=t('our_services')?></div>
                <h2 class="section-title"><?=t('services_title')?></h2>
                <p class="section-description"><?=t('services_description')?></p>
            </div>
            
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">🏛️</div>
                    <h3 class="service-title"><?=t('service_venues')?></h3>
                    <p class="service-desc"><?=t('service_venues_desc')?></p>
                </div>
                <div class="service-card">
                    <div class="service-icon">🍰</div>
                    <h3 class="service-title"><?=t('service_catering')?></h3>
                    <p class="service-desc"><?=t('service_catering_desc')?></p>
                </div>
                <div class="service-card">
                    <div class="service-icon">📸</div>
                    <h3 class="service-title"><?=t('service_photo')?></h3>
                    <p class="service-desc"><?=t('service_photo_desc')?></p>
                </div>
                <div class="service-card">
                    <div class="service-icon">💐</div>
                    <h3 class="service-title"><?=t('service_decor')?></h3>
                    <p class="service-desc"><?=t('service_decor_desc')?></p>
                </div>
                <div class="service-card">
                    <div class="service-icon">🎵</div>
                    <h3 class="service-title"><?=t('service_entertainment')?></h3>
                    <p class="service-desc"><?=t('service_entertainment_desc')?></p>
                </div>
                <div class="service-card">
                    <div class="service-icon">💌</div>
                    <h3 class="service-title"><?=t('service_print')?></h3>
                    <p class="service-desc"><?=t('service_print_desc')?></p>
                </div>
            </div>
        </div>
    </section>
    

    
    <!-- CTA Section -->
    <section class="cta-section">
        <h2 class="cta-title"><?=t('ready_to_begin')?></h2>
        <p class="cta-subtitle"><?=t('cta_subtitle')?></p>
        <div class="cta-buttons">
            <a href="signup.php" class="btn-primary"><?=t('create_account')?></a>
            <a href="login.php?guest_login=1" class="btn-secondary"><?=t('continue_guest')?></a>
        </div>
    </section>
    
    <footer class="hero-footer">
        <?=t('copyright')?>
    </footer>
</body>
</html>
<?php
    return ob_get_clean();
}

function getHeader($isGuest=false){
    $btn = palette_btn_bg();
    $hdr = palette_header_bg();
    $theme = theme_class();
    $accent = $theme === 'bride' ? '#d4849a' : '#6b7fd4';
    $success = isset($_GET['order']) && $_GET['order']==='success';
    $empty = isset($_GET['order']) && $_GET['order']==='empty';
    $guestError = isset($_GET['error']) && $_GET['error']==='guest_order';
    $dir = getDir();
    $isRTL = isRTL();
    $lang = getCurrentLang();
    ob_start();
?>
<!DOCTYPE html>
<html lang="<?=$lang?>" dir="<?=$dir?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=t('site_name')?></title>
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;600;700&family=Cormorant+Garamond:wght@300;400;500;600&display=swap" rel="stylesheet">
<?php if($isRTL): ?>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
<?php endif; ?>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:<?=$isRTL ? '"Tajawal", sans-serif' : '"Cormorant Garamond", serif'?>;background:<?=$theme === 'bride' ? '#ffe6f2' : '#e8f0ff'?>;<?=$isRTL ? 'direction:rtl;text-align:right;' : ''?>}
.wrap{min-height:100vh;display:flex;flex-direction:column}
.top{display:flex;justify-content:space-between;align-items:center;padding:12px 24px;background:rgba(255,255,255,0.95);backdrop-filter:blur(20px);box-shadow:0 2px 20px rgba(0,0,0,0.06);position:fixed;top:0;left:0;right:0;z-index:100}
.brand{font-weight:400;font-size:26px;font-family:"Great Vibes",cursive;color:<?=$accent?>;text-decoration:none}
.nav-actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap}
.btn{border:none;padding:9px 16px;border-radius:10px;cursor:pointer;background:<?=$btn?>;color:#fff;font-weight:600;font-size:13px;transition:all 0.2s;text-decoration:none;display:inline-flex;align-items:center;gap:6px}
.btn:hover{opacity:0.9}
.btn-ghost{background:transparent;color:#555;padding:9px 12px}
.btn-ghost:hover{background:rgba(0,0,0,0.05);color:#333}
.btn-cart{background:<?=$btn?>;position:relative}
.badge{position:absolute;top:-5px;<?=$isRTL?'left':'right'?>:-5px;background:#111;color:#fff;border-radius:999px;padding:2px 6px;font-size:10px;font-weight:700}
.btn-lang{padding:7px 10px;font-size:11px;background:transparent;color:#777;border:1px solid #ddd}
.btn-lang:hover{border-color:<?=$accent?>;color:<?=$accent?>}
.btn-lang.active{background:<?=$btn?>;color:#fff;border-color:<?=$btn?>}
.btn-theme{padding:7px 10px;font-size:13px;background:transparent;color:#777;border:1px solid #ddd}
.btn-theme:hover{border-color:<?=$accent?>}
.notice{margin:70px 20px 10px;padding:14px 20px;border-radius:12px;text-align:center}
.notice.success{background:#dcfce7;color:#166534}
.notice.empty{background:#fef3c7;color:#92400e}
.notice.guest-error{background:#fee2e2;color:#b91c1c}
.notice.guest-error a{color:#b91c1c;font-weight:600}
</style>
</head>
<body>
<div class="wrap">
<header class="top">
    <a href="index.php" class="brand"><?=t('site_name')?></a>
    <nav class="nav-actions">
        <?php if(!$isGuest): ?><a class="btn btn-ghost" href="myorders.php"><?=t('my_orders')?></a><?php endif; ?>
        <?php if(isAdmin()): ?><a class="btn btn-ghost" href="dashboard.php"><?=t('dashboard')?></a><?php endif; ?>
        <button id="openCart" class="btn btn-cart"><?=t('cart')?> <span class="badge" id="cartCount"><?php echo getCartCount(); ?></span></button>
        <form method="post" action="theme.php" style="margin:0"><input type="hidden" name="mode" value="groom"><button class="btn btn-theme" type="submit">👔</button></form>
        <form method="post" action="theme.php" style="margin:0"><input type="hidden" name="mode" value="bride"><button class="btn btn-theme" type="submit">👰</button></form>
        <form method="post" action="theme.php" style="margin:0"><input type="hidden" name="lang" value="en"><button class="btn btn-lang <?=$lang==='en'?'active':''?>" type="submit">EN</button></form>
        <form method="post" action="theme.php" style="margin:0"><input type="hidden" name="lang" value="ar"><button class="btn btn-lang <?=$lang==='ar'?'active':''?>" type="submit">عربي</button></form>
        <a class="btn btn-ghost" href="logout.php"><?=t('logout')?></a>
    </nav>
</header>
<?php if($success){ ?><div class="notice success"><?=t('order_success')?></div><?php } ?>
<?php if($empty){ ?><div class="notice empty"><?=t('order_empty')?></div><?php } ?>
<?php if($guestError){ ?><div class="notice guest-error"><?=t('guest_order_error')?> <?=t('please_login')?> <a href="signup.php"><?=t('create_account')?></a> <?=t('or')?> <a href="login.php"><?=t('login')?></a> <?=t('to_place_orders')?></div><?php } ?>
<?php
return ob_get_clean();
}

function getBody($items,$isGuest=false){
    $grouped = [];
    foreach($items as $it){
        $cat = $it['category'];
        if(!isset($grouped[$cat])) $grouped[$cat] = [];
        $grouped[$cat][] = $it;
    }
    $bundles = getBundlesData();
    $btn = palette_btn_bg();
    $hdr = palette_header_bg();
    $theme = theme_class();
    $accent = $theme === 'bride' ? '#d4849a' : '#6b7fd4';
    $accentLight = $theme === 'bride' ? 'rgba(212,132,154,0.1)' : 'rgba(107,127,212,0.1)';
    $dir = getDir();
    $isRTL = isRTL();
    $lang = getCurrentLang();
    
    $catImages = [
        'Services' => ['local' => 'assets/images/cat_services.jpg', 'online' => 'https://images.unsplash.com/photo-1522413452208-996ff3f3e740?w=600&q=80'],
        'Decor' => ['local' => 'assets/images/cat_decor.jpg', 'online' => 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=600&q=80'],
        'Food' => ['local' => 'assets/images/cat_food.jpg', 'online' => 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=600&q=80'],
        'Photo' => ['local' => 'assets/images/cat_photo.jpg', 'online' => 'https://images.unsplash.com/photo-1537633552985-df8429e8048b?w=600&q=80'],
        'Video' => ['local' => 'assets/images/cat_video.jpg', 'online' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=600&q=80'],
        'Print' => ['local' => 'assets/images/cat_print.jpg', 'online' => 'https://images.unsplash.com/photo-1607190074257-dd4b7af0309f?w=600&q=80']
    ];
    
    $bundleImages = [
        ['local' => 'assets/images/bundle_1.jpg', 'online' => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&q=80'],
        ['local' => 'assets/images/bundle_2.jpg', 'online' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=800&q=80'],
        ['local' => 'assets/images/bundle_3.jpg', 'online' => 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=800&q=80']
    ];
    
    ob_start();
?>

<div class="welcome-hero">
    <div class="welcome-bg">
        <img src="assets/images/hero_wedding.jpg" 
             onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=1920&q=80';" 
             alt="Wedding">
    </div>
    <div class="welcome-overlay"></div>
    <div class="welcome-content">
        <div class="welcome-badge">✨ <?=t('welcome')?>, <?php echo $isGuest ? t('guest') : htmlspecialchars($_SESSION['username'] ?? ''); ?></div>
        <h1 class="welcome-title"><?=$isRTL ? 'لنخطط ليومك المثالي' : "Let's Plan Your Perfect Day"?></h1>
        <p class="welcome-subtitle"><?=$isRTL ? 'اختر من خدماتنا وباقاتنا المختارة بعناية' : 'Choose from our curated services and packages below'?></p>
        <div class="welcome-scroll" onclick="document.getElementById('services-section').scrollIntoView({behavior:'smooth'})">
            <span><?=$isRTL ? 'استكشف الخدمات' : 'Explore Services'?></span>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>
        </div>
    </div>
    <div class="welcome-stats">
        <div class="stat-box"><div class="stat-icon">💒</div><div class="stat-value"><?=count($items)?></div><div class="stat-label"><?=t('services')?></div></div>
        <div class="stat-box"><div class="stat-icon">💝</div><div class="stat-value"><?=count($bundles)?></div><div class="stat-label"><?=t('bundles')?></div></div>
        <div class="stat-box"><div class="stat-icon">🛒</div><div class="stat-value"><?=getCartCount()?></div><div class="stat-label"><?=t('cart')?></div></div>
    </div>
</div>

<div class="content" id="services-section">
    <div class="section-intro">
        <span class="intro-badge"><?=t('our_services')?></span>
        <h2 class="intro-title"><?=t('services_title')?></h2>
        <p class="intro-desc"><?=t('services_description')?></p>
    </div>

    <?php $catIndex = 0; foreach($grouped as $cat => $rows): $catIndex++; ?>
    <section class="category-section <?=$catIndex % 2 === 0 ? 'reverse' : ''?>">
        <div class="category-header">
            <div class="category-image">
                <?php $catImg = $catImages[$cat] ?? $catImages['Services']; ?>
                <img src="<?=$catImg['local']?>" onerror="this.onerror=null; this.src='<?=$catImg['online']?>';" alt="<?=htmlspecialchars($cat)?>">
            </div>
            <div class="category-info">
                <h3 class="category-title"><?=htmlspecialchars($cat)?></h3>
                <p class="category-desc"><?php
                    if($cat==='Services') echo t('cat_services_desc');
                    elseif($cat==='Decor') echo t('cat_decor_desc');
                    elseif($cat==='Food') echo t('cat_food_desc');
                    elseif($cat==='Photo' || $cat==='Video') echo t('cat_photo_video_desc');
                    elseif($cat==='Print') echo t('cat_print_desc');
                    else echo t('cat_default_desc');
                ?></p>
                <div class="category-count"><?=count($rows)?> <?=$isRTL ? 'خيارات' : 'options'?></div>
            </div>
        </div>
        <div class="items-grid">
            <?php foreach($rows as $it): ?>
            <div class="item-card">
                <div class="item-icon-wrap"><span class="item-icon"><?=htmlspecialchars($it['icon'])?></span></div>
                <h4 class="item-title"><?=htmlspecialchars($it['title'])?></h4>
                <?php if(!empty($it['description'])): ?>
                <p class="item-description"><?=htmlspecialchars($it['description'])?></p>
                <?php endif; ?>
                <div class="item-meta">
                    <span class="item-category"><?=htmlspecialchars($it['category'])?></span>
                    <span class="item-price"><?=htmlspecialchars($it['price'])?> $</span>
                </div>
                <form method="post" action="index.php">
                    <input type="hidden" name="action" value="add_to_cart">
                    <input type="hidden" name="item_id" value="<?=intval($it['id'])?>">
                    <button class="item-btn" type="submit"><?=t('add_to_cart')?></button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endforeach; ?>
</div>

<div class="bundles-section">
    <div class="bundles-bg"><img src="assets/images/bundles_bg.jpg" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1520854221256-17451cc331bf?w=1920&q=80';" alt="Wedding"></div>
    <div class="bundles-overlay"></div>
    <div class="bundles-content">
        <div class="section-intro light">
            <span class="intro-badge"><?=$isRTL ? 'عروض خاصة' : 'Special Offers'?></span>
            <h2 class="intro-title"><?=t('popular_bundles')?></h2>
            <p class="intro-desc"><?=t('bundles_desc')?></p>
        </div>
        <div class="bundles-grid">
            <?php $bi = 0; foreach($bundles as $bundle): $bImg = $bundleImages[$bi % 3]; ?>
            <div class="bundle-card">
                <div class="bundle-image">
                    <img src="<?=$bImg['local']?>" onerror="this.onerror=null; this.src='<?=$bImg['online']?>';" alt="<?=htmlspecialchars($bundle['title'])?>">
                    <div class="bundle-badge"><?=$isRTL ? 'باقة' : 'Bundle'?></div>
                    <div class="bundle-price-tag"><?=htmlspecialchars($bundle['price'])?> $</div>
                </div>
                <div class="bundle-info">
                    <h3 class="bundle-title"><?=htmlspecialchars($bundle['title'])?></h3>
                    <?php if(!empty($bundle['description'])): ?>
                    <p class="bundle-description"><?=htmlspecialchars($bundle['description'])?></p>
                    <?php endif; ?>
                    <form method="post" action="index.php">
                        <input type="hidden" name="action" value="add_bundle_to_cart">
                        <input type="hidden" name="bundle_id" value="<?=intval($bundle['id'])?>">
                        <button class="bundle-btn" type="submit"><?=t('add_bundle')?></button>
                    </form>
                </div>
            </div>
            <?php $bi++; endforeach; ?>
        </div>
    </div>
</div>

<div id="cartPanel" class="cartpanel">
    <div class="cart-header">
        <div class="cart-title"><?=t('your_cart')?></div>
        <button class="cart-close" id="closeCart">✕</button>
    </div>
    <div class="cart-items">
        <?php foreach(getCartItemsWithKeys() as $key => $row): ?>
        <div class="cart-item">
            <div class="cart-item-icon"><?=htmlspecialchars($row['item']['icon'])?></div>
            <div class="cart-item-info">
                <div class="cart-item-name"><?=htmlspecialchars($row['item']['title'])?></div>
                <div class="cart-item-qty"><?=t('qty')?>: <?=intval($row['qty'])?></div>
            </div>
            <div class="cart-item-price"><?=number_format($row['item']['price']*$row['qty'], 2)?> $</div>
            <form method="post" action="index.php" style="margin:0">
                <input type="hidden" name="action" value="remove_from_cart">
                <input type="hidden" name="cart_key" value="<?=htmlspecialchars($key)?>">
                <button type="submit" class="cart-item-delete" title="<?=$isRTL ? 'حذف' : 'Remove'?>">🗑️</button>
            </form>
        </div>
        <?php endforeach; ?>
        <?php if(!count(getCartItems())): ?>
        <div class="cart-empty"><div class="cart-empty-icon">🛒</div><p><?=t('cart_empty')?></p></div>
        <?php endif; ?>
    </div>
    <div class="cart-footer">
        <div class="cart-total"><span><?=t('total')?></span><span class="cart-total-value"><?=cartTotal()?> $</span></div>
        <?php if($isGuest): ?>
        <div class="cart-guest-notice">
            <p><?=t('guest_order_error')?></p>
            <a href="signup.php" class="cart-btn primary"><?=t('create_account')?></a>
            <a href="login.php" class="cart-btn secondary"><?=t('login')?></a>
        </div>
        <?php else: ?>
        <form method="post" action="index.php">
            <input type="hidden" name="action" value="place_order">
            <input class="cart-input" type="text" name="customer_name" placeholder="<?=t('your_name')?>">
            <input class="cart-input" type="email" name="customer_email" placeholder="<?=t('your_email')?>">
            <button class="cart-btn primary" type="submit"><?=t('place_order')?></button>
        </form>
        <?php endif; ?>
    </div>
</div>

<footer class="main-footer">
    <div class="footer-brand"><?=t('site_name')?></div>
    <p class="footer-text"><?=t('copyright')?></p>
</footer>
</div>

<style>
.welcome-hero{position:relative;height:55vh;min-height:400px;display:flex;align-items:center;justify-content:center;overflow:hidden;margin-top:60px;background:linear-gradient(135deg,#2c1810 0%,#4a3728 50%,#1a1a2e 100%)}
.welcome-bg{position:absolute;inset:0;background:url('assets/images/hero_wedding.jpg') center/cover, url('https://images.unsplash.com/photo-1519741497674-611481863552?w=1920&q=80') center/cover}.welcome-bg img{width:100%;height:100%;object-fit:cover}
.welcome-overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(0,0,0,0.5),rgba(0,0,0,0.3))}
.welcome-content{position:relative;z-index:2;text-align:center;color:#fff;padding:20px}
.welcome-badge{display:inline-block;padding:10px 24px;background:rgba(255,255,255,0.15);backdrop-filter:blur(10px);border-radius:999px;font-size:16px;margin-bottom:20px}
.welcome-title{font-family:"Playfair Display",serif;font-size:clamp(28px,5vw,48px);margin:0 0 16px;text-shadow:0 4px 30px rgba(0,0,0,0.3)}
.welcome-subtitle{font-size:18px;opacity:0.9;margin-bottom:30px}
.welcome-scroll{display:inline-flex;flex-direction:column;align-items:center;gap:8px;cursor:pointer;opacity:0.8;transition:0.3s}
.welcome-scroll:hover{opacity:1}.welcome-scroll svg{animation:bounce 2s infinite}
@keyframes bounce{0%,100%{transform:translateY(0)}50%{transform:translateY(10px)}}
.welcome-stats{position:absolute;bottom:0;left:0;right:0;display:flex;justify-content:center;gap:40px;padding:20px;background:rgba(255,255,255,0.95);backdrop-filter:blur(20px)}
.stat-box{text-align:center}.stat-icon{font-size:24px;margin-bottom:4px}
.stat-value{font-size:24px;font-weight:700;color:<?=$accent?>}.stat-label{font-size:12px;opacity:0.7;text-transform:uppercase;letter-spacing:0.1em}
.section-intro{text-align:center;padding:50px 20px 30px;max-width:700px;margin:0 auto}
.section-intro.light{color:#fff}.section-intro.light .intro-desc{opacity:0.9}
.intro-badge{display:inline-block;padding:8px 20px;background:<?=$accentLight?>;color:<?=$accent?>;border-radius:999px;font-size:13px;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:16px}
.section-intro.light .intro-badge{background:rgba(255,255,255,0.2);color:#fff}
.intro-title{font-family:"Playfair Display",serif;font-size:clamp(24px,4vw,38px);margin:0 0 12px}
.intro-desc{font-size:16px;opacity:0.7;line-height:1.6}
.category-section{padding:30px 20px;max-width:1200px;margin:0 auto}
.category-header{display:grid;grid-template-columns:1fr 1fr;gap:30px;align-items:center;margin-bottom:24px}
.category-section.reverse .category-image{order:2}
.category-image{border-radius:20px;overflow:hidden;height:240px}
.category-image img{width:100%;height:100%;object-fit:cover;transition:transform 0.5s}
.category-section:hover .category-image img{transform:scale(1.05)}
.category-info{padding:16px}
.category-title{font-family:"Playfair Display",serif;font-size:28px;margin:0 0 10px;color:#333}
.category-desc{font-size:15px;opacity:0.7;line-height:1.6;margin-bottom:12px}
.category-count{display:inline-block;padding:6px 14px;background:<?=$accentLight?>;color:<?=$accent?>;border-radius:999px;font-size:12px;font-weight:600}
.items-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:20px}
.item-card{background:#fff;border-radius:20px;padding:20px;box-shadow:0 8px 30px rgba(0,0,0,0.08);transition:all 0.3s}
.item-card:hover{transform:translateY(-6px);box-shadow:0 16px 40px rgba(0,0,0,0.12)}
.item-icon-wrap{width:60px;height:60px;background:<?=$accentLight?>;border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:14px}
.item-icon{font-size:28px}
.item-title{font-family:"Playfair Display",serif;font-size:18px;margin:0 0 10px;color:#333}
.item-description{font-size:13px;color:#666;line-height:1.5;margin-bottom:12px;min-height:40px}
.item-meta{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px}
.item-category{font-size:11px;padding:4px 10px;background:#f5f5f5;border-radius:999px;color:#666}
.item-price{font-size:18px;font-weight:700;color:<?=$accent?>}
.item-btn{width:100%;padding:12px;border:none;border-radius:12px;background:<?=$btn?>;color:#fff;font-weight:600;font-size:14px;cursor:pointer;transition:all 0.3s}
.item-btn:hover{opacity:0.9;transform:scale(1.02)}
.bundles-section{position:relative;padding:60px 0;overflow:hidden}
.bundles-bg{position:absolute;inset:0}.bundles-bg img{width:100%;height:100%;object-fit:cover}
.bundles-overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(0,0,0,0.8),rgba(0,0,0,0.6))}
.bundles-content{position:relative;z-index:2;max-width:1200px;margin:0 auto;padding:0 20px}
.bundles-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:24px}
.bundle-card{background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 16px 50px rgba(0,0,0,0.2);transition:transform 0.3s}
.bundle-card:hover{transform:translateY(-8px)}
.bundle-image{position:relative;height:200px}
.bundle-image img{width:100%;height:100%;object-fit:cover}
.bundle-badge{position:absolute;top:14px;<?=$isRTL?'right':'left'?>:14px;padding:6px 14px;background:<?=$btn?>;color:#fff;border-radius:999px;font-size:11px;font-weight:700;text-transform:uppercase}
.bundle-price-tag{position:absolute;bottom:14px;<?=$isRTL?'left':'right'?>:14px;padding:8px 16px;background:#fff;border-radius:999px;font-size:18px;font-weight:700;color:<?=$accent?>;box-shadow:0 4px 15px rgba(0,0,0,0.15)}
.bundle-info{padding:20px}
.bundle-title{font-family:"Playfair Display",serif;font-size:20px;margin:0 0 14px}
.bundle-description{font-size:14px;color:#666;line-height:1.6;margin-bottom:18px}
.bundle-features{list-style:none;padding:0;margin:0 0 16px}
.bundle-features li{padding:6px 0;border-bottom:1px solid #f0f0f0;font-size:13px;display:flex;align-items:center;gap:8px}
.bundle-features li::before{content:'✓';color:<?=$accent?>;font-weight:bold}
.bundle-btn{width:100%;padding:14px;border:none;border-radius:12px;background:<?=$btn?>;color:#fff;font-weight:600;font-size:14px;cursor:pointer;transition:all 0.3s}
.bundle-btn:hover{opacity:0.9}
<?php if($isRTL): ?>
.cartpanel{position:fixed;left:0;right:auto;top:0;width:400px;max-width:95vw;height:100vh;background:#fff;box-shadow:8px 0 40px rgba(0,0,0,0.15);transform:translateX(-100%);transition:0.3s;display:flex;flex-direction:column;z-index:200}
<?php else: ?>
.cartpanel{position:fixed;right:0;left:auto;top:0;width:400px;max-width:95vw;height:100vh;background:#fff;box-shadow:-8px 0 40px rgba(0,0,0,0.15);transform:translateX(100%);transition:0.3s;display:flex;flex-direction:column;z-index:200}
<?php endif; ?>
.cartpanel.show{transform:translateX(0)}
.cart-header{display:flex;justify-content:space-between;align-items:center;padding:20px;border-bottom:1px solid #f0f0f0}
.cart-title{font-family:"Playfair Display",serif;font-size:20px;font-weight:600}
.cart-close{background:none;border:none;font-size:20px;cursor:pointer;padding:8px;border-radius:10px;transition:0.2s}
.cart-close:hover{background:#f5f5f5}
.cart-items{flex:1;overflow-y:auto;padding:16px 20px}
.cart-item{display:flex;align-items:center;gap:14px;padding:14px;background:#fafafa;border-radius:14px;margin-bottom:10px}
.cart-item-icon{font-size:24px;width:44px;height:44px;background:#fff;border-radius:10px;display:flex;align-items:center;justify-content:center}
.cart-item-info{flex:1}
.cart-item-name{font-weight:600;margin-bottom:2px;font-size:14px}
.cart-item-qty{font-size:12px;opacity:0.6}
.cart-item-price{font-weight:700;color:<?=$accent?>;font-size:16px;margin-<?=$isRTL?'left':'right'?>:8px}
.cart-item-delete{border:none;background:transparent;cursor:pointer;font-size:18px;padding:8px;border-radius:8px;transition:all 0.2s;opacity:0.5}
.cart-item-delete:hover{opacity:1;background:rgba(255,0,0,0.1);transform:scale(1.1)}
.cart-empty{text-align:center;padding:50px 20px;opacity:0.5}
.cart-empty-icon{font-size:40px;margin-bottom:10px}
.cart-footer{padding:20px;border-top:1px solid #f0f0f0;background:#fafafa}
.cart-total{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;font-size:16px}
.cart-total-value{font-size:24px;font-weight:700;color:<?=$accent?>}
.cart-input{width:100%;padding:12px;border:1px solid #e0e0e0;border-radius:10px;margin-bottom:10px;font-size:14px;font-family:inherit;box-sizing:border-box}
.cart-input:focus{outline:none;border-color:<?=$accent?>}
.cart-btn{display:block;width:100%;padding:14px;border:none;border-radius:12px;font-weight:600;font-size:14px;cursor:pointer;text-align:center;text-decoration:none;margin-bottom:8px;transition:0.3s}
.cart-btn.primary{background:<?=$btn?>;color:#fff}
.cart-btn.secondary{background:#fff;color:#333;border:2px solid #e0e0e0}
.cart-guest-notice{text-align:center}
.cart-guest-notice p{color:#b91c1c;margin-bottom:14px;font-size:13px}
.main-footer{background:#1a1a1a;color:#fff;padding:30px 20px;text-align:center}
.footer-brand{font-family:"Great Vibes",cursive;font-size:28px;color:#fff;margin-bottom:8px}
.footer-text{opacity:0.5;font-size:13px}
@media(max-width:900px){.category-header{grid-template-columns:1fr}.category-section.reverse .category-image{order:0}.category-image{height:180px}.welcome-stats{gap:20px}.bundles-grid{grid-template-columns:1fr}}
@media(max-width:600px){.welcome-hero{height:60vh}.items-grid{grid-template-columns:1fr}.stat-value{font-size:20px}}
</style>

<script>
const p=document.getElementById('cartPanel');
document.getElementById('openCart').onclick=()=>p.classList.add('show');
document.getElementById('closeCart').onclick=()=>p.classList.remove('show');
</script>
</body>
</html>
<?php
return ob_get_clean();
}

function getLoginForm($error=''){
$btn = palette_btn_bg();
$theme = theme_class();
$accent = $theme === 'bride' ? '#d4849a' : '#6b7fd4';
$dir = getDir();
$isRTL = isRTL();
$lang = getCurrentLang();
ob_start();
?>
<!DOCTYPE html>
<html lang="<?=$lang?>" dir="<?=$dir?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=t('login')?> - <?=t('site_name')?></title>
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;600;700&family=Cormorant+Garamond:wght@300;400;500;600&display=swap" rel="stylesheet">
<?php if($isRTL): ?>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
<?php endif; ?>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:<?=$isRTL ? '"Tajawal", sans-serif' : '"Cormorant Garamond", serif'?>;min-height:100vh;display:flex;<?=$isRTL ? 'direction:rtl;' : ''?>}
.split-left{flex:1;position:relative;display:flex;align-items:center;justify-content:center;padding:40px;background:linear-gradient(135deg,#fdfbfb 0%,#ebedee 100%)}
.split-left::before{content:'';position:absolute;inset:0;background:url('assets/images/hero_wedding.jpg') center/cover;opacity:0.08}
.split-right{flex:1;position:relative;overflow:hidden;display:none}
@media(min-width:900px){.split-right{display:block}}
.split-right img{width:100%;height:100%;object-fit:cover}
.split-right::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(0,0,0,0.3),rgba(0,0,0,0.1))}
.form-container{position:relative;z-index:1;width:100%;max-width:420px}
.brand{font-family:"Great Vibes",cursive;font-size:42px;color:<?=$accent?>;margin-bottom:8px;text-align:center}
.tagline{text-align:center;opacity:0.6;margin-bottom:40px;font-size:16px}
.form-card{background:#fff;border-radius:24px;padding:40px;box-shadow:0 20px 60px rgba(0,0,0,0.1)}
.form-title{font-family:"Playfair Display",serif;font-size:28px;margin-bottom:8px;color:#333}
.form-subtitle{opacity:0.6;margin-bottom:28px;font-size:15px}
.input-group{margin-bottom:20px}
.input-label{display:block;font-size:13px;font-weight:600;margin-bottom:8px;color:#555;text-transform:uppercase;letter-spacing:0.05em}
.input-field{width:100%;padding:16px 20px;border:2px solid #eee;border-radius:14px;font-size:16px;font-family:inherit;transition:all 0.3s;background:#fafafa}
.input-field:focus{outline:none;border-color:<?=$accent?>;background:#fff;box-shadow:0 0 0 4px <?=$accent?>15}
.input-field::placeholder{color:#aaa}
.btn-primary{width:100%;padding:18px;border:none;border-radius:14px;background:<?=$btn?>;color:#fff;font-weight:600;font-size:16px;cursor:pointer;transition:all 0.3s;box-shadow:0 10px 30px <?=$accent?>40;margin-top:10px}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 15px 40px <?=$accent?>50}
.error-msg{background:#fee2e2;color:#b91c1c;padding:12px 16px;border-radius:12px;margin-bottom:20px;font-size:14px;text-align:center}
.divider{display:flex;align-items:center;margin:28px 0;gap:16px}
.divider::before,.divider::after{content:'';flex:1;height:1px;background:#e0e0e0}
.divider span{font-size:13px;color:#999;text-transform:uppercase;letter-spacing:0.1em}
.btn-guest{width:100%;padding:16px;border:2px solid #e0e0e0;border-radius:14px;background:#fff;color:#555;font-weight:600;font-size:15px;cursor:pointer;transition:all 0.3s;text-decoration:none;display:block;text-align:center}
.btn-guest:hover{border-color:<?=$accent?>;color:<?=$accent?>}
.footer-links{margin-top:28px;text-align:center;font-size:14px}
.footer-links a{color:<?=$accent?>;text-decoration:none;font-weight:600}
.footer-links a:hover{text-decoration:underline}
.lang-switch{position:absolute;top:20px;<?=$isRTL?'left':'right'?>:20px;display:flex;gap:8px}
.lang-btn{padding:8px 14px;border:none;border-radius:8px;font-size:12px;cursor:pointer;transition:0.2s;background:#fff;color:#666;box-shadow:0 2px 10px rgba(0,0,0,0.1)}
.lang-btn.active{background:<?=$btn?>;color:#fff}
.overlay-text{position:absolute;bottom:60px;left:40px;right:40px;z-index:1;color:#fff;text-shadow:0 2px 20px rgba(0,0,0,0.3)}
.overlay-text h2{font-family:"Playfair Display",serif;font-size:36px;margin-bottom:12px}
.overlay-text p{opacity:0.9;font-size:16px;line-height:1.6}
.decor-ring{position:absolute;width:300px;height:300px;border:40px solid <?=$accent?>10;border-radius:50%;top:-100px;<?=$isRTL?'left':'right'?>:-100px}
</style>
</head>
<body>
<div class="split-left">
    <div class="decor-ring"></div>
    <div class="lang-switch">
        <form method="post" action="theme.php" style="display:inline"><input type="hidden" name="lang" value="en"><button class="lang-btn <?=$lang==='en'?'active':''?>" type="submit">EN</button></form>
        <form method="post" action="theme.php" style="display:inline"><input type="hidden" name="lang" value="ar"><button class="lang-btn <?=$lang==='ar'?'active':''?>" type="submit">عربي</button></form>
    </div>
    <div class="form-container">
        <div class="brand"><?=t('site_name')?></div>
        <div class="tagline"><?=$isRTL ? 'نحقق أحلام الزفاف' : 'Making wedding dreams come true'?></div>
        <div class="form-card">
            <h1 class="form-title"><?=t('welcome_back')?></h1>
            <p class="form-subtitle"><?=t('login_subtitle')?></p>
            <?php if($error): ?><div class="error-msg"><?=$error?></div><?php endif; ?>
            <form method="post" action="login.php">
                <div class="input-group">
                    <label class="input-label"><?=t('email_address')?></label>
                    <input type="email" name="email" class="input-field" placeholder="<?=$isRTL ? 'أدخل بريدك الإلكتروني' : 'Enter your email'?>">
                </div>
                <div class="input-group">
                    <label class="input-label"><?=t('password')?></label>
                    <input type="password" name="password" class="input-field" placeholder="<?=$isRTL ? 'أدخل كلمة المرور' : 'Enter your password'?>">
                </div>
                <button type="submit" class="btn-primary"><?=t('login')?></button>
            </form>
            <div class="divider"><span><?=$isRTL ? 'أو' : 'or'?></span></div>
            <a href="login.php?guest_login=1" class="btn-guest"><?=t('continue_guest')?></a>
            <div class="footer-links">
                <?=$isRTL ? 'ليس لديك حساب؟' : "Don't have an account?"?> <a href="signup.php"><?=t('signup')?></a>
            </div>
        </div>
    </div>
</div>
<div class="split-right">
    <img src="assets/images/login_side.jpg" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=1200&q=80';" alt="Wedding">
    <div class="overlay-text">
        <h2><?=$isRTL ? 'يومك المثالي يبدأ هنا' : 'Your Perfect Day Starts Here'?></h2>
        <p><?=$isRTL ? 'انضم إلى آلاف الأزواج السعداء الذين خططوا لحفل زفافهم معنا' : 'Join thousands of happy couples who planned their dream wedding with us'?></p>
    </div>
</div>
</body>
</html>
<?php
return ob_get_clean();
}

function getSignupForm($error=''){
$btn = palette_btn_bg();
$theme = theme_class();
$accent = $theme === 'bride' ? '#d4849a' : '#6b7fd4';
$dir = getDir();
$isRTL = isRTL();
$lang = getCurrentLang();
ob_start();
?>
<!DOCTYPE html>
<html lang="<?=$lang?>" dir="<?=$dir?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=t('signup')?> - <?=t('site_name')?></title>
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;600;700&family=Cormorant+Garamond:wght@300;400;500;600&display=swap" rel="stylesheet">
<?php if($isRTL): ?>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
<?php endif; ?>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:<?=$isRTL ? '"Tajawal", sans-serif' : '"Cormorant Garamond", serif'?>;min-height:100vh;display:flex;<?=$isRTL ? 'direction:rtl;' : ''?>}
.split-left{flex:1;position:relative;overflow:hidden;display:none}
@media(min-width:900px){.split-left{display:block}}
.split-left img{width:100%;height:100%;object-fit:cover}
.split-left::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(0,0,0,0.4),rgba(0,0,0,0.2))}
.split-right{flex:1;position:relative;display:flex;align-items:center;justify-content:center;padding:40px;background:linear-gradient(180deg,#fff 0%,#faf8fc 100%)}
.split-right::before{content:'';position:absolute;inset:0;background:url('assets/images/bundles_bg.jpg') center/cover;opacity:0.05}
.form-container{position:relative;z-index:1;width:100%;max-width:440px}
.brand{font-family:"Great Vibes",cursive;font-size:42px;color:<?=$accent?>;margin-bottom:8px;text-align:center}
.tagline{text-align:center;opacity:0.6;margin-bottom:40px;font-size:16px}
.form-card{background:#fff;border-radius:24px;padding:40px;box-shadow:0 20px 60px rgba(0,0,0,0.1)}
.form-title{font-family:"Playfair Display",serif;font-size:28px;margin-bottom:8px;color:#333}
.form-subtitle{opacity:0.6;margin-bottom:28px;font-size:15px}
.input-group{margin-bottom:20px}
.input-label{display:block;font-size:13px;font-weight:600;margin-bottom:8px;color:#555;text-transform:uppercase;letter-spacing:0.05em}
.input-field{width:100%;padding:16px 20px;border:2px solid #eee;border-radius:14px;font-size:16px;font-family:inherit;transition:all 0.3s;background:#fafafa}
.input-field:focus{outline:none;border-color:<?=$accent?>;background:#fff;box-shadow:0 0 0 4px <?=$accent?>15}
.input-field::placeholder{color:#aaa}
.btn-primary{width:100%;padding:18px;border:none;border-radius:14px;background:<?=$btn?>;color:#fff;font-weight:600;font-size:16px;cursor:pointer;transition:all 0.3s;box-shadow:0 10px 30px <?=$accent?>40;margin-top:10px}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 15px 40px <?=$accent?>50}
.error-msg{background:#fee2e2;color:#b91c1c;padding:12px 16px;border-radius:12px;margin-bottom:20px;font-size:14px;text-align:center}
.features{display:flex;gap:12px;margin-bottom:24px;flex-wrap:wrap;justify-content:center}
.feature{display:flex;align-items:center;gap:6px;font-size:13px;color:#666;background:#f8f8f8;padding:8px 14px;border-radius:999px}
.feature svg{color:<?=$accent?>}
.footer-links{margin-top:28px;text-align:center;font-size:14px}
.footer-links a{color:<?=$accent?>;text-decoration:none;font-weight:600}
.footer-links a:hover{text-decoration:underline}
.lang-switch{position:absolute;top:20px;<?=$isRTL?'left':'right'?>:20px;display:flex;gap:8px;z-index:10}
.lang-btn{padding:8px 14px;border:none;border-radius:8px;font-size:12px;cursor:pointer;transition:0.2s;background:#fff;color:#666;box-shadow:0 2px 10px rgba(0,0,0,0.1)}
.lang-btn.active{background:<?=$btn?>;color:#fff}
.overlay-text{position:absolute;bottom:60px;left:40px;right:40px;z-index:1;color:#fff;text-shadow:0 2px 20px rgba(0,0,0,0.3)}
.overlay-text h2{font-family:"Playfair Display",serif;font-size:36px;margin-bottom:12px}
.overlay-text p{opacity:0.9;font-size:16px;line-height:1.6}
.decor-ring{position:absolute;width:250px;height:250px;border:30px solid <?=$accent?>10;border-radius:50%;bottom:-80px;<?=$isRTL?'right':'left'?>:-80px}
.decor-dots{position:absolute;top:40px;<?=$isRTL?'left':'right'?>:40px;display:grid;grid-template-columns:repeat(5,8px);gap:8px}
.decor-dots span{width:8px;height:8px;background:<?=$accent?>20;border-radius:50%}
</style>
</head>
<body>
<div class="split-left">
    <img src="assets/images/signup_side.jpg" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=1200&q=80';" alt="Wedding Couple">
    <div class="overlay-text">
        <h2><?=$isRTL ? 'ابدأ رحلتك معنا' : 'Start Your Journey With Us'?></h2>
        <p><?=$isRTL ? 'أنشئ حسابك واحصل على كل أدوات التخطيط لحفل زفاف مثالي' : 'Create your account and get access to all the tools you need for a perfect wedding'?></p>
    </div>
</div>
<div class="split-right">
    <div class="decor-ring"></div>
    <div class="decor-dots"><?php for($i=0;$i<15;$i++): ?><span></span><?php endfor; ?></div>
    <div class="lang-switch">
        <form method="post" action="theme.php" style="display:inline"><input type="hidden" name="lang" value="en"><button class="lang-btn <?=$lang==='en'?'active':''?>" type="submit">EN</button></form>
        <form method="post" action="theme.php" style="display:inline"><input type="hidden" name="lang" value="ar"><button class="lang-btn <?=$lang==='ar'?'active':''?>" type="submit">عربي</button></form>
    </div>
    <div class="form-container">
        <div class="brand"><?=t('site_name')?></div>
        <div class="tagline"><?=$isRTL ? 'نحقق أحلام الزفاف' : 'Making wedding dreams come true'?></div>
        <div class="form-card">
            <h1 class="form-title"><?=t('create_account')?></h1>
            <p class="form-subtitle"><?=t('start_planning_subtitle')?></p>
            <div class="features">
                <div class="feature"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg><?=$isRTL ? 'مجاني' : 'Free'?></div>
                <div class="feature"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg><?=$isRTL ? 'سهل الاستخدام' : 'Easy to use'?></div>
                <div class="feature"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg><?=$isRTL ? 'آمن' : 'Secure'?></div>
            </div>
            <?php if($error): ?><div class="error-msg"><?=$error?></div><?php endif; ?>
            <form method="post" action="signup.php">
                <div class="input-group">
                    <label class="input-label"><?=t('full_name')?></label>
                    <input type="text" name="username" class="input-field" placeholder="<?=$isRTL ? 'أدخل اسمك الكامل' : 'Enter your full name'?>">
                </div>
                <div class="input-group">
                    <label class="input-label"><?=t('email_address')?></label>
                    <input type="email" name="email" class="input-field" placeholder="<?=$isRTL ? 'أدخل بريدك الإلكتروني' : 'Enter your email'?>">
                </div>
                <div class="input-group">
                    <label class="input-label"><?=t('password')?></label>
                    <input type="password" name="password" class="input-field" placeholder="<?=$isRTL ? 'أنشئ كلمة مرور' : 'Create a password'?>">
                </div>
                <button type="submit" class="btn-primary"><?=t('signup')?></button>
            </form>
            <div class="footer-links">
                <?=$isRTL ? 'لديك حساب بالفعل؟' : 'Already have an account?'?> <a href="login.php"><?=t('login')?></a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php
return ob_get_clean();
}

function getDashboard($s,$orders){
$btn = palette_btn_bg();
$hdr = palette_header_bg();
$bg = theme_class()==='bride' ? '#fff7fb' : '#f6f9ff';
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Dashboard - Wedding Planner</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
<style>
body{margin:0;font-family:Inter,sans-serif;background:<?=$bg?>}
.header{background:<?=$hdr?>;padding:22px 28px;display:flex;justify-content:space-between;align-items:center}
.brand{font-family:"Playfair Display",serif;font-size:28px;color:#333}
.btn{border:none;padding:10px 16px;border-radius:12px;cursor:pointer;background:<?=$btn?>;color:#fff;font-weight:600}
.wrap{padding:34px}
.secTitle{font-family:"Playfair Display",serif;font-size:24px;margin:6px 0 18px;color:#333}
.statGrid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:18px;margin-bottom:24px}
.statCard{background:#fff;padding:22px;border-radius:18px;text-align:center;box-shadow:0 3px 16px rgba(0,0,0,.07)}
.statNum{font-size:32px;font-weight:700;margin-top:4px}
.table{width:100%;border-collapse:collapse;background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 3px 16px rgba(0,0,0,.07)}
.table th,.table td{padding:12px 14px;border-bottom:1px solid #eee;text-align:left}
.table th{background:#fafafa}
</style>
</head>
<body>
<div class="header">
    <div class="brand">Dashboard</div>
    <div style="display:flex;gap:10px">
        <a href="manage_items.php"><button class="btn">Manage Items</button></a>
        <a href="index.php"><button class="btn">Home</button></a>
        <a href="logout.php"><button class="btn">Logout</button></a>
    </div>
</div>
<div class="wrap">
    <div class="secTitle">Overview</div>
    <div class="statGrid">
        <div class="statCard"><div>Users</div><div class="statNum"><?=$s['users']?></div></div>
        <div class="statCard"><div>Admins</div><div class="statNum"><?=$s['admins']?></div></div>
        <div class="statCard"><div>Super Admins</div><div class="statNum"><?=$s['super_admins']?></div></div>
        <div class="statCard"><div>Services</div><div class="statNum"><?=$s['items']?></div></div>
        <div class="statCard"><div>Bundles</div><div class="statNum"><?=$s['bundles']?></div></div>
        <div class="statCard"><div>Orders</div><div class="statNum"><?=$s['orders']?></div></div>
        <div class="statCard"><div>Revenue</div><div class="statNum"><?=number_format($s['revenue'],2)?> $</div></div>
    </div>
    <div class="secTitle">Recent Orders</div>
    <table class="table">
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Total</th><th>Date</th></tr></thead>
        <tbody>
        <?php foreach($orders as $o): ?>
            <tr>
                <td><?=$o['id']?></td>
                <td><?=htmlspecialchars($o['customer_name'] ?? '')?></td>
                <td><?=htmlspecialchars($o['customer_email'] ?? '')?></td>
                <td><?=number_format($o['total'],2)?> $</td>
                <td><?=$o['created_at']?></td>
            </tr>
        <?php endforeach; ?>
        <?php if(!count($orders)): ?>
            <tr><td colspan="5" style="text-align:center;opacity:.6">No orders yet</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
<?php
return ob_get_clean();
}

function getMyOrdersPage($orders){
$btn = palette_btn_bg();
$hdr = palette_header_bg();
$theme = theme_class();
$accent = $theme === 'bride' ? '#d4849a' : '#6b7fd4';
$dir = getDir();
$isRTL = isRTL();
$lang = getCurrentLang();
ob_start();
?>
<!DOCTYPE html>
<html lang="<?=$lang?>" dir="<?=$dir?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=t('my_orders')?> - <?=t('site_name')?></title>
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;600;700&family=Cormorant+Garamond:wght@300;400;500;600&display=swap" rel="stylesheet">
<?php if($isRTL): ?>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
<?php endif; ?>
<style>
body{margin:0;font-family:<?=$isRTL ? '"Tajawal", sans-serif' : '"Cormorant Garamond", serif'?>;background:<?=$theme === 'bride' ? '#ffe6f2' : '#e8f0ff'?>;min-height:100vh;<?=$isRTL ? 'direction:rtl;text-align:right;' : ''?>}
.top{display:flex;justify-content:space-between;align-items:center;padding:16px 20px;background:<?=$hdr?>;backdrop-filter:blur(10px);box-shadow:0 10px 25px rgba(0,0,0,.08);position:sticky;top:0;z-index:50}
.brand{font-weight:400;font-size:28px;font-family:"Great Vibes",cursive;color:<?=$accent?>;letter-spacing:.04em;text-decoration:none}
.btn{border:none;padding:10px 16px;border-radius:999px;cursor:pointer;background:<?=$btn?>;color:#fff;font-weight:600;font-size:14px;box-shadow:0 8px 20px rgba(0,0,0,.12);text-decoration:none;display:inline-block}
.btn:hover{opacity:.92;transform:translateY(-1px)}
.container{max-width:1000px;margin:0 auto;padding:40px 24px}
.page-title{font-family:"Playfair Display",serif;font-size:32px;margin:0 0 8px;color:#333}
.page-subtitle{opacity:.7;font-size:16px;margin-bottom:32px}
.orders-list{display:flex;flex-direction:column;gap:20px}
.order-card{background:#fff;border-radius:20px;box-shadow:0 8px 30px rgba(0,0,0,.08);overflow:hidden}
.order-header{display:flex;justify-content:space-between;align-items:center;padding:20px 24px;background:<?=$hdr?>;flex-wrap:wrap;gap:12px}
.order-id{font-family:"Playfair Display",serif;font-size:20px;font-weight:600}
.order-date{opacity:.7;font-size:14px}
.order-total{font-weight:700;font-size:18px;color:<?=$accent?>}
.order-items{padding:20px 24px}
.order-item{display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid #f0f0f0}
.order-item:last-child{border-bottom:none}
.item-name{font-weight:500}
.item-details{opacity:.7;font-size:14px}
.item-price{font-weight:600;color:#333}
.empty-state{text-align:center;padding:80px 24px}
.empty-icon{font-size:64px;margin-bottom:16px;opacity:.5}
.empty-title{font-family:"Playfair Display",serif;font-size:24px;margin-bottom:8px}
.empty-text{opacity:.7;margin-bottom:24px}
.status-badge{padding:4px 12px;border-radius:999px;font-size:12px;font-weight:600;background:#e9f9ef;color:#146c2e}
</style>
</head>
<body>
<div class="top">
    <a href="index.php" class="brand"><?=t('site_name')?></a>
    <div style="display:flex;gap:10px;align-items:center">
        <a class="btn" href="index.php"><?=t('home')?></a>
        <a class="btn" href="logout.php"><?=t('logout')?></a>
    </div>
</div>

<div class="container">
    <h1 class="page-title"><?=t('my_orders')?></h1>
    <p class="page-subtitle"><?=t('order_history')?></p>
    
    <?php if(count($orders) > 0): ?>
    <div class="orders-list">
        <?php foreach($orders as $order): ?>
        <div class="order-card">
            <div class="order-header">
                <div>
                    <div class="order-id"><?=t('order')?> #<?=$order['id']?></div>
                    <div class="order-date"><?=date('F j, Y \a\t g:i A', strtotime($order['created_at']))?></div>
                </div>
                <div style="display:flex;align-items:center;gap:16px">
                    <span class="status-badge"><?=t('completed')?></span>
                    <div class="order-total"><?=number_format($order['total'],2)?> $</div>
                </div>
            </div>
            <div class="order-items">
                <?php 
                $items = getOrderItems($order['id']);
                foreach($items as $item): 
                ?>
                <div class="order-item">
                    <div>
                        <div class="item-name"><?=htmlspecialchars($item['item_title'])?></div>
                        <div class="item-details"><?=t('qty')?>: <?=$item['qty']?> × <?=number_format($item['item_price'],2)?> $</div>
                    </div>
                    <div class="item-price"><?=number_format($item['item_price'] * $item['qty'],2)?> $</div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <div class="empty-icon">📦</div>
        <h2 class="empty-title"><?=t('no_orders')?></h2>
        <p class="empty-text"><?=t('no_orders_desc')?></p>
        <a href="index.php" class="btn"><?=t('browse_services')?></a>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
<?php
return ob_get_clean();
}

function getManageItemsPage($items, $editItem = null, $message = ''){
$btn = palette_btn_bg();
$hdr = palette_header_bg();
$accent = theme_class() === 'bride' ? '#d4849a' : '#6b7fd4';
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Manage Items - Wedding Planner</title>
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;600;700&family=Cormorant+Garamond:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
body{margin:0;font-family:"Cormorant Garamond",serif;background:linear-gradient(135deg,#fff7fb,#f3f5ff);min-height:100vh}
.top{display:flex;justify-content:space-between;align-items:center;padding:16px 20px;background:<?=$hdr?>;backdrop-filter:blur(10px);box-shadow:0 10px 25px rgba(0,0,0,.08);position:sticky;top:0;z-index:50}
.brand{font-weight:400;font-size:28px;font-family:"Great Vibes",cursive;color:#b27a9c;letter-spacing:.04em;text-decoration:none}
.btn{border:none;padding:10px 16px;border-radius:999px;cursor:pointer;background:<?=$btn?>;color:#fff;font-weight:600;font-size:14px;box-shadow:0 8px 20px rgba(0,0,0,.12);text-decoration:none;display:inline-block}
.btn:hover{opacity:.92;transform:translateY(-1px)}
.btn-danger{background:#dc2626}
.btn-secondary{background:#6b7280}
.btn-small{padding:6px 12px;font-size:12px}
.container{max-width:1200px;margin:0 auto;padding:40px 24px}
.page-title{font-family:"Playfair Display",serif;font-size:32px;margin:0 0 8px;color:#333}
.page-subtitle{opacity:.7;font-size:16px;margin-bottom:32px}
.grid-layout{display:grid;grid-template-columns:350px 1fr;gap:30px}
@media(max-width:900px){.grid-layout{grid-template-columns:1fr}}
.form-card{background:#fff;border-radius:20px;padding:28px;box-shadow:0 8px 30px rgba(0,0,0,.08);height:fit-content}
.form-title{font-family:"Playfair Display",serif;font-size:20px;margin:0 0 20px;color:#333}
.form-group{margin-bottom:16px}
.form-label{display:block;font-weight:600;margin-bottom:6px;font-size:14px}
.form-input{width:100%;padding:12px;border:1px solid #ddd;border-radius:12px;font-size:15px;font-family:"Cormorant Garamond",serif;box-sizing:border-box}
.form-input:focus{outline:none;border-color:<?=$accent?>}
.form-select{width:100%;padding:12px;border:1px solid #ddd;border-radius:12px;font-size:15px;font-family:"Cormorant Garamond",serif;background:#fff}
.form-checkbox{display:flex;align-items:center;gap:10px}
.form-checkbox input{width:18px;height:18px}
.items-card{background:#fff;border-radius:20px;padding:28px;box-shadow:0 8px 30px rgba(0,0,0,.08)}
.items-title{font-family:"Playfair Display",serif;font-size:20px;margin:0 0 20px;color:#333}
.items-table{width:100%;border-collapse:collapse}
.items-table th,.items-table td{padding:12px;text-align:left;border-bottom:1px solid #f0f0f0}
.items-table th{font-weight:600;color:#666;font-size:13px;text-transform:uppercase;letter-spacing:0.05em}
.items-table tr:hover{background:#fafafa}
.item-icon{font-size:24px}
.item-title{font-weight:600}
.item-category{font-size:13px;padding:4px 10px;border-radius:999px;background:#f0f0f0;display:inline-block}
.item-category.bundle{background:#fef3c7;color:#92400e}
.item-price{font-weight:700;color:<?=$accent?>}
.item-actions{display:flex;gap:8px}
.message{padding:12px 16px;border-radius:12px;margin-bottom:20px}
.message.success{background:#e9f9ef;color:#146c2e}
.message.error{background:#fee2e2;color:#b91c1c}
.emoji-picker{display:flex;flex-wrap:wrap;gap:8px;margin-top:8px}
.emoji-btn{width:36px;height:36px;border:1px solid #ddd;border-radius:8px;background:#fff;cursor:pointer;font-size:18px;transition:all 0.2s}
.emoji-btn:hover{border-color:<?=$accent?>;transform:scale(1.1)}
.emoji-btn.selected{border-color:<?=$accent?>;background:<?=$hdr?>}
</style>
</head>
<body>
<div class="top">
    <a href="index.php" class="brand">Wedding Planner</a>
    <div style="display:flex;gap:10px;align-items:center">
        <a class="btn" href="dashboard.php">Dashboard</a>
        <a class="btn" href="index.php">Home</a>
        <a class="btn" href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h1 class="page-title">Manage Items</h1>
    <p class="page-subtitle">Add, edit, or remove services and bundles</p>
    
    <?php if($message): ?>
    <div class="message success"><?=htmlspecialchars($message)?></div>
    <?php endif; ?>
    
    <div class="grid-layout">
        <div class="form-card">
            <h2 class="form-title"><?=$editItem ? 'Edit Item' : 'Add New Item'?></h2>
            <form method="post" action="manage_items.php">
                <input type="hidden" name="action" value="<?=$editItem ? 'update' : 'add'?>">
                <?php if($editItem): ?>
                <input type="hidden" name="id" value="<?=$editItem['id']?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-input" required value="<?=$editItem ? htmlspecialchars($editItem['title']) : ''?>" placeholder="e.g. Wedding Photography">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Price ($)</label>
                    <input type="number" name="price" class="form-input" required step="0.01" min="0" value="<?=$editItem ? $editItem['price'] : ''?>" placeholder="e.g. 250">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select" required>
                        <option value="">Select category...</option>
                        <option value="Services" <?=($editItem && $editItem['category']==='Services')?'selected':''?>>Services</option>
                        <option value="Decor" <?=($editItem && $editItem['category']==='Decor')?'selected':''?>>Decor</option>
                        <option value="Food" <?=($editItem && $editItem['category']==='Food')?'selected':''?>>Food</option>
                        <option value="Photo" <?=($editItem && $editItem['category']==='Photo')?'selected':''?>>Photo</option>
                        <option value="Video" <?=($editItem && $editItem['category']==='Video')?'selected':''?>>Video</option>
                        <option value="Print" <?=($editItem && $editItem['category']==='Print')?'selected':''?>>Print</option>
                        <option value="Bundle" <?=($editItem && $editItem['category']==='Bundle')?'selected':''?>>Bundle</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-input" rows="3" placeholder="e.g. Professional photography for 8 hours with 2 photographers"><?=$editItem ? htmlspecialchars($editItem['description']) : ''?></textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Icon</label>
                    <input type="text" name="icon" id="iconInput" class="form-input" required value="<?=$editItem ? htmlspecialchars($editItem['icon']) : '🎁'?>" placeholder="Select below or paste emoji">
                    <div class="emoji-picker">
                        <?php 
                        $emojis = ['💐','🏛️','🍰','📸','🎥','📝','💒','💍','🎊','🎂','🥂','💝','🌸','✨','🎵','🚗'];
                        foreach($emojis as $e): 
                        ?>
                        <button type="button" class="emoji-btn" onclick="document.getElementById('iconInput').value='<?=$e?>'"><?=$e?></button>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-checkbox">
                        <input type="checkbox" name="is_bundle" value="1" <?=($editItem && $editItem['is_bundle'])?'checked':''?>>
                        <span>This is a bundle/package</span>
                    </label>
                </div>
                
                <div style="display:flex;gap:10px;margin-top:24px">
                    <button type="submit" class="btn"><?=$editItem ? 'Update Item' : 'Add Item'?></button>
                    <?php if($editItem): ?>
                    <a href="manage_items.php" class="btn btn-secondary">Cancel</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <div class="items-card">
            <h2 class="items-title">All Items (<?=count($items)?>)</h2>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($items as $item): ?>
                    <tr>
                        <td class="item-icon"><?=htmlspecialchars($item['icon'])?></td>
                        <td class="item-title"><?=htmlspecialchars($item['title'])?></td>
                        <td><span class="item-category <?=$item['is_bundle']?'bundle':''?>"><?=htmlspecialchars($item['category'])?></span></td>
                        <td class="item-price"><?=number_format($item['price'],2)?> $</td>
                        <td class="item-actions">
                            <a href="manage_items.php?edit=<?=$item['id']?>" class="btn btn-small btn-secondary">Edit</a>
                            <form method="post" action="manage_items.php" style="display:inline" onsubmit="return confirm('Delete this item?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?=$item['id']?>">
                                <button type="submit" class="btn btn-small btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(!count($items)): ?>
                    <tr><td colspan="5" style="text-align:center;opacity:.6;padding:40px">No items yet. Add your first item!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
<?php
return ob_get_clean();
}