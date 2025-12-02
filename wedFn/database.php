<?php
$host = "localhost";
$username = "root";
$password = "root";
$db_name = "wedding_planner";
$port = 3306; // Change to 8889 if MAMP uses that port

$conn = new mysqli($host, $username, $password, '', $port);
if($conn->connect_error){ die("Connection failed: ".$conn->connect_error); }
$conn->query("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$conn->select_db($db_name);
$conn->query("CREATE TABLE IF NOT EXISTS users(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('user','admin','super_admin') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$conn->query("CREATE TABLE IF NOT EXISTS remember_tokens(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  token VARCHAR(255) NOT NULL,
  expires_at DATETIME NOT NULL,
  INDEX(user_id),
  CONSTRAINT fk_rt_user FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$conn->query("CREATE TABLE IF NOT EXISTS orders(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NULL,
  customer_name VARCHAR(120) NULL,
  customer_email VARCHAR(120) NULL,
  total DECIMAL(10,2) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$conn->query("CREATE TABLE IF NOT EXISTS order_items(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  item_title VARCHAR(120) NOT NULL,
  item_price DECIMAL(10,2) NOT NULL,
  qty INT NOT NULL,
  CONSTRAINT fk_oi_order FOREIGN KEY(order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$conn->query("CREATE TABLE IF NOT EXISTS items(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(120) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  category VARCHAR(50) NOT NULL,
  icon VARCHAR(10) DEFAULT '🎁',
  description TEXT,
  is_bundle TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Insert default items if table is empty
$check = $conn->query("SELECT COUNT(*) as c FROM items");
$row = $check->fetch_assoc();
if(intval($row['c']) === 0){
    $conn->query("INSERT INTO items(title,price,category,icon,description,is_bundle) VALUES
        ('Grand Ballroom',1200,'Services','🏰','Luxurious 500-guest capacity hall with crystal chandeliers and marble floors',0),
        ('Garden Venue',800,'Services','🌸','Beautiful outdoor garden space, fits 300 guests with natural scenery',0),
        ('Rooftop Terrace',950,'Services','🌆','Modern rooftop venue with city views, capacity for 250 guests',0),
        ('Beachside Pavilion',1100,'Services','🏖️','Stunning beach location with ocean views, accommodates 200 guests',0),
        ('Classic Banquet Hall',700,'Services','🎭','Traditional elegant hall, perfect for 400 guests',0),
        
        ('Floral Arch',350,'Decor','🌺','Gorgeous floral archway with roses and seasonal flowers',0),
        ('Crystal Centerpieces',450,'Decor','💎','Set of 25 sparkling crystal centerpieces with LED lighting',0),
        ('Elegant Draping',280,'Decor','🎀','Luxurious fabric draping for walls and ceiling',0),
        ('Chair Covers & Sashes',200,'Decor','💺','Complete set for 300 chairs with satin sashes',0),
        ('LED Uplighting',320,'Decor','💡','Professional LED uplighting package, 20 fixtures',0),
        ('Backdrop Design',420,'Decor','🎨','Custom photo backdrop with floral and lighting elements',0),
        
        ('Gourmet Buffet',45,'Food','🍽️','Per person - Premium buffet with international cuisine',0),
        ('Plated Dinner',65,'Food','🥘','Per person - 3-course fine dining experience',0),
        ('Wedding Cake - 3 Tier',380,'Food','🎂','Elegant 3-tier cake serves 100, custom design',0),
        ('Wedding Cake - 5 Tier',680,'Food','🍰','Spectacular 5-tier cake serves 200, premium design',0),
        ('Appetizer Station',25,'Food','🥗','Per person - Variety of hot and cold appetizers',0),
        ('Chocolate Fountain',280,'Food','🍫','Large chocolate fountain with fruits and treats',0),
        ('Coffee & Dessert Bar',18,'Food','☕','Per person - Specialty coffee and dessert selection',0),
        
        ('Full Day Photography',850,'Photo','📸','8 hours coverage, 2 photographers, 500+ edited photos',0),
        ('Half Day Photography',550,'Photo','📷','4 hours coverage, 1 photographer, 250+ edited photos',0),
        ('Drone Photography',350,'Photo','🚁','Aerial shots and video, 2 hours coverage',0),
        ('Photo Booth',420,'Photo','📹','4 hours with props, unlimited prints and digital copies',0),
        ('Engagement Shoot',380,'Photo','💑','2-hour pre-wedding photoshoot at location of choice',0),
        
        ('Cinematic Video',1200,'Video','🎬','Full day coverage with cinematic editing, 15-20 min highlight',0),
        ('Documentary Video',950,'Video','🎥','Full ceremony and reception coverage, 30-40 min video',0),
        ('Highlight Reel',450,'Video','📽️','3-5 minute highlight video with music',0),
        ('Live Streaming',380,'Video','📡','Professional live stream to 500 viewers',0),
        
        ('Invitation Suite',8,'Print','💌','Per set - Save the date, invitation, RSVP card',0),
        ('Thank You Cards',4,'Print','🙏','Per card - Premium thank you cards with envelopes',0),
        ('Menu Cards',6,'Print','📋','Per card - Elegant menu design for guest tables',0),
        ('Table Numbers',45,'Print','🔢','Complete set for 30 tables with holders',0),
        ('Ceremony Programs',3,'Print','📄','Per program - Order of ceremony booklets',0),
        ('Welcome Sign',120,'Print','🪧','Large custom welcome sign with easel',0),
        
        ('Diamond Package',5800,'Bundle','💎','Grand Ballroom + Full Photography & Video + Gourmet buffet for 200 guests',1),
        ('Golden Package',4200,'Bundle','👑','Garden Venue + Photography + Plated dinner for 150 guests',1),
        ('Silver Package',3100,'Bundle','🥈','Banquet Hall + Half-day photography + Buffet for 100 guests',1),
        ('Beach Romance',4800,'Bundle','🌊','Beachside Pavilion + Full video + Photography + Reception for 150',1),
        ('Garden Dream',3800,'Bundle','🌹','Garden Venue + Decor package + Photography + Dinner for 150',1)
    ");
}