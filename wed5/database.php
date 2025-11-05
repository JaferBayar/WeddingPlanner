<?php
$host = "localhost";
$username = "root";
$password = "root";           
$db_name = "wedding_planner";
$port = 8889;                 
$socket = "/Applications/MAMP/tmp/mysql/mysql.sock";

$conn = new mysqli($host, $username, $password, "", $port, $socket);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if (!$conn->query($sql)) {
    die("Error creating database: " . $conn->error);
}

$conn->select_db($db_name);
$conn->set_charset("utf8mb4");

// Users table
$users_table = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Categories table
$categories_table = "CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Services table
$services_table = "CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_service (category_id, name),
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Remember tokens table
$remember_table = "CREATE TABLE IF NOT EXISTS remember_tokens (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token_hash CHAR(64) NOT NULL,
    user_agent_hash CHAR(64) DEFAULT NULL,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX(user_id),
    UNIQUE KEY(token_hash),
    INDEX(expires_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

$tables = [$users_table, $categories_table, $services_table, $remember_table];
foreach ($tables as $table_sql) {
    if (!$conn->query($table_sql)) {
        die("Error creating table: " . $conn->error);
    }
}

// Insert categories (only if not exists)
$categories = ['هۆل', 'خواردن', 'دیکۆراتات', 'ستران بێژ', 'وێنەگر'];
foreach ($categories as $category) {
    $check = "SELECT id FROM categories WHERE name = ?";
    $stmt = $conn->prepare($check);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO categories (name) VALUES (?)";
        $stmt2 = $conn->prepare($sql);
        $stmt2->bind_param("s", $category);
        $stmt2->execute();
        $stmt2->close();
    }
    $stmt->close();
}

// Insert services (only if not exists) - FIXED TO PREVENT DUPLICATES
$services = [
    [1, 'کۆردستان هۆل', 1250000],
    [1, 'دوهوک هۆل', 1000000],
    [1, 'زاخو هۆل', 800000],
    [1, 'کۆرد هۆل', 600000],
    [2, 'کەباب', 15000],
    [2, 'برنج و مرىشک', 15000],
    [2, 'برنج و گۆشت', 20000],
    [2, 'مرىشکا بژارتى', 15000],
    [2, 'گۆشتێ بژارتى', 20000],
    [3, 'ئاساىێ', 80000],
    [3, 'ناڤەنجى', 120000],
    [3, 'VIP', 250000],
    [4, 'عارف چۆپان', 1400000],
    [4, 'سێربەست مالتاىێ', 1100000],
    [4, 'دیار حەسەن', 1000000],
    [4, 'عەبدللە هەرکی', 900000],
    [4, 'رۆمی هەرکی', 850000],
    [5, 'ستۆدیۆ دۆهۆک', 350000],
    [5, 'ستۆدیۆ زاخۆ', 400000],
    [5, 'ستۆدیۆ کۆرد', 800000]
];

foreach ($services as $service) {
    // Check if service already exists
    $check = "SELECT id FROM services WHERE category_id = ? AND name = ?";
    $stmt = $conn->prepare($check);
    $stmt->bind_param("is", $service[0], $service[1]);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        // Insert only if doesn't exist
        $sql = "INSERT INTO services (category_id, name, price) VALUES (?, ?, ?)";
        $stmt2 = $conn->prepare($sql);
        $stmt2->bind_param("isd", $service[0], $service[1], $service[2]);
        $stmt2->execute();
        $stmt2->close();
    }
    $stmt->close();
}

// Create demo user (only if not exists)
$check_user = "SELECT id FROM users WHERE email = 'demo@test.com'";
$result = $conn->query($check_user);

if ($result->num_rows == 0) {
    $demo_password = password_hash('123456', PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, password) VALUES ('demo_user', 'demo@test.com', ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $demo_password);
    $stmt->execute();
    $stmt->close();
}

// Clean up expired remember tokens
$conn->query("DELETE FROM remember_tokens WHERE expires_at < NOW()");
?>