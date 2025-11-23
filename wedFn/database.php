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
  is_bundle TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Insert default items if table is empty
$check = $conn->query("SELECT COUNT(*) as c FROM items");
$row = $check->fetch_assoc();
if(intval($row['c']) === 0){
    $conn->query("INSERT INTO items(title,price,category,icon,is_bundle) VALUES
        ('Welcome Set',150,'Services','💐',0),
        ('Hall Design',300,'Decor','🏛️',0),
        ('Wedding Cake',120,'Food','🍰',0),
        ('Photography',250,'Photo','📸',0),
        ('Videography',350,'Video','🎥',0),
        ('Printables',80,'Print','📝',0),
        ('Classic Hall & Dinner',2400,'Bundle','💒',1),
        ('Premium Hall + Photo',4100,'Bundle','💍',1),
        ('All-Inclusive Celebration',5600,'Bundle','🎊',1)
    ");
}